<?php

class Gdr_MessaggiController extends Zwe_Controller_Action_Private
{
    public $contexts = array('index' => array('ajax'),
                             'nuovo' => array('ajax', 'json'),
                             'leggi' => array('ajax'),
                             'reply' => array('ajax'));

    const MESSAGGI_PER_PAGINA = 20;

    public function indexAction()
    {
        $this->view->messaggi = Gdr_Model_Messaggio::getMessagesByUser(Zend_Auth::getInstance()->getIdentity()->IDUser, self::MESSAGGI_PER_PAGINA, $this->_getParam('page', 0) * self::MESSAGGI_PER_PAGINA);
    }

    public function nuovoAction()
    {
        $this->view->form = new Gdr_Form_NuovoMessaggio();
        $this->view->ok = false;

        if($this->getRequest()->isPost() && $this->getRequest()->getPost('destinatari'))
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Gdr_Model_Messaggio::createMessage(explode(',', $this->view->form->getValue('destinatari')),
                                                   $this->view->form->getValue('testo'));

                $this->view->ok = true;
            }
        }
    }

    public function leggiAction()
    {
        $this->view->messaggi = Gdr_Model_Messaggio::getConversation($this->_getParam('messaggio', 0));
        if(!$this->view->messaggi[0]->isReceiver())
        {
            $this->view->messaggi = null;
            $this->_helper->redirector('index');
        }
        $this->view->form = new Gdr_Form_NuovoMessaggio();
        $this->view->form->reply($this->view->messaggi[0]->IDParent);
    }

    public function replyAction()
    {
        $this->view->form = new Gdr_Form_NuovoMessaggio();
        $this->view->form->reply();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                $this->view->messaggio = Gdr_Model_Messaggio::getMessageById(Gdr_Model_Messaggio::replyMessage($this->view->form->getValue('reply'),
                                                                                                               $this->view->form->getValue('testo')));
            }
        }
    }
}