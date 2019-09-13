<?php
require_once '../models/db.php';
session_start();
if (empty($_SESSION['mem_id'])) {
    header("location:login.php");
}
$temp_id = $_SESSION['mem_id'];
$temp_name = $_SESSION['full_name'];
session_destroy();
session_start();
$_SESSION['mem_id'] = $temp_id;
$_SESSION['full_name'] = $temp_name;

$db = new DB();
$id = $_SESSION['mem_id'];
$name = $_SESSION['full_name'];

?>


