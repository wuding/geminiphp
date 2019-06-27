<?php
/**
输出加载的文件地址
*/
function debug_file($filename)
{
    if (!$GLOBALS['_CONFIG']['debug']['file']) {
        return false;
    }
    echo $filename . PHP_EOL;
}