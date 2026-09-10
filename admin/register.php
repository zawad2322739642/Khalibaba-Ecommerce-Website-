<?php
require_once '../includes/config.php';
$pageTitle='Register as admin'; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $idNo=strtoupper(trim($_POST['employee_id']??''));$name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$password=$_POST['password']??'';
  if(!preg_match('/^KHB/i',$idNo))$error='Admin ID must start with KHB.';
  elseif($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<6)$error='Enter a name, valid email, and password of at least 6 characters.';
  else{$role='admin';$hash=password_hash($password,PASSWORD_DEFAULT);$stmt=$conn->prepare('INSERT INTO users(name,email,password,role,employee_id) VALUES(?,?,?,?,?)');$stmt->bind_param('sssss',$name,$email,$hash,$role,$idNo);if($stmt->execute()){header('Location: login.php');exit;} $error='That admin ID or email is already registered.';}
}
include '../includes/header.php';
?><div class="form-card"><h2>Register as new admin</h2><p class="muted">Use your KHB employee ID. Accounts with IDs starting with KHB are automatically approved.</p><?php if($error):?><div class="notice error"><?=e($error)?></div><?php endif;?><form method="post"><div class="form-group"><label>ID number</label><input name="employee_id" maxlength="50" required placeholder="KHB-0004"></div><div class="form-group"><label>Full name</label><input name="name" maxlength="100" required></div><div class="form-group"><label>Email</label><input type="email" name="email" required></div><div class="form-group"><label>Password</label><input type="password" name="password" minlength="6" required></div><button class="btn">Register as admin</button></form><p class="muted"><a href="login.php" style="color:#2563eb">Back to admin login</a></p></div><?php include '../includes/footer.php'; ?>
