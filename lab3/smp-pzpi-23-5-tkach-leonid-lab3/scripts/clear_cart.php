<?php
session_start();

$_SESSION['cart'] = [];

header('Location: ../pages/cart.php');
exit;
?>