<?php
require_once "../includes/config.php"; $id=(int)($_GET['id']??0);
$stmt=$conn->prepare("SELECT p.*,u.name seller_name FROM products p JOIN users u ON p.seller_id=u.id WHERE p.id=?");
$stmt->bind_param("i",$id);$stmt->execute();$p=$stmt->get_result()->fetch_assoc();
if(!$p){header("Location: ../index.php");exit;}
$pageTitle=$p['name']; include "../includes/header.php";
?>
<div class="detail"><div class="detail-img"><img src="/Khalibaba/assets/images/<?=e($p['image'])?>"></div>
<div><div class="category"><?=e($p['category'])?></div><h1><?=e($p['name'])?></h1><div class="price"><?=taka($p['price'])?></div>
<p><?=nl2br(e($p['description']))?></p><p class="muted">Seller: <?=e($p['seller_name'])?> · <?=$p['stock']?> available</p>
<?php if(isset($_SESSION['user']) && $_SESSION['user']['role']==='buyer'): ?>
<form method="post" action="cart.php"><input type="hidden" name="action" value="add"><input type="hidden" name="product_id" value="<?=$p['id']?>">
<label>Quantity <input class="qty" type="number" name="quantity" value="1" min="1" max="<?=$p['stock']?>"></label>
<button class="btn" style="margin-left:8px">Add to cart</button></form>
<?php else: ?><a class="btn" href="../auth/login.php">Login to buy</a><?php endif; ?>
</div></div>
<?php include "../includes/footer.php"; ?>