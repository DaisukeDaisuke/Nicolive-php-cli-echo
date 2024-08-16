<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/Redirect.proto

namespace Dwango\Nicolive\Chat\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.Redirect</code>
 */
class Redirect extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string uri = 1;</code>
     */
    private $uri = '';
    /**
     * Generated from protobuf field <code>string message = 2;</code>
     */
    private $message = '';
    /**
     * Generated from protobuf field <code>.google.protobuf.Duration wait = 4;</code>
     */
    private $wait = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uri
     *     @type string $message
     *     @type \Google\Protobuf\Duration $wait
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\Redirect::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string uri = 1;</code>
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Generated from protobuf field <code>string uri = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->uri = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string message = 2;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Generated from protobuf field <code>string message = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.google.protobuf.Duration wait = 4;</code>
     * @return \Google\Protobuf\Duration
     */
    public function getWait()
    {
        return $this->wait;
    }

    /**
     * Generated from protobuf field <code>.google.protobuf.Duration wait = 4;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setWait($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Duration::class);
        $this->wait = $var;

        return $this;
    }

}

