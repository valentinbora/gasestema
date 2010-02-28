<?php

class Zend_View_Helper_TruncateString extends Zend_View_Helper_Abstract
{

    public function truncateString($text,$limit)
    {
        return substr($text, 0, $limit);
    }

}