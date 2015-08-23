<?php

class Avatar_View_Helper_AvatarMenu extends Zend_View_Helper_Abstract
{
    public function avatarMenu(App_Model_User $Pg, $CurrentPage)
    {
        $Name = $Pg->IDUser . ' ' . $Pg->Name . ' ' . $Pg->Surname;

        $Ret  = '<ul class="avatar_menu">';
        $Ret .= '<li><a href="' . $this->view->url(array('controller' => 'vedi', 'pg' => $Name), 'avatar') . '">Avatar</a></li>';
        if($Pg->CanModify())
            $Ret .= '<li><a href="' . $this->view->url(array('controller' => 'modifica', 'pg' => $Name), 'avatar') . '">Modifica</a></li>';
        $Ret .= '<li><a href="' . $this->view->url(array('controller' => 'oggetti', 'pg' => $Name), 'avatar') . '">Oggetti</a></li>';
        $Ret .= '<li><a href="' . $this->view->url(array('controller' => 'diario', 'pg' => $Name), 'avatar') . '">Diario</a></li>';
        $Ret .= '<li><a href="' . $this->view->url(array('controller' => 'fedina', 'pg' => $Name), 'avatar') . '">Fedina penale</a></li>';
        $Ret .= '</ul>';

        return $Ret;
    }
}