<?php

namespace CodeDelivery\Helpers;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

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
        
        if ($dropdownContent instanceof SupportCollection || $dropdownContent instanceof EloquentCollection)
            $data = $dropdownContent->all();
            
        return ($select + $data);
    }
}