<?php

class Mappa_LuogoController extends Berlino_Controller_Action_Mappa
{
    public function preDispatch()
    {
        parent::preDispatch();

        if(!$this->_hasParam('luogo'))
            $this->_helper->redirector('index', 'index');

        $this->view->luogo = Mappa_Model_Luogo::getByUrl($this->_getParam('luogo'));
    }

    public function descrizioneAction()
    {
        
    }
}