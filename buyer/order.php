<?php
require_once "../includes/config.php";requireRole('buyer');$id=(int)($_GET['id']??0);$uid=$_SESSION['user']['id'];
$stmt=$conn->prepare("SELECT * FROM orders WHERE id=? AND buyer_id=?");$stmt->bind_param("ii",$id,$uid);$stmt->execute();$o=$stmt->get_result()->fetch_assoc();if(!$o){header("Location: dashboard.php");exit;}
$st=$conn->prepare("SELECT oi.*,p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=?");$st->bind_param("i",$id);$st->execute();$items=$st->get_result();
$pageTitle="Order #".$id;include "../includes/header.php"; ?>
<div class="panel"><div class="row"><div><h1>Order #<?=$o['id']?></h1><p class="muted"><?=date('d M Y, h:i A',strtotime($o['created_at']))?></p></div><span class="badge <?=$o['status']?>"><?=e($o['status'])?></span></div>
<h3>Items</h3><?php while($i=$items->fetch_assoc()): ?><div class="row" style="padding:10px 0;border-bottom:1px solid #e7ebf0"><span><?=e($i['name'])?> × <?=$i['quantity']?></span><b><?=taka($i['unit_price']*$i['quantity'])?></b></div><?php endwhile; ?>
<h3>Shipping</h3><p><?=nl2br(e($o['shipping_address']))?></p><h2>Total: <?=taka($o['total_amount'])?></h2></div>
<?php include "../includes/footer.php"; ?>