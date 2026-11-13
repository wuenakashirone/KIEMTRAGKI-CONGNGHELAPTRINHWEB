<?php
require '../config.php';
$users = $pdo->query('SELECT * FROM Users ORDER BY admin_id')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Quản trị Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
</head>
<body>
<div class="topbar">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h2><i class="bi bi-people-fill me-2"></i>Quản trị Users</h2>
        <div class="sub">Tổng <?= count($users) ?> người dùng</div>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="../index.php" class="btn btn-soft"><i class="bi bi-house me-1"></i>Trang chủ</a>
        <a href="form.php" class="btn btn-add"><i class="bi bi-plus-lg me-1"></i>Thêm mới</a>
      </div>
    </div>
  </div>
</div>

<div class="container pb-5">
  <div class="card main-card">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr><th>ID</th><th>Ảnh</th><th>Email</th><th class="text-end">Thao tác</th></tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><span class="id-badge">#<?= (int)$u['admin_id'] ?></span></td>
            <td>
              <?php if ($u['images']): ?>
                <img class="avatar" src="../uploads/<?= e($u['images']) ?>" alt="">
              <?php else: ?>
                <span class="avatar-ph"><?= e(strtoupper(mb_substr($u['admin_email'], 0, 1))) ?></span>
              <?php endif; ?>
            </td>
            <td><?= e($u['admin_email']) ?></td>
            <td class="text-end text-nowrap">
              <a class="btn btn-sm btn-edit" href="form.php?id=<?= (int)$u['admin_id'] ?>"><i class="bi bi-pencil-square me-1"></i>Sửa</a>
              <form method="post" action="delete.php" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                <input type="hidden" name="id" value="<?= (int)$u['admin_id'] ?>">
                <button class="btn btn-sm btn-del"><i class="bi bi-trash me-1"></i>Xóa</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$users): ?>
          <tr><td colspan="4" class="text-center text-muted py-5">Chưa có người dùng nào</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
