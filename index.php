<?php
require_once "includes/config.php";
$pageTitle="Shop";
$q = trim($_GET['q'] ?? '');
$sql = "SELECT p.*, u.name seller_name FROM products p JOIN users u ON p.seller_id=u.id";
if ($q !== '') {
    $stmt=$conn->prepare($sql." WHERE p.name LIKE ? OR p.category LIKE ? ORDER BY p.created_at DESC");
    $like="%".$q."%"; $stmt->bind_param("ss",$like,$like); $stmt->execute(); $products=$stmt->get_result();
} else {
    $products=$conn->query($sql." ORDER BY p.created_at DESC");
}
include "includes/header.php";
?>
<section class="hero">
  <div><h1>Tech accessories.<br>Simple shopping.</h1><p>Welcome to Khalibaba — a minimal marketplace for cables, chargers, audio gear and everyday electronics accessories.</p><a class="btn" href="#products">Browse products</a></div>
  <div class="hero-art">⚡</div>
</section>
<form class="search" method="get"><input name="q" value="<?=e($q)?>" placeholder="Search cables, chargers, earbuds..."><button class="btn">Search</button></form>
<div class="section-head"><h2 id="products">Featured accessories</h2><span class="muted"><?= $products->num_rows ?> products</span></div>
<div class="grid">
<?php while($p=$products->fetch_assoc()): ?>
<article class="card">
  <div class="product-img"><img src="/Khalibaba/assets/images/<?=e($p['image'])?>" alt="<?=e($p['name'])?>"></div>
  <div class="card-body">
    <div class="category"><?=e($p['category'])?></div><h3><?=e($p['name'])?></h3>
    <div class="price"><?=taka($p['price'])?></div>
    <p class="muted"><?=e(substr($p['description'],0,85))?>...</p>
    <div class="row"><span class="muted"><?=$p['stock']?> in stock</span><a class="btn small" href="/Khalibaba/buyer/product.php?id=<?=$p['id']?>">View</a></div>
  </div>
</article>
<?php endwhile; ?>
</div>
<?php include "includes/footer.php"; ?>