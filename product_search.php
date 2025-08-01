 <?php 
 if(isset($_GET['search'])){
 //คิวรี่ข้อมูลค้นหาสินค้า
$queryproduct = $condb->prepare ("SELECT * FROM tbl_product  WHERE `product_name` LIKE :search ORDER BY id DESC ");
// bindParam
$queryproduct->bindValue(':search', '%'.$_GET['search'].'%', PDO::PARAM_STR);
$queryproduct->execute();
$rsproduct = $queryproduct->fetchAll();

 }//isset
 ?>
 
 
 <!-- start product -->
     <div class="container mt-1 ">
        <div class="roe">
            <div class="col-sm-12">
                <div class="alert alert-info" role="alert">
                  <p style="font-size: 20pt;"> รายการสินค้าที่ค้นหา : <?=$_GET['search'];?> </p>
                </div>
            </div>
        </div>


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
                        <p class="card-text">ราคา <?=number_format($row['price_hot,price_cold,price_frappe'],2);?> บาท</p>
                        <a href="detail.php?id=<?=$row['id'];?>&ชื่อสินค้า=<?=$productName;?>&ราคา<?=$row['price_hot,price_cold,price_frappe'];?>-บาท&view=show-product-detail" class="btn btn-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php
    //สร้างเงื่อนไขตรวจสอบการคิวรี่

   if($queryproduct->rowCount() == 0){ //คิวรี่ผิดพลาด

    echo '<h4 class="text-center"> ไม่พบสินค้าที่ค้นหา </h4>';
    
   }
?>


        </div>
      </div>

     <!-- end product -->