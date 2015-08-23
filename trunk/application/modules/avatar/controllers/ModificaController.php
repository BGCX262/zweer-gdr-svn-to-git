<?php

class Avatar_ModificaController extends Berlino_Controller_Action_Avatar
{
    public function preDispatch()
    {
        parent::preDispatch();

        if(!$this->view->pg->canModify())
            $this->_helper->redirector('privilege', 'error', 'default');
    }

    public function indexAction()
    {
        $this->view->form = new Avatar_Form_Modifica();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                App_Model_User::editUser($this->view->form->getValue('id'),
                                         $this->view->form->getValue('nascita'),
                                         $this->view->form->getValue('luogo'),
                                         $this->view->form->getValue('descrizione1'),
                                         $this->view->form->getValue('descrizione2'),
                                         $this->view->form->getValue('descrizione3'));
            }
        }
        else
        {
            $this->view->form->populate($this->view->pg->toForm());
        }
    }
}