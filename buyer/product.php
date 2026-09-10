<?php
require_once "../includes/config.php"; $id=(int)($_GET['id']??0); $reviewError=''; $reviewSuccess=''; $reportMessage='';
$stmt=$conn->prepare("SELECT p.*,u.name seller_name FROM products p JOIN users u ON p.seller_id=u.id WHERE p.id=?");
$stmt->bind_param("i",$id);$stmt->execute();$p=$stmt->get_result()->fetch_assoc();
if(!$p){header("Location: ../index.php");exit;}
if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action']??'')==='report' && isset($_SESSION['user'])){
  $reason=trim($_POST['reason']??''); if($reason!==''){$reporter=(int)$_SESSION['user']['id'];$report=$conn->prepare('INSERT INTO content_reports(reporter_id,product_id,reason) VALUES(?,?,?)');$report->bind_param('iis',$reporter,$id,$reason);$report->execute();$reportMessage='Thanks. The marketplace team will review this report.';}
}
$canReview=false;
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='buyer'){
  $buyerId=(int)$_SESSION['user']['id'];
  $purchase=$conn->prepare("SELECT 1 FROM order_items oi JOIN orders o ON o.id=oi.order_id WHERE oi.product_id=? AND o.buyer_id=? AND o.status='Delivered' LIMIT 1");
  $purchase->bind_param("ii",$id,$buyerId);$purchase->execute();$canReview=(bool)$purchase->get_result()->fetch_assoc();
  if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action']??'')==='review'){
    $rating=(int)($_POST['rating']??0);$reviewText=trim($_POST['review_text']??'');
    if(!$canReview)$reviewError='Only customers with a delivered order can review this product.';
    elseif($rating<1 || $rating>5 || $reviewText==='')$reviewError='Choose a rating and write a short review.';
    else {$save=$conn->prepare("INSERT INTO reviews(product_id,buyer_id,rating,review_text) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE rating=VALUES(rating),review_text=VALUES(review_text),created_at=CURRENT_TIMESTAMP");$save->bind_param("iiis",$id,$buyerId,$rating,$reviewText);$save->execute();$reviewSuccess='Your review has been saved.';}
  }
}
$reviewStmt=$conn->prepare("SELECT r.*,u.name buyer_name FROM reviews r JOIN users u ON u.id=r.buyer_id WHERE r.product_id=? ORDER BY r.created_at DESC");$reviewStmt->bind_param("i",$id);$reviewStmt->execute();$reviews=$reviewStmt->get_result();
$ratingStmt=$conn->prepare("SELECT COUNT(*) review_count, COALESCE(AVG(rating),0) average_rating FROM reviews WHERE product_id=?");$ratingStmt->bind_param("i",$id);$ratingStmt->execute();$ratingSummary=$ratingStmt->get_result()->fetch_assoc();
$pageTitle=$p['name']; include "../includes/header.php";
?>
<div class="detail"><div class="detail-img"><?php if(!empty($p['image'])):?><img src="/Khalibaba/assets/images/<?=e($p['image'])?>" alt="<?=e($p['name'])?>"><?php else:?><span class="blank-product-image">No image available</span><?php endif;?></div>
<div><div class="category"><?=e($p['category'])?></div><h1><?=e($p['name'])?></h1><div class="price"><?=taka($p['price'])?></div>
<p><?=nl2br(e($p['description']))?></p><p class="muted">Brand: <?=e($p['brand']?:'Not provided')?> · Warranty: <?=e($p['warranty']?:'Not provided')?></p><p class="muted">Seller: <?=e($p['seller_name'])?> · <?php if($p['stock'] > 0): ?><?=$p['stock']?> available<?php else: ?><span class="badge stock-out">Stock out</span><?php endif; ?></p>
<?php if($p['specifications']):?><section class="specifications"><h3>Specifications</h3><p><?=nl2br(e($p['specifications']))?></p></section><?php endif;?>
<?php if(isset($_SESSION['user']) && $_SESSION['user']['role']==='buyer'): ?>
<?php if($p['stock'] > 0): ?>
<form method="post" action="cart.php"><input type="hidden" name="action" value="add"><input type="hidden" name="product_id" value="<?=$p['id']?>">
<label>Quantity <input class="qty" type="number" name="quantity" value="1" min="1" max="<?=$p['stock']?>"></label>
<button class="btn" style="margin-left:8px">Add to cart</button></form>
<?php else: ?><button class="btn disabled" disabled>Currently unavailable</button><?php endif; ?>
<?php else: ?><a class="btn" href="../auth/login.php">Login to buy</a><?php endif; ?>
</div></div>
<?php if(isset($_SESSION['user'])): ?><section class="report-product"><details><summary>Report this listing</summary><?php if($reportMessage):?><p class="notice success"><?=e($reportMessage)?></p><?php endif;?><form method="post" class="inline-form"><input type="hidden" name="action" value="report"><input name="reason" maxlength="255" placeholder="Tell us what needs review" required><button class="btn small">Submit report</button></form></details></section><?php endif;?>
<section class="reviews" aria-labelledby="reviews-title"><div class="section-head"><div><h2 id="reviews-title">Customer reviews</h2><p class="muted"><?= $ratingSummary['review_count'] ? number_format($ratingSummary['average_rating'],1) . ' / 5 from ' . $ratingSummary['review_count'] . ' review(s)' : 'No reviews yet' ?></p></div></div>
<?php if($reviewError): ?><div class="notice error"><?=e($reviewError)?></div><?php endif; ?><?php if($reviewSuccess): ?><div class="notice success"><?=e($reviewSuccess)?></div><?php endif; ?>
<?php if($canReview): ?><form class="review-form" method="post"><input type="hidden" name="action" value="review"><label>Rating <select name="rating" required><option value="">Choose</option><option value="5">5 - Excellent</option><option value="4">4 - Good</option><option value="3">3 - Average</option><option value="2">2 - Poor</option><option value="1">1 - Very poor</option></select></label><label>Review <textarea name="review_text" maxlength="1000" required placeholder="Share your experience with this product"></textarea></label><button class="btn small">Save review</button></form><?php elseif(isset($_SESSION['user']) && $_SESSION['user']['role']==='buyer'): ?><p class="muted">Reviews are available after a delivered purchase.</p><?php endif; ?>
<div class="review-list"><?php while($review=$reviews->fetch_assoc()): ?><article class="review"><div class="row"><strong><?=e($review['buyer_name'])?></strong><span class="review-rating"><?=str_repeat('★',(int)$review['rating'])?><span class="muted"><?=str_repeat('☆',5-(int)$review['rating'])?></span></span></div><p><?=nl2br(e($review['review_text']))?></p><small class="muted"><?=date('d M Y',strtotime($review['created_at']))?></small></article><?php endwhile; ?></div></section>
<?php include "../includes/footer.php"; ?>
