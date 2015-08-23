<?php

class Berlino_Controller_Action_NoPrigione extends Zwe_Controller_Action_Private
{
    public function preDispatch()
    {
        parent::preDispatch();

        if(!$this->_hasParam('luogo'))
            $this->_helper->redirector('index', 'index', 'mappa');

        $this->view->luogo = Mappa_Model_Luogo::getByUrl($this->_getParam('luogo'));

        if(strtotime(Zend_Auth::getInstance()->getIdentity()->PrisonDate) > time() && !$this->view->luogo->IsPrison)
        {
            $Prison = Mappa_Model_Luogo::get(Zend_Auth::getInstance()->getIdentity()->PrisonLocation);
            $this->_redirect($this->view->url(array('luogo' => $Prison->Url), 'chat'));
        }
    }

    public function postDispatch()
    {
        parent::postDispatch();
        
        Zwe_Model_Online::refreshOnline(null, $this->view->luogo->IDLocation);
    }
}