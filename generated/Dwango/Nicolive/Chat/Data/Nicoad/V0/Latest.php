<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/Nicoad.proto

namespace Dwango\Nicolive\Chat\Data\Nicoad\V0;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.Nicoad.V0.Latest</code>
 */
class Latest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string advertiser = 1;</code>
     */
    private $advertiser = '';
    /**
     * Generated from protobuf field <code>int32 point = 2;</code>
     */
    private $point = 0;
    /**
     * Generated from protobuf field <code>string message = 3;</code>
     */
    private $message = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $advertiser
     *     @type int $point
     *     @type string $message
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\Nicoad::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string advertiser = 1;</code>
     * @return string
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    /**
     * Generated from protobuf field <code>string advertiser = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setAdvertiser($var)
    {
        GPBUtil::checkString($var, True);
        $this->advertiser = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 point = 2;</code>
     * @return int
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Generated from protobuf field <code>int32 point = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPoint($var)
    {
        GPBUtil::checkInt32($var);
        $this->point = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Latest::class, \Dwango\Nicolive\Chat\Data\Nicoad_V0_Latest::class);

