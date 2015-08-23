<?php

class Gdr_UtentiController extends Zwe_Controller_Action_Private
{
    public $contexts = array('lista' => array('json'));

    public function listaAction()
    {
        if($this->getRequest()->isPost())
        {
            if($this->getRequest()->getPost('search'))
            {
                $Utenti = App_Model_User::searchUser($this->getRequest()->getPost('search'));
                $this->view->clearVars();
                
                file_put_contents(PUBLIC_PATH . '/log.log', print_r($Utenti, true));

                $this->view->utenti = array();
                foreach($Utenti as $Utente)
                {
                    $this->view->utenti[] = array($Utente->IDUser, (string) $Utente, null, (string) $Utente);
                }

                echo json_encode($this->view->utenti);
                exit;
            }
        }
    }
}