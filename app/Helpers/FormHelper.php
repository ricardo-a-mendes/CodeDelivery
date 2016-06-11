<?php

namespace CodeDelivery\Helpers;

use Illuminate\Database\Eloquent\Collection;

class FormHelper
{
    public static function bindDropDown($dropdownContent)
    {
        $select = [0 => '-- Select --'];
        $data = [];
        
        if (is_array($dropdownContent))
            $data = $dropdownContent;
        
        if ($dropdownContent instanceof \Illuminate\Support\Collection || $dropdownContent instanceof Collection)
            $data = $dropdownContent->all();
            
        return ($select + $data);
    }
}