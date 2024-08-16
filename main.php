<?php

require 'vendor/autoload.php';

use Ratchet\Client\Connector;
use React\Promise\Timer\TimeoutException;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http\Browser;
use React\HttpClient\Client;
use React\HttpClient\Response;
use React\HttpClient\Request;
use pocketmine\utils\BinaryStream;
use Ratchet\Client\WebSocket;
use Dwango\Nicolive\Chat\Service\Edge\ChunkedEntry;
use Dwango\Nicolive\Chat\Service\Edge\ChunkedMessage;
use pocketmine\errorhandler\ErrorToExceptionHandler;
use Dwango\Nicolive\Chat\Data\Enquete\Choice;

class BinaryStreamChunk extends BinaryStream{
	private function decodeVarint(){
		$value = null;
		$shift = 0;
		$offset = $this->getOffset();
		$length = strlen($this->getBuffer()) - 1;

		do{
			if($length < $offset){
				return $value;
			}
			$byte = $this->getByte();
			$more = ($byte & 128) !== 0;
			$value |= ($byte & 127) << $shift;
			if($more){
//				$offset++;
				$shift += 7;
			}
		}while($more);

		return $value;
	}

	public function read(){
		$read = false;
		$offset = $this->getOffset();
		while(true){
			$result = $this->decodeVarint();
			if($result === null){
				break;
			}
			$start = $this->getOffset();
			$end = $start + $result;

			if((strlen($this->getBuffer())) < $end){
				if(!$read){
					$this->setOffset($offset);
				}
				break;
			}
			$read = true;
			yield $this->get($end - $start);
		}
	}

	public function addBuffer(string $data) : void{
		$this->put($data);
	}
}

ErrorToExceptionHandler::set();


function resolveUserID($url): ?string{
	if(!preg_match('/user\/(\d+)/', $url, $match)){
		return null;
	}
	$userId = $match[1];

	echo "info > get: https://live.nicovideo.jp/front/api/v1/user-broadcast-history?providerId={$userId}&providerType=user&limit=1\n";
	$api = file_get_contents("https://live.nicovideo.jp/front/api/v1/user-broadcast-history?providerId={$userId}&providerType=user&limit=1");
	if($api === false){
		return null;
	}
	try{
		$array = json_decode($api, true, JSON_THROW_ON_ERROR);
	}catch(\Exception $e){
		return null;
	}
	$record  = $array['data']['programsList'][0] ?? null;
	var_dump($record['program']["title"]);
	if($record === null){
		return null;
	}
	return $record['id']['value'];
}


$url = 'lv345566270';
$url = "https://www.nicovideo.jp/user/5299668/live_programs";
$id = resolveUserID($url);

$wssurl = getwssurl($id ?? $url);
if($wssurl === ""|| $wssurl === null){
	throw new RuntimeException("Error: url not found or ended stream");
}
$test = new nikowss($wssurl, $id ?? $url);
$loop = $test->getLoop();
//$loop->addTimer(10, function () use ($test) {
//	$test->dodisConnect();
//});
$test->startLoop();



function getwssurl(string $id) : ?string{
	echo "info > get: https://live.nicovideo.jp/watch/".$id."\n";
	$htmlContent = file_get_contents("https://live.nicovideo.jp/watch/".$id);

// DOMDocumentを使ってHTMLを解析
	$dom = new DOMDocument;
	libxml_use_internal_errors(true); // HTML解析時のエラーを抑制
	$dom->loadHTML($htmlContent);
	libxml_clear_errors();

// #embedded-data要素を取得
	$element = $dom->getElementById('embedded-data');

	if($element){
		// data-props属性の値を取得
		$jsonData = $element->getAttribute('data-props');

		// JSONをパースしてPHPの連想配列に変換
		try{
			$dataObject = json_decode($jsonData, true, JSON_THROW_ON_ERROR);
			return $dataObject["site"]["relive"]["webSocketUrl"];
		}catch(Exception $e){
			echo "Failed to parse JSON data: ".$e->getMessage();
			return null;
		}
	}else{
		echo "Error: Element with id 'embedded-data' not found.";
		return null;
	}

}


