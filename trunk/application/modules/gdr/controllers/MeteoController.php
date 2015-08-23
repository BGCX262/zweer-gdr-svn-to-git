<?php

class Gdr_MeteoController extends Zwe_Controller_Action_Default
{
    public $contexts = array('index' => array('ajax'));

    public function indexAction()
    {
        $this->view->weather = new Zwe_Weather("Berlin");
    }
}