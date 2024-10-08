<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/service/edge/PackedSegment.proto

namespace Dwango\Nicolive\Chat\Service\Edge\PackedSegment;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.service.edge.PackedSegment.Next</code>
 */
class Next extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string uri = 1;</code>
     */
    private $uri = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uri
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Service\Edge\PackedSegment::initOnce();
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

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Next::class, \Dwango\Nicolive\Chat\Service\Edge\PackedSegment_Next::class);

