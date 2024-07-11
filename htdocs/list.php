<?php
session_start();

require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userid = $_SESSION['user_id'];
$username = $_SESSION['user_name'];
$department_id = $_SESSION['department_name'];

if (isset($_GET['dept'])) {
    $dept = $_GET['dept'];
    if ($dept === 'zen' || $dept === $department_id) {
        header("Location: dept_board.php?dept=" . urlencode($dept));
        exit();
    } else {
        header("Location: menu.php?error=mati");
        exit();
    }
} else {
    header("Location: menu.php");
    exit();
}
