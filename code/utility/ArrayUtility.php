<?php
//对象转数组
function objectToarray($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = objectToarray($value);
        }
    }
    return $array;
}
