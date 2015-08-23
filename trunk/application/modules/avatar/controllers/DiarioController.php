<?php

class Avatar_DiarioController extends Berlino_Controller_Action_Avatar
{
    const BLOG_PER_PAGINA = 10;

    public $contexts = array('index' => array('html', 'rss'));

    public function indexAction()
    {
        $Page = $this->_getParam('page', 1);
        $this->view->blog = Avatar_Model_Blog::getBlog($this->view->pg->IDUser, self::BLOG_PER_PAGINA, self::BLOG_PER_PAGINA * ($Page - 1));

        if('rss' == $this->_context)
        {
            $this->view->feed = array(
                'title' => 'Diario di ' . $this->view->pg->Name . ' ' . $this->view->pg->Surname . ' - ' . Zend_Registry::get('parameters')->registry->siteTitle,
                'link' => Zend_Registry::get('parameters')->registry->siteUrl . $this->view->url(array('controller' => 'diario', 'pg' => $this->view->pg->Url), 'avatar') . '.rss',
                'charset' => 'utf-8',
                'language' => 'it-IT',
                'published' => time(),
                'entries' => array()
            );

            foreach($this->view->blog as $entry)
            {
                $D = new Zend_Date($entry->Date);
                $this->view->feed['entries'][] = array(
                    'title' => $entry->Title,
                    'link' => Zend_Registry::get('parameters')->registry->siteUrl . $this->view->url(array('pg' => $this->view->pg->Url, 'pagina' => $entry->IDNews), 'blogPermalink'),
                    'description' => '',
                    'content' => $entry->Text,
                    'lastUpdate' => $D->get(Zend_Date::TIMESTAMP),
                    'comments' => ''
                );
            }
        }
    }

    public function nuovapaginaAction()
    {
        $this->view->form = new Avatar_Form_NuovaPagina();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Avatar_Model_Blog::addNews($this->view->form->getValue('titolo'),
                                           Zend_Auth::getInstance()->getIdentity()->IDUser,
                                           $this->view->form->getValue('testo'));

                $this->_redirect($this->view->url(array('controller' => 'diario', 'pg' => Zend_Auth::getInstance()->getIdentity()->Url), 'avatar'));
            }
        }
    }

    public function modificapaginaAction()
    {
        $this->view->form = new Avatar_Form_NuovaPagina();
        $this->view->form->addID();

        if($this->getRequest()->isPost())
        {
            if($this->view->form->isValid($this->getRequest()->getPost()))
            {
                Avatar_Model_Blog::editNews($this->view->form->getValue('id'),
                                            $this->view->form->getValue('titolo'),
                                            Zend_Auth::getInstance()->getIdentity()->IDUser,
                                            $this->view->form->getValue('testo'));

                $this->_redirect($this->view->url(array('controller' => 'diario', 'pg' => Zend_Auth::getInstance()->getIdentity()->Url), 'avatar'));
            }
        }
        else
        {
            $this->view->form->populate(Avatar_Model_Blog::getNewsByID($this->_getParam('id'))->toForm());
        }
    }

    public function cancellapaginaAction()
    {
        Avatar_Model_Blog::deleteNews($this->_getParam('id'));
        
        $this->_redirect($this->view->url(array('controller' => 'diario', 'pg' => Zend_Auth::getInstance()->getIdentity()->Url), 'avatar'));
    }

    public function permalinkAction()
    {
        $this->view->pagina = Avatar_Model_Blog::getNewsByID($this->_getParam('pagina'));
    }
}