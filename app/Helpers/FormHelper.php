<?php

namespace CodeDelivery\Helpers;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class FormHelper
 * @package CodeDelivery\Helpers
 */
class FormHelper
{
    /**
     * It merges a "-- Select --" option to an array to be inserted in a Select Form Field
     *
     * @param Data to be inserted in a DropDown
     * @return array
     */
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