<?php

class IndexController extends Zwe_Controller_Application_Login
{
    /**
     * Se uno è loggato e visita questa pagina gli cancella subito la sessione in modo che non possa avere due sessioni contemporaneamente.
     */
    public function preDispatch()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            Zend_Auth::getInstance()->clearIdentity();
        }
    }

    public function indexAction()
    {
        $this->view->form = new App_Form_Login_Login();
        $this->view->errors = '';

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                if($this->_process($this->view->form->getValues()))
                {
                    $this->_redirect('/mappa');
                }
                else
                {
                    $this->view->errors = array('Credenziali' => array('Non valide'));
                }
            }
            else
            {
                $this->view->errors = $this->view->form->getMessages();
            }
        }
    }

    public function registerAction()
    {
        $this->view->form = new App_Form_Login_Register();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                if(App_Model_User::addUser($this->view->form->getValue('nome'),
                                           $this->view->form->getValue('cognome'),
                                           $this->view->form->getValue('nascita'),
                                           $this->view->form->getValue('email'),
                                           $this->view->form->getValue('password')))
                {
                    $this->_helper->redirector('registerOk');
                }
                else
                {
                    $this->_helper->redirector('registerKo');
                }
            }
            else
            {
                $this->_helper->redirector('registerKo');
            }
        }
    }

    public function registerokAction()
    {

    }

    public function registerkoAction()
    {

    }

    public function confirmAction()
    {
        $User = $this->_getParam('user');
        $Salt = $this->_getParam('salt');

        if(Zwe_Model_User::confirmUser($User, $Salt))
        {
            $this->view->ok = true;
        }
        else
        {
            $this->view->ok = false;
        }
    }
}

?>