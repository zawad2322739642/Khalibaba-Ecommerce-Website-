<?php
require_once "../includes/config.php";requireRole('buyer');$id=(int)($_GET['id']??0);$uid=$_SESSION['user']['id'];
$notice='';$error='';
if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action']??'')==='confirm_delivery'){
 $conn->begin_transaction();
 try{
  $update=$conn->prepare("UPDATE orders SET status='Delivered' WHERE id=? AND buyer_id=? AND status='Shipped'");$update->bind_param('ii',$id,$uid);$update->execute();
  if($update->affected_rows!==1)throw new Exception('Only shipped orders can be confirmed as delivered.');
  recordOrderStatus($conn,$id,'Delivered',$uid,'Delivery confirmed by buyer');$conn->commit();$notice='Delivery confirmed. You can now leave a review or request a return if needed.';
 }catch(Exception $e){$conn->rollback();$error=$e->getMessage();}
}
$stmt=$conn->prepare("SELECT * FROM orders WHERE id=? AND buyer_id=?");$stmt->bind_param("ii",$id,$uid);$stmt->execute();$o=$stmt->get_result()->fetch_assoc();if(!$o){header("Location: dashboard.php");exit;}
$st=$conn->prepare("SELECT oi.*,p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=?");$st->bind_param("i",$id);$st->execute();$items=$st->get_result();
$historyStmt=$conn->prepare("SELECT h.*,u.name actor_name FROM order_status_history h LEFT JOIN users u ON u.id=h.actor_id WHERE h.order_id=? ORDER BY h.created_at ASC,h.id ASC");$historyStmt->bind_param('i',$id);$historyStmt->execute();$history=$historyStmt->get_result();
$pageTitle="Order #".$id;include "../includes/header.php"; ?>
<div class="panel"><div class="row"><div><h1>Order #<?=$o['id']?></h1><p class="muted"><?=date('d M Y, h:i A',strtotime($o['created_at']))?></p></div><span class="badge <?=$o['status']?>"><?=e($o['status'])?></span></div>
<?php if($notice): ?><div class="notice success"><?=e($notice)?></div><?php endif; ?><?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<?php if($o['status']==='Shipped'): ?><div class="notice"><b>Your order has been shipped.</b> When it arrives, confirm delivery to unlock reviews and returns.<form method="post" style="display:inline;margin-left:12px"><input type="hidden" name="action" value="confirm_delivery"><button class="btn small">Confirm delivery</button></form></div><?php endif; ?>
<h3>Items</h3><?php while($i=$items->fetch_assoc()): ?><div class="row" style="padding:10px 0;border-bottom:1px solid #e7ebf0"><span><?=e($i['name'])?> × <?=$i['quantity']?></span><b><?=taka($i['unit_price']*$i['quantity'])?></b></div><?php endwhile; ?>
<h3>Shipping</h3><p><?=nl2br(e($o['shipping_address']))?></p><h2>Total: <?=taka($o['total_amount'])?></h2></div>
<section class="panel" style="margin-top:20px"><h2>Order timeline</h2><?php if($history->num_rows): ?><?php while($event=$history->fetch_assoc()): ?><div class="row" style="padding:10px 0;border-bottom:1px solid var(--line)"><span><span class="badge <?=e($event['status'])?>"><?=e($event['status'])?></span> <?=e($event['note']?:'Status updated')?></span><small class="muted"><?=date('d M Y, h:i A',strtotime($event['created_at']))?><?= $event['actor_name'] ? ' · '.e($event['actor_name']) : '' ?></small></div><?php endwhile; ?><?php else: ?><p class="muted">Order placed · <?=date('d M Y, h:i A',strtotime($o['created_at']))?></p><?php endif; ?></section>
<?php include "../includes/footer.php"; ?>
