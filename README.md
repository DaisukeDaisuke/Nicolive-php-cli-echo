# Nicolive-php-cli-echo
帰ってきたニコニコのニコ生コメントサーバーからソースコードで指定したライブのコメントとデバック情報をリアルタイムでコンソールに垂れ流します。
cli限定です。  
個人による研究目的かつReactPHP製です  
このプログラムは[Nicolive-API](https://github.com/Kiikurage/Nicolive-API)のprotoファイルから生成されたコンテンツが含まれています。  



## 実行方法

phpのバイナリをダウンロード、展開し`vc_redist.x64.exe`をインストールしておきます`  
```
https://github.com/pmmp/PHP-Binaries/releases/tag/php-8.2-latest
```
次にcomposerをダウンロードします。
```
https://getcomposer.org/download/latest-stable/composer.phar
```

リポジトリをクローンし、`main.php`を開き、下記の部分を好きなユーザーページ(/user/??????)またはライブid`lv345542146`に置き換えます。
```php
$url = 'lv345542146';
```

次のコマンドを実行し、依存関係をダウンロードして所定の場所に配置します。
```
.\bin\php\php.exe composer.phar install
```

次のコマンドを実行し、プログラムを実行してニコニコのコメントサーバーに接続します。
```
\bin\php\php.exe main.php
```

`./data/`にログファイル(パケットダンプ)が残るので、不要な場合は適度に削除してください