class nikowss{
	private LoopInterface $loop;
	private WebSocket $conn;
	private ?string $messageServerUri = null;
	private Connector $connector;
	private ?MessageServerClient $messageServerClient = null;
	/** @var SegmentServerClient[] SegmentServerClient */
	private array $segmentServerClient = [];

	private bool $isConnected = false;

	private array $emotionBuffer = [];
	public function __construct(private readonly string $wssurl, private readonly string $htmlname){
		$this->loop = Factory::create();
	}


	public function onUpdate(): void{
		foreach($this->emotionBuffer as $key => $count){
			if($count < 1){
				echo "エモーション: ".$key."\n";
			}else{
				echo "エモーション: ".$key." x".$count."\n";
			}
		}
		$this->emotionBuffer = [];
	}

	private function processChuknkEntry(ChunkedEntry $entry) : void{
		switch(true){
			case $entry->getBackward() !== null:
			case $entry->getPrevious() !== null;
				//無視
				break;
			case $entry->getSegment() !== null:
				$url = $entry->getSegment()->getUri();
				if($url === null){
					break;
				}
				$segmentServerClient = new  segmentServerClient($this->loop, $this->htmlname, fn(ChunkedMessage $message) => $this->processChunkedMessage($message));
				$segmentServerClient->ConnectToSegment($url);
				$this->segmentServerClient[] = $segmentServerClient;
				break;
			case $entry->getNext() !== null:
				$this->messageServerClient->setNextStreamAt($entry->getNext()->getAt());
				break;
		}
	}

	public function toPercentage(?int $number) {
		if($number === null){
			return 0.0;
		}
		// パーセント計算
		$percentage = ($number / 1000) * 100;

		// 結果を小数点以下1桁でフォーマット
		return number_format($percentage, 1) . '%';
	}

	private function processChunkedMessage(ChunkedMessage $message){
		if($message->getMessage() !== null){
			if($message->getMessage()->getChat() !== null){
				$text = $message->getMessage()->getChat()->getContent().", ".($message->getMessage()->getChat()->getAccountStatus() === 0 ? "normal" : "premium");
				$chat = $message->getMessage()->getChat();
				if($chat->getName() !== null&&$chat->getName() !== ""){
					//名札on
					echo $text.", ".$chat->getName()."(".$chat->getRawUserId().")\n";
				}else{
					//名札off
					echo $text.", ".$chat->getHashedUserId()."\n";
				}
			}elseif($message->getMessage()?->getSimpleNotification() !== null){
				$notification = $message->getMessage()->getSimpleNotification();
				if($notification->getProgramExtended() !== null&&$notification->getProgramExtended() !== ""){
					echo "! 告知: ".$notification?->getProgramExtended()."\n";
				}elseif($notification->getIchiba() !== null&&$notification->getIchiba() !== ""){
					echo "! ニコゲー開始告知: 【放送ネタ】".$notification->getIchiba()."\n";
				}elseif($notification->getEmotion() !== null&&$notification->getEmotion() !== ""){
					var_dump($notification->getEmotion());//未実装
					$this->emotionBuffer[$notification->getEmotion()] ??= 0;
					++$this->emotionBuffer[$notification->getEmotion()];
				}elseif($notification->getRankingIn() !== ""&&$notification->getRankingIn() !== ""){
					echo "! ".$notification->getRankingIn()."\n"; // 第22位にランクインしました
				}elseif($notification->getVisited() !== null&&$notification->getVisited() !== ""){
					echo "! ".$notification->getVisited()."\n";  //「ゲーム」が好きな1人が来場しました
				}else{
					var_dump($message);
				}
			}elseif($message->getMessage()?->getGift() !== null){
				$gift = $message->getMessage()->getGift();
				echo "! ギフトを検知しました: ".($gift->getMessage() ?? "")."\n";
				var_dump($message);
			}elseif($message->getMessage()?->getNicoad() !== null){
				$nicoad = $message->getMessage()->getNicoad();
				var_dump($message);
				//if($nicoad->getVersions() === "v0")
				echo "! ニコニ広告を検知しました: \n";
			}
		}elseif($message->getState() !== null){
			$announce = $message->getState()?->getMarque()?->getDisplay()?->getOperatorComment();
			if($announce !== null){
				echo "! 放送者コメント: ".$announce->getContent()." : ".$announce->getLink()."\n";
			}
			$vote = $message->getState()->getEnquete();
			if($vote?->getStatus() !== null){
				$question = $vote->getQuestion();
				$choices = $vote->getChoices();
				$status = match ($vote->getStatus()) {
					0 => "close",
					1 => "start",
					2 => "result",
				};

				$result = "/vote ".$status." ".$question." ";
				/**
				 * @var Choice $item
				 */
				foreach($choices->getIterator() as $item){
					if($status === "start"){
						$result .= ($item?->getDescription() ?? ""). " ";
					}elseif($status === "result"){
						$result .= ($item?->getDescription() ?? ""). "(".$this->toPercentage($item->getPerMille())."%) ";
					}
				}
				if($status !== "close"){
					echo "! ".trim($result)."\n";
				}
			}
		}else{
			//var_dump($message);
		}

	}

