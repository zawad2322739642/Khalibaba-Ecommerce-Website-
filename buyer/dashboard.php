<?php
require_once "../includes/config.php";requireRole('buyer');$uid=$_SESSION['user']['id'];
$stmt=$conn->prepare("SELECT * FROM orders WHERE buyer_id=? ORDER BY created_at DESC");$stmt->bind_param("i",$uid);$stmt->execute();$orders=$stmt->get_result();
$pageTitle="Buyer Dashboard";include "../includes/header.php"; ?>
<div class="section-head"><div><h1>Buyer Dashboard</h1><p class="muted">Track your Khalibaba orders.</p></div><a class="btn" href="../index.php">Shop now</a></div>
<div class="stats"><div class="stat">Orders<b><?=$orders->num_rows?></b></div><?php
$counts=['Pending'=>0,'Processing'=>0,'Shipped'=>0];$orders->data_seek(0);while($x=$orders->fetch_assoc()){if(isset($counts[$x['status']]))$counts[$x['status']]++;}foreach($counts as $k=>$v): ?><div class="stat"><?=e($k)?><b><?=$v?></b></div><?php endforeach;$orders->data_seek(0);?></div>
<div class="table-wrap"><table class="table"><tr><th>Order</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr>
<?php while($o=$orders->fetch_assoc()): ?><tr><td>#<?=$o['id']?></td><td><?=date('d M Y',strtotime($o['created_at']))?></td><td><?=taka($o['total_amount'])?></td><td><span class="badge <?=$o['status']?>"><?=e($o['status'])?></span></td><td><a href="order.php?id=<?=$o['id']?>" style="color:#2563eb">View</a></td></tr><?php endwhile; ?></table></div>
<?php include "../includes/footer.php"; ?>