<?php
require_once '../includes/config.php';
$pageTitle='Admin login';
$error='';

if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
  header('Location: dashboard.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $employeeId=trim($_POST['employee_id']??'');
  $password=$_POST['password']??'';
  // Keep the seeded demo account compatible with databases created before employee IDs were added.
  $stmt=$conn->prepare("SELECT id,name,email,password,role,employee_id FROM users WHERE role='admin' AND (UPPER(employee_id)=UPPER(?) OR (?='KHB-0003' AND id=3)) LIMIT 1");
  $stmt->bind_param('ss',$employeeId,$employeeId);
  $stmt->execute();
  $admin=$stmt->get_result()->fetch_assoc();
  if ($admin && (password_verify($password,$admin['password']) || md5($password)===$admin['password'])) {
    session_regenerate_id(true);
    $_SESSION['user']=$admin;
    header('Location: dashboard.php');
    exit;
  }
  $error='Invalid administrator ID or password.';
}

include '../includes/header.php';
?>
<div class="form-card"><h2>Administrator login</h2><p class="muted">This sign-in is reserved for marketplace administrators.</p>
<?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="form-group"><label>Admin ID number</label><input name="employee_id" maxlength="50" required autofocus></div>
<div class="form-group"><label>Password</label><input type="password" name="password" required></div><button class="btn">Sign in as administrator</button></form>
<p><a class="btn secondary" href="register.php">Register as a new admin</a></p><p class="muted"><a href="../auth/login.php" style="color:#2563eb">Buyer or seller? Use regular login</a></p>
</div>
<?php include '../includes/footer.php'; ?>
