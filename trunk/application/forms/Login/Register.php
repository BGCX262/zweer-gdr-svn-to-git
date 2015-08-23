<?php

class App_Form_Login_Register extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_register');
        $this->setMethod(Zend_Form::METHOD_POST);

        $this->addElement('text',
                          'nome',
                          array('required' => true,
                                'label' => "Nome del pg:"));
        $this->addElement('text',
                          'cognome',
                          array('required' => true,
                                'label' => "Cognome del pg:"));
        $this->addElement('email',
                          'email',
                          array('required' => true,
                                'label' => "Indirizzo email di riferimento:"));
        $this->getElement('email')->addValidator('Db_NoRecordExists', false, array('table' => 'user',
                                                                                   'field' => 'Email'));

        $this->addElement('password',
                          'password',
                          array('required' => true,
                                'label' => 'Password:'));
        $this->addElement('password',
                          'password2',
                          array('required' => true,
                                'label' => 'Inserisci nuovamente la password:',
                                'validators' => array(array('Identical', false, array('token' => 'password')))));
        $this->addElement('date',
                          'nascita',
                          array('required' => true,
                                'label' => "Data di nascita reale dell'utente:"));
        $this->addElement('captcha',
                          'captcha',
                          array('label' => "Inserisci la scritta nell'immagine:",
                                'captcha' => array('captcha' => 'Image',
                                                   'wordLen' => 6,
                                                   'timeout' => 300,
                                                   'imgAlt' => 'captcha',
                                                   'imgDir' => PUBLIC_PATH . '/images/captcha',
                                                   'imgUrl' => $this->getView()->import_Img('/captcha', array('url' => true)),
                                                   'font' => '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf')));
        $this->addElement('submit',
                          'register',
                          array('label' => 'Iscriviti'));
    }
}

?>