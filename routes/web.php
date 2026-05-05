<?php
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();

if ($_GET['action'] === 'register') {
    $auth->register();
}

if ($_GET['action'] === 'login') {
    $auth->login();
}
?>