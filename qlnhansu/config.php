<?php
$pdo = new PDO(
    'mysql:host=localhost;dbname=QLNhanSu;charset=utf8mb4',
    'root', '', 
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
