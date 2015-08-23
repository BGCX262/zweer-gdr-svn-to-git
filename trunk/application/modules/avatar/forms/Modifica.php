<?php

class Avatar_Form_Modifica extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_avatar_modifica');
        $this->setMethod(self::METHOD_POST);

        $this->addElement('date',
                          'nascita',
                          array('label' => 'Data di nascita:'));

        $this->addElement('text',
                          'luogo',
                          array('label' => 'Luogo di nascita:'));
        $this->getElement('luogo')->addValidator('StringLength', false, array('max' => 100));

        $this->addElement('textarea',
                          'descrizione1',
                          array('label' => 'Descrizione fisica:'));

        $this->addElement('textarea',
                          'descrizione2',
                          array('label' => 'Descrizione caratteriale:'));

        $this->addElement('textarea',
                          'descrizione3',
                          array('label' => 'Vita e storia passata:'));

        $this->addElement('submit',
                          'modifica',
                          array('label' => 'Modifica'));

        $this->addElement('hidden',
                          'id');
    }
}