<?php
require_once "../includes/config.php";
$pageTitle="Register"; $error="";
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $name=trim($_POST['name']); $email=trim($_POST['email']); $password=$_POST['password']; $role=$_POST['role'];
  if(!in_array($role,['buyer','seller'])) $role='buyer';
  $hash=password_hash($password,PASSWORD_DEFAULT);
  $stmt=$conn->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)");
  $stmt->bind_param("ssss",$name,$email,$hash,$role);
  if($stmt->execute()){ header("Location: login.php"); exit; } else $error="Email may already be registered.";
}
include "../includes/header.php"; ?>
<div class="form-card"><h2>Create account</h2><?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="form-group"><label>Full name</label><input name="name" required></div>
<div class="form-group"><label>Email</label><input type="email" name="email" required></div>
<div class="form-group"><label>Password</label><input type="password" name="password" minlength="6" required></div>
<div class="form-group"><label>Account type</label><select name="role"><option value="buyer">Buyer</option><option value="seller">Seller</option></select></div>
<button class="btn">Create account</button></form></div>
<?php include "../includes/footer.php"; ?>