<?php

class Zend_View_Helper_CautareHighlight extends Zend_View_Helper_Abstract
{
    public function cautareHighlight($words,$text)
    {
       
        foreach($words as $word){
        	$word = preg_quote($word);
			$text = preg_replace("/\b($word)/i", '<em>\1</em>', $text);	
        }
         
        return $text;
    }

    public function truncateString($text,$limit)
    {
        return substr($text, 0, $limit);
    }

}