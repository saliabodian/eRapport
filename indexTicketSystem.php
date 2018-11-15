<?php
header('Content-Type: text/html');
date_default_timezone_set("Europe/Luxembourg");

session_start();
session_regenerate_id();

ini_set('display_errors', true);
ini_set('post_max_size', '100M');

use System\Libs\Bootstrap;
use System\Libs\AntiCSRF;
use PHPMailer\PHPMailer\PHPMailer;

require 'System/Smarty/Smarty.class.php';
require 'System/Excel/PHPExcel.php';
require 'System/Mailer/PHPMailer.php';
require 'System/Mailer/SMTP.php';

spl_autoload_register(function ($class) {
    require str_replace('\\', '/', $class) . '.php';
});

$libs = [new Smarty, new PHPExcel, new PHPMailer, new AntiCSRF];
new Bootstrap(isset($_GET['p']) ? rtrim($_GET['p'], '/') : 'index', parse_ini_file('config.ini'), $libs);