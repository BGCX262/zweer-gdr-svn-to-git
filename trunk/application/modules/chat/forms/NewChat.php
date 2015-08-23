<?php

class Chat_Form_NewChat extends Zwe_Form
{
    public function init()
    {
        $this->setName('form_newChat');
        $this->setMethod(self::METHOD_POST);
        $this->setAction($this->getView()->url());

        $this->addElement('select',
                          'type',
                          array('required' => true,
                                'label' => 'Type:'));
        $this->getElement('type')->clearDecorators()
                                 ->addDecorator('ViewHelper')
                                 ->addDecorator('Label')
                                 ->addDecorator('HtmlTag', array('tag' => 'div', 'id' => 'chat_input_container_type'))
                                 ->setAttrib('id', 'chat_input_type')
                                 ->addMultiOptions($this->getView()->array2Select(Chat_Model_Chat::getTypes()));

        $this->addElement('text',
                          'tag',
                          array('required' => true,
                                'label' => 'Tag:'));
        $this->getElement('tag')->addFilter('HtmlEntities')
                                ->addValidator('StringLength', array('max' => 50))
                                ->clearDecorators()
                                ->addDecorator('ViewHelper')
                                ->addDecorator('Label')
                                ->addDecorator(array('Error' => 'HtmlTag'), array('tag' => 'div', 'id' => 'chat_input_error', 'placement' => Zend_Form_Decorator_Abstract::PREPEND))
                                ->addDecorator('HtmlTag', array('tag' => 'div'))
                                ->setAttrib('id', 'chat_input_tag')
                                ->setAttrib('class', "required msgPos:'chat_input_error'")
                                ->setAttrib('title', 'Inserisci il Tag');

        $this->addElement('text',
                          'text',
                          array('required' => true,
                                'label' => 'Text:'));
        $this->getElement('text')->addFilter('HtmlEntities')
                                 ->addValidator('StringLength', array('max' => 1000))
                                 ->clearDecorators()
                                 ->addDecorator('ViewHelper')
                                 ->addDecorator('Label')
                                 ->addDecorator('HtmlTag', array('tag' => 'div'))
                                 ->setAttrib('id', 'chat_input_text')
                                 ->setAttrib('class', "required msgPos:'chat_input_error'")
                                 ->setAttrib('title', 'Inserisci il Testo');

        $this->clearDecorators()
             ->addDecorator('FormElements')
             ->addDecorator('Form');
    }
}