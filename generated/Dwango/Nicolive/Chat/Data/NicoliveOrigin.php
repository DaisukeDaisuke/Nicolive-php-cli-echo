<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/NicoliveOrigin.proto

namespace Dwango\Nicolive\Chat\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.NicoliveOrigin</code>
 */
class NicoliveOrigin extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.NicoliveOrigin.Chat chat = 1;</code>
     */
    private $chat = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Dwango\Nicolive\Chat\Data\NicoliveOrigin\Chat $chat
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\NicoliveOrigin::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.NicoliveOrigin.Chat chat = 1;</code>
     * @return \Dwango\Nicolive\Chat\Data\NicoliveOrigin\Chat
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.NicoliveOrigin.Chat chat = 1;</code>
     * @param \Dwango\Nicolive\Chat\Data\NicoliveOrigin\Chat $var
     * @return $this
     */
    public function setChat($var)
    {
        GPBUtil::checkMessage($var, \Dwango\Nicolive\Chat\Data\NicoliveOrigin_Chat::class);
        $this->chat = $var;

        return $this;
    }

}

