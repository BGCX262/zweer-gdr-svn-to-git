<?php

class App_Model_User extends Zwe_Model_User
{
    public static function addUser($Nome, $Cognome, $Nascita, $Email, $Password)
    {
        $TheUser = new self();

        $Data = array('Name' => $Nome,
                      'Surname' => $Cognome,
                      'DateOfBirth' => $Nascita,
                      'Email' => $Email,
                      'Salt' => new Zend_Db_Expr("SHA1('" . mt_rand() . "')"),
                      'Password' => new Zend_Db_Expr("SHA1(CONCAT('$Password', Salt))"),
                      'RegistrationDate' => new Zend_Db_Expr('NOW()'));
        $IDUser = $TheUser->insert($Data);

        if($IDUser)
        {
            $Mail = new Zend_Mail();
            $Mail->setFrom(Zend_Registry::get('parameters')->registry->email, Zend_Registry::get('parameters')->registry->emailName);
            $Mail->addTo($Email);
            $Mail->setSubject("Nuova registrazione");
            $Mail->setBodyText("Benvenuto/a su " . Zend_Registry::get('parameters')->registry->siteTitle . ".\n\nDi seguito vengono riepilogate le tue credenziali:\nEmail: $Email\nPassword: $Password\n\nPer favore, considera di salvare e/o stampare questa email per ricordarti le tue credenziali.\n\nPer attivare il tuo account è necessario cliccare sul seguente link: " . Zend_Registry::get('parameters')->registry->siteUrl . "/index/confirm/$IDUser/" . sha1($IDUser), 'UTF-8', Zend_Mime::ENCODING_8BIT);
            $Mail->send();
        }

        return $IDUser;
    }

    public static function editUser($IDUser, $Nascita, $Luogo, $Descrizione1, $Descrizione2, $Descrizione3)
    {
        $TheUser = new self();
        $Data = array('PgDateOfBirth' => $Nascita, 'PgPlaceOfBirth' => $Luogo, 'Description1' => $Descrizione1, 'Description2' => $Descrizione2, 'Description3' => $Descrizione3);

        return $TheUser->update($Data, "IDUser = '$IDUser'");
    }

    public static function getUserById($IDUser)
    {
        $User = parent::getUserById($IDUser);
        $Ret = new self();

        return $Ret->copy($User);
    }

    public static function searchUser($Search)
    {
        $Users = parent::searchUser($Search);
        $Ret = array();

        foreach($Users as $User)
        {
            $TheUser = new self();
            $Ret[] = $TheUser->copy($User);
        }

        return $Ret;
    }

    public function toForm()
    {
        return array(
            'nascita' => $this->PgDateOfBirth,
            'luogo' => $this->PgPlaceOfBirth,
            'descrizione1' => $this->Description1,
            'descrizione2' => $this->Description2,
            'descrizione3' => $this->Description3,
            'id' => $this->IDUser
        );
    }

    public function __toString()
    {
        return $this->Name . ' ' . $this->Surname;
    }

    protected function getName()
    {
        return $this->_data['Name'];
    }
}