<?php
require_once "../includes/config.php"; requireRole('buyer');
if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $action=$_POST['action']??'';
  if($action==='add'){ $id=(int)$_POST['product_id'];$qty=max(1,(int)$_POST['quantity']); $_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+$qty; }
  if($action==='update'){foreach($_POST['qty'] as $id=>$qty){$qty=(int)$qty;if($qty<=0)unset($_SESSION['cart'][$id]);else $_SESSION['cart'][(int)$id]=$qty;}}
  if($action==='remove') unset($_SESSION['cart'][(int)$_POST['product_id']]);
  header("Location: cart.php");exit;
}
$items=[];$total=0;
if($_SESSION['cart']){
  $ids=array_keys($_SESSION['cart']);$in=implode(',',array_fill(0,count($ids),'?'));$types=str_repeat('i',count($ids));
  $stmt=$conn->prepare("SELECT * FROM products WHERE id IN ($in)");$stmt->bind_param($types,...$ids);$stmt->execute();$res=$stmt->get_result();
  while($p=$res->fetch_assoc()){$p['quantity']=$_SESSION['cart'][$p['id']];$p['subtotal']=$p['quantity']*$p['price'];$total+=$p['subtotal'];$items[]=$p;}
}
$pageTitle="Cart";include "../includes/header.php"; ?>
<h1>Your cart</h1>
<?php if(!$items): ?><div class="panel"><p>Your cart is empty.</p><a class="btn" href="../index.php">Continue shopping</a></div>
<?php else: ?>
<div class="panel"><form method="post"><input type="hidden" name="action" value="update">
<?php foreach($items as $p): ?><div class="cart-item"><img src="/Khalibaba/assets/images/<?=e($p['image'])?>">
<div><b><?=e($p['name'])?></b><div class="muted"><?=taka($p['price'])?> each</div></div>
<input class="qty" type="number" min="0" max="<?=$p['stock']?>" name="qty[<?=$p['id']?>]" value="<?=$p['quantity']?>">
<div><b><?=taka($p['subtotal'])?></b><form></form></div></div><?php endforeach; ?>
<div class="row" style="margin-top:20px"><b>Total: <?=taka($total)?></b><div><button class="btn secondary">Update cart</button> <a class="btn" href="checkout.php">Proceed to order</a></div></div></form></div>
<?php endif; ?>
<?php include "../includes/footer.php"; ?>