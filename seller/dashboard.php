<?php
require_once "../includes/config.php";requireRole('seller');$sid=$_SESSION['user']['id'];
$notice='';$error='';
$sellerCheck=$conn->prepare("SELECT seller_status FROM users WHERE id=?");$sellerCheck->bind_param("i",$sid);$sellerCheck->execute();$sellerStatus=$sellerCheck->get_result()->fetch_assoc()['seller_status'];
if($sellerStatus!=='Approved'){ $pageTitle='Seller approval'; include '../includes/header.php'; echo '<div class="panel"><h1>Seller account pending review</h1><p class="muted">An administrator must approve your seller profile before you can manage marketplace listings and orders.</p></div>'; include '../includes/footer.php'; exit; }
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['order_action'],$_POST['order_id'])){
 $orderId=(int)$_POST['order_id'];$action=$_POST['order_action'];
 $transitions=['process'=>['Pending','Processing','Order is being prepared'],'ship'=>['Processing','Shipped','Order shipped'],'cancel'=>['Pending','Cancelled','Order cancelled by seller']];
 if(isset($transitions[$action])){
   [$expectedStatus,$newStatus,$statusNote]=$transitions[$action];
   $conn->begin_transaction();
   try{
     $check=$conn->prepare("SELECT id FROM orders WHERE id=? AND status=? AND EXISTS(SELECT 1 FROM order_items WHERE order_id=? AND seller_id=?) AND NOT EXISTS(SELECT 1 FROM order_items WHERE order_id=? AND seller_id<>?) FOR UPDATE");$check->bind_param("isiiii",$orderId,$expectedStatus,$orderId,$sid,$orderId,$sid);$check->execute();
     if(!$check->get_result()->fetch_assoc())throw new Exception('This order is no longer available for this action.');
     if($action==='cancel'){$restore=$conn->prepare("UPDATE products p JOIN order_items oi ON oi.product_id=p.id SET p.stock=p.stock+oi.quantity WHERE oi.order_id=?");$restore->bind_param("i",$orderId);$restore->execute();}
     $update=$conn->prepare("UPDATE orders SET status=? WHERE id=?");$update->bind_param("si",$newStatus,$orderId);$update->execute();recordOrderStatus($conn,$orderId,$newStatus,$sid,$statusNote);$conn->commit();$notice='Order status updated to '.$newStatus.'.';
   }catch(Exception $e){$conn->rollback();$error=$e->getMessage();}
 }
}
$stmt=$conn->prepare("SELECT COUNT(*) c FROM products WHERE seller_id=?");$stmt->bind_param("i",$sid);$stmt->execute();$products=$stmt->get_result()->fetch_assoc()['c'];
$stmt=$conn->prepare("SELECT COUNT(DISTINCT order_id) c FROM order_items WHERE seller_id=?");$stmt->bind_param("i",$sid);$stmt->execute();$orders=$stmt->get_result()->fetch_assoc()['c'];
$stmt=$conn->prepare("SELECT COALESCE(SUM(oi.quantity*oi.unit_price),0) total FROM order_items oi WHERE seller_id=?");$stmt->bind_param("i",$sid);$stmt->execute();$sales=$stmt->get_result()->fetch_assoc()['total'];
$stmt=$conn->prepare("SELECT name,category,price FROM products WHERE seller_id=? AND stock=0 ORDER BY created_at DESC");$stmt->bind_param("i",$sid);$stmt->execute();$stockOut=$stmt->get_result();
$stmt=$conn->prepare("SELECT oi.order_id,oi.quantity,oi.unit_price,o.status,o.created_at,p.name,b.name buyer FROM order_items oi JOIN orders o ON oi.order_id=o.id JOIN products p ON oi.product_id=p.id JOIN users b ON o.buyer_id=b.id WHERE oi.seller_id=? ORDER BY o.created_at DESC");$stmt->bind_param("i",$sid);$stmt->execute();$orderRows=$stmt->get_result();
$pageTitle="Seller Dashboard";include "../includes/header.php"; ?>
<div class="section-head"><div><h1>Seller Dashboard</h1><p class="muted">Manage products and incoming orders.</p></div><a class="btn" href="products.php">Manage products</a></div>
<?php if($notice): ?><div class="notice success"><?=e($notice)?></div><?php endif; ?><?php if($error): ?><div class="notice error"><?=e($error)?></div><?php endif; ?>
<div class="stats"><div class="stat">Products<b><?=$products?></b></div><div class="stat">Orders<b><?=$orders?></b></div><div class="stat">Sales<b><?=taka($sales)?></b></div><div class="stat">Role<b>Seller</b></div></div>
<div class="panel"><h2>Incoming orders</h2><div class="table-wrap"><table class="table"><tr><th>Order</th><th>Product</th><th>Buyer</th><th>Qty</th><th>Status</th><th>Date</th><th>Actions</th></tr>
<?php while($r=$orderRows->fetch_assoc()): ?><tr><td>#<?=$r['order_id']?></td><td><?=e($r['name'])?></td><td><?=e($r['buyer'])?></td><td><?=$r['quantity']?></td><td><span class="badge <?=$r['status']?>"><?=e($r['status'])?></span></td><td><?=date('d M',strtotime($r['created_at']))?></td><td><?php if($r['status']==='Pending'): ?><div class="order-actions"><form method="post"><input type="hidden" name="order_id" value="<?=$r['order_id']?>"><input type="hidden" name="order_action" value="process"><button class="btn small">Start processing</button></form><form method="post"><input type="hidden" name="order_id" value="<?=$r['order_id']?>"><input type="hidden" name="order_action" value="cancel"><button class="btn small danger">Cancel</button></form></div><?php elseif($r['status']==='Processing'): ?><form method="post"><input type="hidden" name="order_id" value="<?=$r['order_id']?>"><input type="hidden" name="order_action" value="ship"><button class="btn small">Mark shipped</button></form><?php else: ?><span class="muted">—</span><?php endif; ?></td></tr><?php endwhile; ?></table></div></div>
<div class="panel" style="margin-top:20px"><div class="section-head"><div><h2>Stock out products</h2><p class="muted">Demo items that need restocking.</p></div><span class="badge stock-out"><?=$stockOut->num_rows?> stock out</span></div>
<?php if($stockOut->num_rows): ?><div class="table-wrap"><table class="table"><tr><th>Product</th><th>Category</th><th>Price</th><th>Status</th></tr><?php while($p=$stockOut->fetch_assoc()): ?><tr><td><?=e($p['name'])?></td><td><?=e($p['category'])?></td><td><?=taka($p['price'])?></td><td><span class="badge stock-out">Stock out</span></td></tr><?php endwhile; ?></table></div><?php else: ?><p class="muted">No products are currently out of stock.</p><?php endif; ?></div>
<?php include "../includes/footer.php"; ?>
