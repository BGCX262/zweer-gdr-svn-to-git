<?php

class StaticController extends Zwe_Controller_Action
{
    public function init()
    {
        parent::init();

        $this->view->ThePage = Zwe_Model_Page::getPageByURL($this->_getParam('page'));
    }

    public function indexAction()
    {
        
    }
}