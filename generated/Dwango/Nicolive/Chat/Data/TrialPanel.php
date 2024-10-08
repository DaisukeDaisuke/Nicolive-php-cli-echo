<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: dwango/nicolive/chat/data/TrialPanel.proto

namespace Dwango\Nicolive\Chat\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>dwango.nicolive.chat.data.TrialPanel</code>
 */
class TrialPanel extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.TrialPanel.Panel panel = 1;</code>
     */
    private $panel = 0;
    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.TrialPanel.Mode unqualified_user = 2;</code>
     */
    private $unqualified_user = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $panel
     *     @type int $unqualified_user
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Dwango\Nicolive\Chat\Data\TrialPanel::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.TrialPanel.Panel panel = 1;</code>
     * @return int
     */
    public function getPanel()
    {
        return $this->panel;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.TrialPanel.Panel panel = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setPanel($var)
    {
        GPBUtil::checkEnum($var, \Dwango\Nicolive\Chat\Data\TrialPanel_Panel::class);
        $this->panel = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.TrialPanel.Mode unqualified_user = 2;</code>
     * @return int
     */
    public function getUnqualifiedUser()
    {
        return $this->unqualified_user;
    }

    /**
     * Generated from protobuf field <code>.dwango.nicolive.chat.data.TrialPanel.Mode unqualified_user = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setUnqualifiedUser($var)
    {
        GPBUtil::checkEnum($var, \Dwango\Nicolive\Chat\Data\TrialPanel_Mode::class);
        $this->unqualified_user = $var;

        return $this;
    }

}

