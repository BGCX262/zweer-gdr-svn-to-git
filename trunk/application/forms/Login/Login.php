<?php

class App_Form_Login_Login extends Zwe_Form_Application_Application_Login_Login
{
    public function init()
    {
        parent::init();

        $this->clearDecorators()
             ->addDecorator('FormElements')
             ->addDecorator('Form');

        $this->getElement('email')->clearDecorators()
                                  ->addDecorator('ViewHelper')
                                  ->setAttrib('class', 'login_email')
                                  ->setAttrib('title', 'Inserisci il tuo indirizzo email')
                                  ->addValidator('EmailAddress');
        $this->getElement('password')->clearDecorators()
                                     ->addDecorator('ViewHelper')
                                     ->setAttrib('class', 'login_password');
        $this->getElement('login')->clearDecorators()
                                  ->addDecorator('ViewHelper')
                                  ->setAttrib('class', 'login_submit')
                                  ->setLabel('');
        $this->getElement('token')->clearDecorators()
                                  ->addDecorator('ViewHelper');
    }
}

?>