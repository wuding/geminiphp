<?php
if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
date_default_timezone_set('Asia/Shanghai');

print_r($_SERVER);
