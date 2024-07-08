<?php
session_start();

if (isset($_SESSION['department_name'])) {
    $department_name = $_SESSION['department_name'];
}

if (isset($_GET['dept'])) {
    $dept = $_GET['dept'];
    if (isset($department_name) && $department_name === $dept) {
        header("Location: dept_board.php?dept=" . urlencode($dept));
        exit();
    }else {
        header("Location:menu.php?error=mati
        ");
    }
}
?>
