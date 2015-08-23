<?php

class Avatar_Form_NuovaPagina extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_diario_nuova_pagina');
        $this->setMethod(self::METHOD_POST);

        $this->addElement('text',
                          'titolo',
                          array('required' => true,
                                'label' => 'Titolo della pagina:'));

        $this->addElement('textarea',
                          'testo',
                          array('required' => true,
                                'label' => 'Testo della pagina:'));

        $this->addElement('submit',
                          'nuova_pagina',
                          array('label' => 'Crea Pagina'));
    }

    public function addID()
    {
        $this->addElement('hidden',
                          'id');
    }
}