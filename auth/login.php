<?php
require_once "../includes/config.php";
$pageTitle="Login"; $error="";
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $email=trim($_POST['email']); $password=$_POST['password'];
  $stmt=$conn->prepare("SELECT id,name,email,password,role FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s",$email); $stmt->execute(); $u=$stmt->get_result()->fetch_assoc();
  if($u && (password_verify($password,$u['password']) || md5($password)===$u['password'])) {
    $_SESSION['user']=$u;
    if($u['role']==='seller') header("Location: ../seller/dashboard.php");
    else header("Location: ../buyer/dashboard.php");
    exit;
  } else $error="Invalid email or password.";
}
include "../includes/header.php";
?>
<div class="form-card"><h2>Welcome back</h2><p class="muted">Log in to your Khalibaba account.</p>
<?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="form-group"><label>Email</label><input type="email" name="email" required></div>
<div class="form-group"><label>Password</label><input type="password" name="password" required></div><button class="btn">Login</button></form>
<p class="muted">No account? <a href="register.php" style="color:#2563eb">Create one</a></p>
<p class="muted"><small>Demo buyer: buyer@khalibaba.com / 123456<br>Demo seller: seller@khalibaba.com / 123456</small></p>
</div><?php include "../includes/footer.php"; ?>