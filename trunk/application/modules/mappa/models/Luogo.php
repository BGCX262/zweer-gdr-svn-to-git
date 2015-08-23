<?php

class Mappa_Model_Luogo extends Zwe_Model
{
    protected $_name = 'location';
    protected $_primary = 'IDLocation';

    protected $_parent;

    public static function get($IDLuogo)
    {
        $TheLuogo = new self();
        $TheParent = new self();

        $TheLuogo->fetchRowAndSet("IDLocation = '$IDLuogo'");
        $TheLuogo->Parent = $TheParent->fetchRowAndSet("IDLocation = '" . $TheLuogo->IDParent . "'");

        return $TheLuogo;
    }

    public static function getByUrl($Url)
    {
        $TheLuogo = new self();

        try
        {
            $TheLuogo->fetchRowAndSet("Url = '$Url'");
            $TheLuogo = self::get($TheLuogo->IDLocation);
        }
        catch(Exception $E)
        {
            $filter = new Zend_Filter_Word_CamelCaseToSeparator();
            $Nome = ucfirst($filter->filter($Url));

            $Data = array('Name' => $Nome, 'Url' => $Url);
            $IDLuogo = $TheLuogo->insert($Data);
            $TheLuogo = self::get($IDLuogo);
        }

        return $TheLuogo;
    }

    public function __get($name)
    {
        if('Parent' == $name)
            return $this->_parent;
        else
            return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if('Parent' == $name)
        {
            if($value instanceof Mappa_Model_Luogo)
                $this->_parent = $value;
            else
                throw new Exception("'value' must be an instance of Mappa_Model_Luogo");
        }
        else
            parent::__set($name, $value);
    }
}