<?php

class App_View_Helper_Array2Select extends Zend_View_Helper_Abstract
{
    public function array2Select(array $Array)
    {
        $Ret = array();

        foreach($Array as $Key => $Value)
        {
            $Ret[] = array('key' => $Key, 'value' => $Value);
        }

        return $Ret;
    }
}