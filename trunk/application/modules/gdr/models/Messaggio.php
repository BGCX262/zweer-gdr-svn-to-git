<?php

class Gdr_Model_Messaggio extends Zwe_Model_Message
{
    public static function getMessageById($IDMessage)
    {
        $Message = parent::getMessageById($IDMessage);
        $TheMessage = new self();

        return $TheMessage->copy($Message);
    }

    public static function getMessagesByUser($IDUser, $Count, $Offset)
    {
        $TheMessage = new self();
        $Select = $TheMessage->select()->join(array('mm' => 'message'), 'message.IDMessage = mm.IDLastMessage', array())
                                       ->join(array('r' => 'message_receiver'), 'mm.IDMessage = r.IDMessage', 'IDUser')
                                       ->where("IDUser = '$IDUser' AND mm.IDParent = mm.IDMessage AND Deleted = '0'")
                                       ->order("mm.DateLastMessage DESC")
                                       ->limit($Count, $Offset);
        $Messages = $TheMessage->fetchAll($Select);
        $Ret = array();

        if($Messages)
        {
            foreach($Messages as $Message)
            {
                $TheMessage = new self();
                $Ret[] = $TheMessage->copyFromDb($Message);
            }
        }

        return $Ret;
    }

    public static function getConversation($IDMessage)
    {
        $TheMessage = new self();
        $Select = $TheMessage->select()->join(array('mm' => 'message'), 'message.IDParent = mm.IDParent', array())
                                       ->where("mm.IDMessage = '$IDMessage'")
                                       ->order("mm.Date");
        $Messages = $TheMessage->fetchAll($Select);
        $Ret = array();

        if($Messages)
        {
            foreach($Messages as $Message)
            {
                $TheMessage = new self();
                $Ret[] = $TheMessage->copyFromDb($Message);
            }
        }

        return $Ret;
    }

    public function getSender()
    {
        if(!isset($this->_sender))
        {
            $TheSender = new App_Model_User();
            $this->_sender = $TheSender->copy(parent::getSender());
        }

        return $this->_sender;
    }

    public function getReceiver()
    {
        if(!isset($this->_receiver))
        {
            parent::getReceiver();

            foreach($this->_receiver as &$R)
            {
                $TheReceiver = new App_Model_User();
                $R = $TheReceiver->copy($R);
            }
        }

        return $this->_receiver;
    }

    public function getParent()
    {
        if(!isset($this->_parent) && parent::getParent())
        {
            $TheParent = new self();
            $this->_parent = $TheParent->copy($this->_parent);
        }

        return $this->_parent;
    }
}