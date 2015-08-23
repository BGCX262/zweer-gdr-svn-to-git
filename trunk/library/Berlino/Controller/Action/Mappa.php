<?php

class Berlino_Controller_Action_Mappa extends Zwe_Controller_Action_Private
{
    public function postDispatch()
    {
        Zwe_Model_Online::refreshOnline(null, 0);
    }
}