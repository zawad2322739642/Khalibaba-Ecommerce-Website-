<?php
require_once 'includes/config.php';
$ids=array_values(array_unique(array_filter(array_map('intval',$_GET['ids']??[])))); $ids=array_slice($ids,0,3);
if(count($ids)<2){header('Location: index.php');exit;}
$marks=implode(',',array_fill(0,count($ids),'?'));$types=str_repeat('i',count($ids));$stmt=$conn->prepare("SELECT p.*,COALESCE(AVG(r.rating),0) rating FROM products p LEFT JOIN reviews r ON r.product_id=p.id WHERE p.id IN ($marks) GROUP BY p.id");$stmt->bind_param($types,...$ids);$stmt->execute();$products=$stmt->get_result();
$rows=['Brand'=>'brand','Category'=>'category','Price'=>'price','Availability'=>'stock','Warranty'=>'warranty','Specifications'=>'specifications','Customer rating'=>'rating'];$pageTitle='Compare products';include 'includes/header.php'; ?>
<div class="section-head"><div><h1>Compare products</h1><p class="muted">Compare specifications, warranty, availability, and customer ratings side by side.</p></div><a class="btn secondary" href="index.php">Back to catalog</a></div>
<div class="table-wrap compare-table"><table class="table"><tr><th>Feature</th><?php $items=[];while($p=$products->fetch_assoc()){$items[]=$p;?><th><a href="buyer/product.php?id=<?=$p['id']?>"><?=e($p['name'])?></a></th><?php }?></tr><?php foreach($rows as $label=>$field):?><tr><th><?=e($label)?></th><?php foreach($items as $p):?><td><?php if($field==='price'):?><?=taka($p[$field])?><?php elseif($field==='stock'):?><?=$p['stock']>0?$p['stock'].' in stock':'Out of stock'?><?php elseif($field==='rating'):?><?=number_format($p[$field],1)?> / 5<?php else:?><?=nl2br(e($p[$field]?:'Not provided'))?><?php endif;?></td><?php endforeach;?></tr><?php endforeach;?></table></div>
<?php include 'includes/footer.php'; ?>
