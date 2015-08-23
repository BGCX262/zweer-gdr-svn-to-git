<?php

class Gdr_Form_NuovoMessaggio extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_nuovo_messaggio');
        $this->setMethod(self::METHOD_POST);
        $this->setAction($this->getView()->url(array('action' => 'nuovo', 'controller' => 'messaggi', 'module' => 'gdr'), 'default') . '.json');

        $this->setAttrib('id', 'nuovo_messaggio_form');

        $this->addElement('text',
                          'destinatari',
                          array('required' => true,
                                'label' => 'Destinatario/i:'));
        $this->getElement('destinatari')->setAttrib('id', 'nuovo_messaggio_destinatari')
                                        ->setAttrib('class', "required");

        $this->addElement('textarea',
                          'testo',
                          array('required' => true,
                                'label' => 'Testo:'));
        $this->getElement('testo')->setAttrib('id', 'nuovo_messaggio_testo')
                                  ->setAttrib('class', 'required');

        $this->addElement('submit',
                          'nuovo_messaggio',
                          array('label' => 'Invia Messaggio'));
    }

    public function reply($IDParent = null)
    {
        $this->addElement('hidden',
                          'reply');
        if(isset($IDParent))
            $this->getElement('reply')->setValue($IDParent);

        $this->setAction($this->getView()->url(array('action' => 'reply', 'controller' => 'messaggi', 'module' => 'gdr'), 'default') . '.ajax');
        $this->removeElement('destinatari');
    }
}