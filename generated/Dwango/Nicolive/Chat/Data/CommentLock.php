<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/CommentLock.proto

namespace Dwango\Nicolive\Chat\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.CommentLock</code>
 */
class CommentLock extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.CommentLock.Status status = 1;</code>
     */
    private $status = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $status
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\CommentLock::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.CommentLock.Status status = 1;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.CommentLock.Status status = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Dwango\Nicolive\Chat\Data\CommentLock_Status::class);
        $this->status = $var;

        return $this;
    }

}

