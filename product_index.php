 <?php 
 //คิวรี่ข้อมูลสินค้ามาแสดงหน้าแรก
$queryproduct = $condb->prepare ("SELECT * FROM tbl_product ORDER BY id DESC ");
$queryproduct->execute();
$rsproduct = $queryproduct->fetchAll();

 ?>
 
 
 <!-- start product -->
     <div class="container mt-1 ">
        <div class="row">

        <?php foreach($rsproduct as $row){ 
            //ตัดช่องว่างและแทนที่ด้วย -
            $productName = str_replace(' ','-',$row['product_name']);
            // echo $productName;
            ?>
            <div class="col-12 col-sm-3 mb-2">
                <div class="card" style="width: 100%;">
                    <img src="assets/product_img/<?=$row['product_image'];?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?=$row['product_name'];?></h5>
                        <p class="card-text">ราคา(ร้อน) <?=number_format($row['price_hot'],2);?> บาท</p>
                        <p class="card-text">ราคา(เย็น) <?=number_format($row['price_cold'],2);?> บาท</p>
                        <p class="card-text">ราคา(ปั่น) <?=number_format($row['price_frappe'],2);?> บาท</p>
                       <a href="detail.php?id=<?= $row['id']; ?>&ชื่อสินค้า=<?= urlencode($row['product_name']); ?>&ราคา_r=<?= $row['price_hot']; ?>&ราคา_c=<?= $row['price_cold']; ?>&ราคา_f=<?= $row['price_frappe']; ?>&view=show-product-detail" class="btn btn-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
      </div>

     <!-- end product -->