	public function garbageCollectionSegmentClient() : void{
		foreach($this->segmentServerClient as $key => $item){
			if($item->isCloned()){
				//echo "garbageCollectioning segmentServerClient\n";
				unset($this->segmentServerClient[$key]);
			}
		}
		$this->segmentServerClient = array_values($this->segmentServerClient);
	}

	public function startLoop(): ?LoopInterface{
		if($this->isConnected()){
			return null;
		}
		$this->setIsConnected(true);

		$this->loop->addPeriodicTimer(1, function(){
			$this->garbageCollectionSegmentClient();
		});

		$this->loop->addPeriodicTimer(1, fn() => $this->onUpdate());


		// WebSocketクライアントの作成
		$this->connector = new Connector($this->loop);

		$this->messageServerClient = new MessageServerClient($this->loop, $this->htmlname, function(ChunkedEntry $entry){
			$this->processChuknkEntry($entry);
		}, true);

		($this->connector)($this->wssurl)->then(function(WebSocket $conn){
			$this->conn = $conn;
			echo "info > Connected to WebSocket server!\n";

			// 接続時にメッセージを送信
			$message = json_encode([
				"type" => "startWatching",
				"data" => [
					"stream" => [
						"quality" => "high",
						"protocol" => "hls",
						"latency" => "low",
						"chasePlay" => false
					],
					"room" => [
						"protocol" => "webSocket",
						"commentable" => false
					],
					"reconnect" => false
				]
			]);
			$conn->send($message);
			//echo "Message sent: $message\n";

			// メッセージ受信時の処理
			$conn->on('message', function($message){
				//echo "Received message: $message\n";
				// Raw messageの処理
				$this->onRawMessage($message);
			});

			// 接続エラー時の処理
			$conn->on('error', function($e){
				echo "WebSocket Error: ".$e->getMessage()."\n";
			});

			// 接続が閉じられた時の処理
			$conn->on('close', function($code = null, $reason = null){
				echo "WebSocket connection closed: Code $code, Reason: $reason\n";
			});

		}, function($e){
			echo "Could not connect to WebSocket server: ".$e->getMessage()."\n";
			$this->loop->stop();
			$this->dodisConnect();
		});
		$this->loop->run();
		return $this->loop;
	}

	/**
	 * ニコ生から切断し、このクラスのメインループを終了します。
	 *
	 * @return bool
	 */
	public function dodisConnect(): bool{
		if(!$this->isConnected()){
			return false;
		}
		foreach($this->segmentServerClient as $client){
			if($client->isCloned()){
				continue;
			}
			$client->disconnect();
		}
		$this->messageServerClient?->disconnect();
		$this->conn->close(1000, "Forced Disconnect of Client");
		$this->loop->stop();
		return true;
	}

	public function onMessageServerMessage(array $url) : void{
		$this->messageServerUri = $url["viewUri"];
		echo "info > found comment server: ".$this->messageServerUri."\n";
		$this->messageServerClient->connectToMessageServer($this->messageServerUri);
	}

	public function startPinger(int $sec) : void{
		//var_dump("startPinger $sec");
		$this->loop->addPeriodicTimer($sec, function() use ($sec){
			$pingMessage = json_encode(["type" => "keepSeat"]);
			$this->conn->send($pingMessage);
			//echo "send startPinger $sec.\n";
		});

	}


