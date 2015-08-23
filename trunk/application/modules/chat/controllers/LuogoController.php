<?php

class Chat_LuogoController extends Berlino_Controller_Action_NoPrigione
{
    public $contexts = array('nuovi' => array('json'));

    public function vediAction()
    {
        $this->view->form = new Chat_Form_NewChat();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Chat_Model_Chat::addChat($this->view->luogo->IDLocation,
                                         $this->view->form->getValue('type'),
                                         $this->view->form->getValue('tag'),
                                         $this->view->form->getValue('text'));
            }
        }
    }

    public function nuoviAction()
    {
        if($this->getRequest()->isPost())
        {
            $Messaggi = Chat_Model_Chat::getNew($this->view->luogo->IDLocation, $this->getRequest()->getPost('lastID'));
            $this->view->messaggi = array();

            foreach($Messaggi as $Messaggio)
            {
                $this->view->messaggi[] = array('id' => $Messaggio->IDChat,
                                                'text' => (string) $Messaggio);
            }
        }
    }
}