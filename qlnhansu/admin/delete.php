<?php
require '../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $st = $pdo->prepare('SELECT images FROM Users WHERE admin_id = ?');
    $st->execute([$id]);
    if ($img = $st->fetchColumn()) @unlink('../uploads/' . $img);
    $pdo->prepare('DELETE FROM Users WHERE admin_id = ?')->execute([$id]);
}
header('Location: index.php');