	private function onRawMessage($message){
		//echo "Processing raw message: $message\n";

		$message = json_decode($message, true);
		//var_dump($message);
		switch($message["type"]){
			case "disconnect":
				if(($message["data"]["reason"] ?? null) === "END_PROGRAM"){
					echo "配信が終了しました。\m";
					$this->dodisconnect();
				}
				break;
			case "error":
				if(($message["body"]["code"] ?? null) === "CONNECT_ERROR"){
					echo "このライブストリームは生放送中ではありません。\n"; //認識urlを再取得する
					$this->dodisConnect();
					return;
				}
				break;
			case "messageServer":
				$this->onMessageServerMessage($message["data"]);
				break;
			case "seat":
				$this->startPinger($message["data"]["keepIntervalSec"]);
				break;
			case "ping":
				$this->onPing();
				break;
			default:// ignored
		}
	}

	private function onPing() : void{
		$this->conn->send(json_encode(["type" => "pong"]));
		//echo "pong sended\n";
	}

	public function isConnected() : bool{
		return $this->isConnected;
	}

	private function setIsConnected(bool $isConnected) : void{
		$this->isConnected = $isConnected;
	}

	public function getLoop() : LoopInterface{
		return $this->loop;
	}
}


class SegmentServerClient{
	private static int $debugcounter = 0;
	private static $hasConnected = false;
	private string $segmentServerUri;
	private ?Request $request;
	private ?BinaryStreamChunk $stream = null;
	private bool $isCloned = false;

	public function __construct(private readonly LoopInterface $loop, private readonly string $htmlname, private readonly \Closure $onDataReceived){

	}

	public static function isHasConnected() : bool{
		return self::$hasConnected;
	}

	public static function setHasConnected(bool $hasConnected) : void{
		self::$hasConnected = $hasConnected;
	}

	private function connect(){
		if(!self::isHasConnected()){
			echo "info > Connect to the first segment server!\n";
		}
		if(!isset($this->segmentServerUri)){
			throw new \RuntimeException("segmentServerUri is null");
		}
		$this->setIsCloned(false);
		if(isset($this->request)){
			$this->disconnect();
		}
		$this->mainLoop();
	}

	private function mainLoop(){
		$this->stream = new BinaryStreamChunk();
		$client = new Client($this->loop);
		//echo "GET: ".$this->segmentServerUri."\n";
		$this->request = $client->request('GET', $this->segmentServerUri);

		$this->request->on('response', function(Response $response){
			if(!self::isHasConnected()){
				echo "info > Ready to receive comments!\n";
				self::setHasConnected(true);
			}

			if($response->getCode() !== 200){
				echo "Response received with status code: ".$response->getCode().PHP_EOL;
			}

			$response->on('data', function($chunk){
				$this->stream->addBuffer($chunk);
				$this->debugLoging();
				$this->tryReadChunks();
				//echo "Received chunk: ".strlen($chunk).PHP_EOL;
			});

			$response->on('end', function(){
				//echo "Stream ended.".PHP_EOL;
				$this->disconnect();
			});
		});

		$this->request->on('error', function(\Exception $e){
			echo "error: ".$e;
		});

		$this->request->end();
	}

	public function tryReadChunks() : void{
		foreach($this->stream->read() as $binaryData){
			//var_dump("found message chunk: ". strlen($binaryData));
			$chunkedEntry = new ChunkedMessage();
			$chunkedEntry->mergeFromString($binaryData);
			($this->onDataReceived)($chunkedEntry);
			//$this->processChunkEntry($chunkedEntry);
		}
	}

	public function ConnectToSegment(string $segmentServerUri) : void{
		$this->disconnect();
		$this->segmentServerUri = $segmentServerUri;
		$this->connect();
	}

	public function disconnect(){
		if(isset($this->request)){
			$this->debugLoging();
			$this->request?->close();
			$this->request = null;
			$this->stream = null;
			++self::$debugcounter;
			$this->setIsCloned(true);
		}
	}

	public function debugLoging() : void{
		$substring = substr($this->segmentServerUri, strlen("https://mpn.live.nicovideo.jp/data/segment/v4/"), 10);
		$substring = str_replace(["/", "\\", "."], "", $substring);
		@mkdir(__DIR__."/data/".$this->htmlname."/segment/", 0777, true);
		file_put_contents(__DIR__."/data/".$this->htmlname."/segment/".$substring."_".(self::$debugcounter).".bin", $this->stream->getBuffer());
		//echo "saveed chunks: ".(__DIR__."/data/".$this->htmlname."/segment/".$substring."_".(self::$debugcounter).".bin"),PHP_EOL;

	}

