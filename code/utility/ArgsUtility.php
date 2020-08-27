<?php
/*
*命令行接收参数工具
*/
function getClientArgs()
{
    global $argv;
    array_shift($argv);
    $args = array();
    array_walk($argv, function ($v, $k) use (&$args) {
        @list($key, $value) = @explode('=', $v);
        $args[$key] = $value;
    });
    return $args;
}
//$args = getClientArgs();
//print_r($args);
