<?php

class App_View_Helper_ErrorsAlert extends Zwe_View_Helper_Js_Error
{
    public function errorsAlert(array $errors)
    {
        $text = array();

        foreach($errors as $name => $error)
        {
            foreach($error as $n => $e)
                $text[] = "<strong>" . ucfirst($name) . "</strong>: " . ('token' == $name ? 'Pagina attiva da troppo tempo, riprova ora' : $e);
        }

        return $this->js_Error(implode("<br />", $text), array('title' => 'Si sono verificati alcuni errori'));
    }
}

?>