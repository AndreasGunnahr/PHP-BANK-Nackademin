<?php

include_once './includes/autoloader.php';
include_once '../API/classes/db/Database.php';
session_start();
spl_autoload_register('myAutoLoader');

use User\User;
use Db\Database;

$db = new Database();
$user = new User(null, $db);
$user->logout();
header('Location: index.php');
