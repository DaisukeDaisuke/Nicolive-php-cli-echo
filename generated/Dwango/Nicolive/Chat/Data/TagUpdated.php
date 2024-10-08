<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/TagUpdated.proto

namespace Dwango\Nicolive\Chat\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.TagUpdated</code>
 */
class TagUpdated extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .dwango.nicolive.chat.data.TagUpdated.Tag tags = 1;</code>
     */
    private $tags;
    /**
     * Generated from protobuf field <code>bool owner_locked = 2;</code>
     */
    private $owner_locked = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Dwango\Nicolive\Chat\Data\TagUpdated\Tag[]|\Google\Protobuf\Internal\RepeatedField $tags
     *     @type bool $owner_locked
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\TagUpdated::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .dwango.nicolive.chat.data.TagUpdated.Tag tags = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Generated from protobuf field <code>repeated .dwango.nicolive.chat.data.TagUpdated.Tag tags = 1;</code>
     * @param \Dwango\Nicolive\Chat\Data\TagUpdated\Tag[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTags($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Dwango\Nicolive\Chat\Data\TagUpdated\Tag::class);
        $this->tags = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool owner_locked = 2;</code>
     * @return bool
     */
    public function getOwnerLocked()
    {
        return $this->owner_locked;
    }

    /**
     * Generated from protobuf field <code>bool owner_locked = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setOwnerLocked($var)
    {
        GPBUtil::checkBool($var);
        $this->owner_locked = $var;

        return $this;
    }

}

