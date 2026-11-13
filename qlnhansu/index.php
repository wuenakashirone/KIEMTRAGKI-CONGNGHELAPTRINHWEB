<?php
require 'config.php';
$users = $pdo->query('SELECT * FROM Users ORDER BY admin_id')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Danh sách người dùng</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background: #f4f6fb; }
  .avatar { width: 48px; height: 48px; object-fit: cover; border-radius: 50%; background: #dee2e6; }
</style>
</head>
<body>
<div class="container py-4">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2 class="mb-0">Danh sách người dùng (Users)</h2>
    <a href="admin/index.php" class="btn btn-primary">Vào trang quản trị</a>
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr><th>ID</th><th>Ảnh</th><th>Email</th><th>Mật khẩu</th></tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= e($u['admin_id']) ?></td>
            <td><?php if ($u['images']): ?>
                  <img class="avatar" src="uploads/<?= e($u['images']) ?>" alt="">
                <?php else: ?><div class="avatar"></div><?php endif; ?></td>
            <td><?= e($u['admin_email']) ?></td>
            <td><?= e(str_repeat('•', 8)) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$users): ?><tr><td colspan="4" class="text-center text-muted">Chưa có dữ liệu</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
