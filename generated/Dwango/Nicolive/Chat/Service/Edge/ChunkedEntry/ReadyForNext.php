<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/service/edge/ChunkedEntry.proto

namespace Dwango\Nicolive\Chat\Service\Edge\ChunkedEntry;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 **
 *　 * 次のストリームの開始時刻を表すチャンク。必ずストリームの末尾に送られてくる。
 *　
 *
 * Generated from protobuf message <code>dwango.nicolive.chat.service.edge.ChunkedEntry.ReadyForNext</code>
 */
class ReadyForNext extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int64 at = 1;</code>
     */
    private $at = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $at
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Service\Edge\ChunkedEntry::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int64 at = 1;</code>
     * @return int|string
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Generated from protobuf field <code>int64 at = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setAt($var)
    {
        GPBUtil::checkInt64($var);
        $this->at = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ReadyForNext::class, \Dwango\Nicolive\Chat\Service\Edge\ChunkedEntry_ReadyForNext::class);

