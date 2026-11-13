<?php
// Include file này ở đầu mọi trang admin để bắt buộc đăng nhập
session_start();
require __DIR__ . '/../config.php';
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
