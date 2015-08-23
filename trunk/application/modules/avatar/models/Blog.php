<?php

class Avatar_Model_Blog extends Zwe_Model_News
{
    public static function getBlog($IDUser, $Count, $Offset)
    {
        $Blogs = parent::getPageNews($IDUser, $Count, $Offset);
        foreach($Blogs as &$Blog)
        {
            $TheBlog = new self();
            $TheBlog->copy($Blog);

            $Author = new App_Model_User();
            $Author->copy($Blog->Author);
            $TheBlog->Author = $Author;

            $Blog = $TheBlog;
        }

        return $Blogs;
    }

    public static function getNewsByID($IDNews)
    {
        $Blog = parent::getNewsByID($IDNews);

        $TheBlog = new self();
        $TheBlog->copy($Blog);

        $Author = new App_Model_User();
        $Author->copy($Blog->Author);
        $TheBlog->Author = $Author;

        return $TheBlog;
    }

    public function toForm()
    {
        return array('id' => $this->IDNews,
                     'titolo' => $this->Title,
                     'testo' => $this->Text);
    }

    public function __set($Name, $Value)
    {
        if('Author' == $Name)
        {
            if($Value instanceof App_Model_User)
                $this->_author = $Value;
            else
                throw new Exception('$value is not the expected value');
        }
        else
            parent::__set($Name, $Value);
    }
}