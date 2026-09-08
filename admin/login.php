<?php
require_once '../includes/config.php';
$pageTitle='Admin login';
$error='';

if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
  header('Location: dashboard.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email=trim($_POST['email']??'');
  $password=$_POST['password']??'';
  $stmt=$conn->prepare("SELECT id,name,email,password,role FROM users WHERE email=? AND role='admin' LIMIT 1");
  $stmt->bind_param('s',$email);
  $stmt->execute();
  $admin=$stmt->get_result()->fetch_assoc();
  if ($admin && (password_verify($password,$admin['password']) || md5($password)===$admin['password'])) {
    session_regenerate_id(true);
    $_SESSION['user']=$admin;
    header('Location: dashboard.php');
    exit;
  }
  $error='Invalid administrator email or password.';
}

include '../includes/header.php';
?>
<div class="form-card"><h2>Administrator login</h2><p class="muted">This sign-in is reserved for marketplace administrators.</p>
<?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="form-group"><label>Email</label><input type="email" name="email" required></div>
<div class="form-group"><label>Password</label><input type="password" name="password" required></div><button class="btn">Sign in as administrator</button></form>
<p class="muted"><a href="../auth/login.php" style="color:#2563eb">Buyer or seller? Use regular login</a></p>
</div>
<?php include '../includes/footer.php'; ?>
