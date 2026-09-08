<?php
require_once "../includes/config.php"; requireRole('buyer');
$cart=$_SESSION['cart']??[]; if(!$cart){header("Location: cart.php");exit;}
$ids=array_keys($cart);$in=implode(',',array_fill(0,count($ids),'?'));$types=str_repeat('i',count($ids));
$stmt=$conn->prepare("SELECT * FROM products WHERE id IN ($in)");$stmt->bind_param($types,...$ids);$stmt->execute();$res=$stmt->get_result();
$products=[];$total=0;while($p=$res->fetch_assoc()){$q=$cart[$p['id']];$p['quantity']=$q;$total+=$p['price']*$q;$products[]=$p;}
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $address=trim($_POST['address']??'');
 if(!$address)$error="Please enter a shipping address.";
 else{
   $conn->begin_transaction();
   try{
     $buyer=$_SESSION['user']['id'];$stmt=$conn->prepare("INSERT INTO orders(buyer_id,total_amount,shipping_address) VALUES(?,?,?)");$stmt->bind_param("ids",$buyer,$total,$address);$stmt->execute();$orderId=$conn->insert_id;
     foreach($products as $p){if($p['stock']<$p['quantity'])throw new Exception("Not enough stock for ".$p['name']);$st=$conn->prepare("INSERT INTO order_items(order_id,product_id,seller_id,quantity,unit_price) VALUES(?,?,?,?,?)");$st->bind_param("iiiid",$orderId,$p['id'],$p['seller_id'],$p['quantity'],$p['price']);$st->execute();$st=$conn->prepare("UPDATE products SET stock=stock-? WHERE id=?");$st->bind_param("ii",$p['quantity'],$p['id']);$st->execute();}
     $conn->commit();unset($_SESSION['cart']);header("Location: order.php?id=".$orderId);exit;
   }catch(Exception $ex){$conn->rollback();$error=$ex->getMessage();}
 }
}
$pageTitle="Checkout";include "../includes/header.php"; ?>
<div class="dashboard-grid"><div class="panel"><h2>Confirm order</h2><?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="form-group"><label>Shipping address</label><textarea name="address" required placeholder="House, road, area, city"></textarea></div><button class="btn">Place order · <?=taka($total)?></button></form></div>
<div class="panel"><h3>Order summary</h3><?php foreach($products as $p): ?><div class="row" style="padding:8px 0"><span><?=e($p['name'])?> × <?=$p['quantity']?></span><b><?=taka($p['price']*$p['quantity'])?></b></div><?php endforeach; ?><hr><div class="row"><b>Total</b><b><?=taka($total)?></b></div></div></div>
<?php include "../includes/footer.php"; ?>