	public function isCloned() : bool{
		return $this->isCloned;
	}

	public function setIsCloned(bool $isCloned) : void{
		$this->isCloned = $isCloned;
	}
}

class MessageServerClient{
	private static int $debugcounter = 0;
	private static $hasConnected = false;
	private string $nextStreamAt = "now";
	private ?string $messageServerUri = null;

	private ?Request $request = null;
	private ?BinaryStreamChunk $stream = null;

	public function __construct(private readonly LoopInterface $loop, private readonly string $htmlname, private readonly \Closure $onDataReceived){

	}

	public static function isHasConnected() : bool{
		return self::$hasConnected;
	}

	public static function setHasConnected(bool $hasConnected) : void{
		self::$hasConnected = $hasConnected;
	}

	public function connectToMessageServer(string $messageServerUri){
		$this->disconnect();
		$this->messageServerUri = $messageServerUri;
		$this->connect();
	}

	private function connect(){
		if(!self::isHasConnected()){
			echo "info > Connect to the first message server!\n";
			self::setHasConnected(true);
		}

		if(!isset($this->messageServerUri)){
			throw new \RuntimeException("messageServerUri is null");
		}
		if(isset($this->request)){
			$this->disconnect();
		}
		$this->mainLoop();
	}

	private function mainLoop(){
		$this->stream = new BinaryStreamChunk();
		$client = new Client($this->loop);
		//echo "GET: ".$this->messageServerUri."?at=".$this->nextStreamAt."\n";
		$this->request = $client->request('GET', $this->messageServerUri."?at=".$this->nextStreamAt);

		$this->request->on('response', function(Response $response){
			if($response->getCode() !== 200){
				echo "Response received with status code: ".$response->getCode().PHP_EOL;
			}

			$response->on('data', function($chunk){
				$this->stream->addBuffer($chunk);
				$this->debugLoging();
				$this->tryReadChunks();
				//echo "Received chunk: ".strlen($chunk).PHP_EOL;
			});

			$response->on('end', function(){
				//echo "Stream ended.".PHP_EOL;
				$this->disconnect();
				$this->mainLoop();
			});
		});

		$this->request->on('error', function(\Exception $e){
			echo "error: ".$e;
		});

		$this->request->end();
	}

	public function tryReadChunks() : void{
		foreach($this->stream->read() as $binaryData){
			//var_dump("found entry chunk: ". strlen($binaryData));
			$chunkedEntry = new ChunkedEntry();
			$chunkedEntry->mergeFromString($binaryData);
			($this->onDataReceived)($chunkedEntry);
			//$this->processChunkEntry($chunkedEntry);
		}
		$this->tryClearBuffer();
	}

	public function tryClearBuffer(): void{
		if(strlen($this->stream->getBuffer()) === $this->stream->getOffset()){
			$this->stream = new BinaryStreamChunk();
		}
	}

	public function disconnect(){
		if(isset($this->request)){
			$this->debugLoging();
			$this->request?->close();
			$this->request = null;
			$this->stream = null;
			++self::$debugcounter;
		}
	}

	public function debugLoging() : void{
		$substring = substr($this->messageServerUri, strlen("https://mpn.live.nicovideo.jp/api/view/v4/"), 10);
		$substring = str_replace(["/", "\\", "."], "", $substring);
		@mkdir(__DIR__."/data/".$this->htmlname."/message/", 0777, true);
		file_put_contents(__DIR__."/data/".$this->htmlname."/message/".$substring."_".(self::$debugcounter).".bin", $this->stream->getBuffer());
		//echo "saveed chunks: ".(__DIR__."/data/".$this->htmlname."/message/".$substring."_".(self::$debugcounter).".bin"),PHP_EOL;

	}

	public function getNextStreamAt() : string{
		return $this->nextStreamAt;
	}

	public function setNextStreamAt(string $nextStreamAt) : void{
		$this->nextStreamAt = $nextStreamAt;
	}

}

