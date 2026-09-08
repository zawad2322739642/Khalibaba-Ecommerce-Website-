<?php
require_once "../includes/config.php";requireRole('seller');$sid=$_SESSION['user']['id'];$message="";$isError=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(isset($_POST['add_demo_catalog'])){
  $demoProducts=[
   ['USB-C Fast Charging Cable','Cables','Durable 1 meter USB-C cable with fast charging support.',450,25,'usb-c.svg'],
   ['Wireless Mouse','Computer Accessories','Ergonomic 2.4GHz wireless mouse for everyday use.',850,18,'mouse.svg'],
   ['Bluetooth Earbuds','Audio','Compact wireless earbuds with charging case.',1650,12,'earbuds.svg'],
   ['65W GaN Charger','Chargers','Compact 65W USB-C GaN wall charger.',2200,10,'charger.svg'],
   ['Laptop Stand','Computer Accessories','Foldable aluminum laptop stand for desk setups.',1450,8,'stand.svg'],
   ['Power Bank 20000mAh','Power Banks','High-capacity fast-charging power bank with dual USB output.',1950,20,'charger.svg']
  ];
  $check=$conn->prepare("SELECT id FROM products WHERE seller_id=? AND name=?");
  $insert=$conn->prepare("INSERT INTO products(seller_id,name,category,description,price,stock,image) VALUES(?,?,?,?,?,?,?)");$added=0;
  foreach($demoProducts as $p){$check->bind_param("is",$sid,$p[0]);$check->execute();if(!$check->get_result()->num_rows){$insert->bind_param("isssdis",$sid,$p[0],$p[1],$p[2],$p[3],$p[4],$p[5]);if($insert->execute())$added++;}}
  $message=$added ? "$added demo products added to your catalog." : "Your demo catalog is already added.";
 } else {
  $name=trim($_POST['name']);$category=trim($_POST['category']);$description=trim($_POST['description']);$price=(float)$_POST['price'];$stock=(int)$_POST['stock'];$image='usb-c.svg';$uploadError='';
  if(isset($_FILES['image']) && $_FILES['image']['error']!==UPLOAD_ERR_NO_FILE){
   $info=@getimagesize($_FILES['image']['tmp_name']);$types=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
   if($_FILES['image']['error']!==UPLOAD_ERR_OK || !$info || !isset($types[$info['mime']])){$uploadError='Please choose a valid JPG, PNG, WEBP, or GIF image.';}
   else {$folder=__DIR__."/../assets/images/uploads";if(!is_dir($folder) && !mkdir($folder,0755,true)){$uploadError='Unable to create the image upload folder.';}else{$image='uploads/'.bin2hex(random_bytes(8)).'.'.$types[$info['mime']];if(!move_uploaded_file($_FILES['image']['tmp_name'],__DIR__."/../assets/images/".$image))$uploadError='Unable to save the uploaded image.';}}
  }
  if($uploadError){$message=$uploadError;$isError=true;}else{$stmt=$conn->prepare("INSERT INTO products(seller_id,name,category,description,price,stock,image) VALUES(?,?,?,?,?,?,?)");$stmt->bind_param("isssdis",$sid,$name,$category,$description,$price,$stock,$image);if($stmt->execute())$message="Product added successfully.";}
 }
}
$stmt=$conn->prepare("SELECT * FROM products WHERE seller_id=? ORDER BY created_at DESC");$stmt->bind_param("i",$sid);$stmt->execute();$products=$stmt->get_result();
$pageTitle="My Products";include "../includes/header.php"; ?>
<div class="dashboard-grid"><div class="panel"><h2>Add product</h2><?php if($message): ?><div class="notice <?=$isError?'error':'success'?>"><?=e($message)?></div><?php endif; ?>
<form method="post" style="margin-bottom:18px"><input type="hidden" name="add_demo_catalog" value="1"><button class="btn" type="submit">Add demo catalog</button><p class="muted"><small>Add six sample products to this seller account.</small></p></form>
<form method="post" enctype="multipart/form-data"><div class="form-group"><label>Product name</label><input name="name" required></div><div class="form-group"><label>Category</label><input name="category" required placeholder="Chargers"></div><div class="form-group"><label>Description</label><textarea name="description"></textarea></div><div class="form-group"><label>Product photo <span class="muted">(optional)</span></label><input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"><small class="muted">JPG, PNG, WEBP, or GIF.</small></div><div class="row"><div class="form-group" style="flex:1"><label>Price (BDT)</label><input type="number" step=".01" name="price" required></div><div class="form-group" style="flex:1"><label>Stock</label><input type="number" name="stock" required></div></div><button class="btn">Add product</button></form></div>
<div class="panel"><h2>Your catalog</h2><?php while($p=$products->fetch_assoc()): ?><div class="row" style="padding:12px 0;border-bottom:1px solid #e7ebf0"><span><b><?=e($p['name'])?></b><br><small class="muted"><?php if((int)$p['stock']>0): ?><?=$p['stock']?> stock<?php else: ?><span class="badge Cancelled">Out of stock</span><?php endif; ?></small></span><b><?=taka($p['price'])?></b></div><?php endwhile; ?></div></div>
<?php include "../includes/footer.php"; ?>
