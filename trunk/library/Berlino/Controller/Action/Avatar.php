<?php

class Berlino_Controller_Action_Avatar extends Zwe_Controller_Action_Default
{
    public function preDispatch()
    {
        list($IDUser, $Name) = explode(' ', $this->_getParam('pg'), 2);

        if('index' != $this->getRequest()->getActionName() && 'permalink' != $this->getRequest()->getActionName())
            return;

        if(!isset($Name))
        {
            if(!Zend_Auth::getInstance()->hasIdentity())
                $this->_helper->_redirector('auth', 'error', 'default');

            $this->_forward($IDUser);
            return;
        }

        try
        {
            $this->view->pg = App_Model_User::getUserById($IDUser);
            $this->view->title = $this->view->pg->Name . ' ' . $this->view->pg->Surname;
            $this->view->titleImg = $this->view->normalize($this->view->title);
            $this->view->headTitle()->append($this->view->title);
        }
        catch(Exception $e)
        {
            $this->view->pg = $Name;
            $this->getRequest()->setActionName('notFound');
        }
    }
}