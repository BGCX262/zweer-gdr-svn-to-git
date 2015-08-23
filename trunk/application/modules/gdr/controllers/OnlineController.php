<?php

class Gdr_OnlineController extends Zwe_Controller_Action_Private
{
    public $contexts = array('index' => array('ajax'));

    public function indexAction()
    {
        $this->view->online = Zwe_Model_Online::getUsersOnline();
    }
}