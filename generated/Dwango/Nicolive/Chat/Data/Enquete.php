<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/Enquete.proto

namespace Dwango\Nicolive\Chat\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.Enquete</code>
 */
class Enquete extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string question = 1;</code>
     */
    private $question = '';
    /**
     * Generated from protobuf field <code>repeated .dwango.nicolive.chat.data.Enquete.Choice choices = 2;</code>
     */
    private $choices;
    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.Enquete.Status status = 3;</code>
     */
    private $status = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $question
     *     @type \Dwango\Nicolive\Chat\Data\Enquete\Choice[]|\Google\Protobuf\Internal\RepeatedField $choices
     *     @type int $status
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\Enquete::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string question = 1;</code>
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Generated from protobuf field <code>string question = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setQuestion($var)
    {
        GPBUtil::checkString($var, True);
        $this->question = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .dwango.nicolive.chat.data.Enquete.Choice choices = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Generated from protobuf field <code>repeated .dwango.nicolive.chat.data.Enquete.Choice choices = 2;</code>
     * @param \Dwango\Nicolive\Chat\Data\Enquete\Choice[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setChoices($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Dwango\Nicolive\Chat\Data\Enquete\Choice::class);
        $this->choices = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.Enquete.Status status = 3;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.Enquete.Status status = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Dwango\Nicolive\Chat\Data\Enquete_Status::class);
        $this->status = $var;

        return $this;
    }

}

