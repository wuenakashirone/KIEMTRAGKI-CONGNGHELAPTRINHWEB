<?php
require '../config.php';
$id = (int)($_GET['id'] ?? 0);
$row = ['admin_email' => '', 'images' => ''];
if ($id) {
    $st = $pdo->prepare('SELECT * FROM Users WHERE admin_id = ?');
    $st->execute([$id]);
    $row = $st->fetch(PDO::FETCH_ASSOC) ?: die('Không tìm thấy user');
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['admin_email'] ?? '');
    $pass  = $_POST['admin_password'] ?? '';
    $img   = $row['images'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Email không hợp lệ';
    else {
        $chk = $pdo->prepare('SELECT COUNT(*) FROM Users WHERE admin_email = ? AND admin_id <> ?');
        $chk->execute([$email, $id]);
        if ($chk->fetchColumn() > 0) $error = 'Email này đã tồn tại, vui lòng dùng email khác';
        elseif (!$id && $pass === '') $error = 'Vui lòng nhập mật khẩu';
    }

    if (!$error && !empty($_FILES['images']['name'])) {
        $ext = strtolower(pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) $error = 'Chỉ cho phép file ảnh';
        else {
            $img = uniqid('u_') . '.' . $ext;
            move_uploaded_file($_FILES['images']['tmp_name'], '../uploads/' . $img);
        }
    }
    if (!$error) {
        if ($id) {
            if ($pass !== '') {
                $pdo->prepare('UPDATE Users SET admin_email=?, admin_password=?, images=? WHERE admin_id=?')
                    ->execute([$email, password_hash($pass, PASSWORD_DEFAULT), $img, $id]);
            } else {
                $pdo->prepare('UPDATE Users SET admin_email=?, images=? WHERE admin_id=?')
                    ->execute([$email, $img, $id]);
            }
        } else {
            $pdo->prepare('INSERT INTO Users (admin_email, admin_password, images) VALUES (?,?,?)')
                ->execute([$email, password_hash($pass, PASSWORD_DEFAULT), $img]);
        }
        header('Location: index.php'); exit;
    }
    $row['admin_email'] = $email;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $id ? 'Sửa' : 'Thêm' ?> user</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
</head>
<body>
<div class="topbar">
  <div class="container">
    <h2><i class="bi bi-<?= $id ? 'pencil-square' : 'person-plus-fill' ?> me-2"></i><?= $id ? 'Sửa user #' . $id : 'Thêm user mới' ?></h2>
    <div class="sub">Điền thông tin bên dưới rồi bấm Lưu</div>
  </div>
</div>
<div class="container pb-5" style="max-width:600px">
  <div class="card main-card"><div class="card-body p-4">
    <?php if ($error): ?><div class="alert alert-danger py-2"><i class="bi bi-exclamation-triangle me-1"></i><?= e($error) ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="admin_email" class="form-control" placeholder="ten@gmail.com" value="<?= e($row['admin_email']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Mật khẩu <?= $id ? '<small class="text-muted fw-normal">(để trống nếu không đổi)</small>' : '' ?></label>
        <input type="password" name="admin_password" class="form-control" placeholder="Nhập mật khẩu">
      </div>
      <div class="mb-4">
        <label class="form-label fw-semibold">Ảnh đại diện</label>
        <div class="d-flex align-items-center gap-3">
          <img id="pv" class="avatar" style="width:64px;height:64px;<?= $row['images'] ? '' : 'display:none' ?>" src="<?= $row['images'] ? '../uploads/' . e($row['images']) : '' ?>" alt="">
          <input type="file" name="images" accept="image/*" class="form-control"
                 onchange="var f=this.files[0];if(f){var i=document.getElementById('pv');i.src=URL.createObjectURL(f);i.style.display='block'}">
        </div>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-main"><i class="bi bi-check-lg me-1"></i>Lưu</button>
        <a href="index.php" class="btn btn-outline-secondary" style="border-radius:10px">Quay lại</a>
      </div>
    </form>
  </div></div>
</div>
</body>
</html>
