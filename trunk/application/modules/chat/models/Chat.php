<?php

class Chat_Model_Chat extends Zwe_Model_Chat
{
    const TYPE_PARLATO = 'P';
    const TYPE_AZIONE = 'A';

    const TYPE_MASTER_FATI = 'M1';
    const TYPE_MASTER_CORP = 'M2';
    const TYPE_MASTER_RAZZA = 'M3';
    const TYPE_MASTER_PROVA = 'M4';

    protected $_template = array(
        self::TYPE_PARLATO => '<div class="chat_message chat_message_type_parlato"><span class="chat_message_date">%date%</span> <span class="chat_message_author">%author%</span> <span class="chat_message_tag">[%tag%]</span> <span class="chat_message_text">%text%</span></div>',
        self::TYPE_AZIONE => '<div class="chat_message chat_message_type_azione"><span class="chat_message_date">%date%</span> <span class="chat_message_author">%author%</span> <span class="chat_message_tag">[%tag%]</span> <span class="chat_message_text">%text%</span></div>',
        self::TYPE_MASTER_FATI => '<div class="chat_message chat_message_type_master_fati"><span class="chat_message_date">%date%</span> <span class="chat_message_author">%author%</span> <span class="chat_message_tag">[%tag%]</span> <span class="chat_message_text">%text%</span></div>',
        self::TYPE_MASTER_CORP => '<div class="chat_message chat_message_type_master_corp"><span class="chat_message_date">%date%</span> <span class="chat_message_author">%author%</span> <span class="chat_message_tag">[%tag%]</span> <span class="chat_message_text">%text%</span></div>',
        self::TYPE_MASTER_RAZZA => '<div class="chat_message chat_message_type_master_razza"><span class="chat_message_date">%date%</span> <span class="chat_message_author">%author%</span> <span class="chat_message_tag">[%tag%]</span> <span class="chat_message_text">%text%</span></div>',
        self::TYPE_MASTER_PROVA => '<div class="chat_message chat_message_type_master_corp"><span class="chat_message_date">%date%</span> <span class="chat_message_author">%author%</span> <span class="chat_message_tag">[%tag%]</span> <span class="chat_message_text">%text%</span></div>'
    );

    public static function getTypes()
    {
        return array(
            self::TYPE_PARLATO => 'Parlato',
            self::TYPE_AZIONE => 'Azione'
        );
    }

    public static function getNew($IDParent, $lastID)
    {
        $Messaggi = parent::getNew($IDParent, $lastID);
        $Ret = array();

        foreach($Messaggi as $Messaggio)
        {
            $TheChat = new self();
            $Ret[] = $TheChat->copy($Messaggio);
        }

        return $Ret;
    }

    public static function addChat($IDParent, $Type, $Tag, $Text, $IDUser = null)
    {
        $IDChat = parent::addChat($IDParent, $Text, $IDUser);
        $TheChat = new self();
        $Data = array('Tag' => $Tag, 'Type' => $Type);

        return $TheChat->update($Data, "IDChat = '$IDChat'");
    }

    public function __toString()
    {
        $date = new Zend_Date($this->Date);
        $author = App_Model_User::getUserById($this->IDUser);

        return str_replace(array('%date%',
                                 '%author%',
                                 '%tag%',
                                 '%text%'),
                           array($date->toString('H:m:s'),
                                 $author,
                                 $this->Tag,
                                 $this->Text),
                           $this->_template[$this->Type]);
    }
}