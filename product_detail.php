
  <!--start product detail -->

      <div class="container mt-3">
      <div class="row">

        <div class="col-12 col-sm-4 mb-2">
           <a class="fancybox-buttons" data-fancybox-group="button" href="assets/product_img/<?=$rowProduct['product_image'];?>">
          <img src="assets/product_img/<?=$rowProduct['product_image'];?>" width="100%">
           </a>


          <b>ภาพประกอบ</b> <br>


          <div class="row">

          <?php foreach($rsImg as $row){ ?>            
            <div class="col-6 col-sm-3 mb-2">

              <a class="fancybox-buttons" data-fancybox-group="button" href="assets/product_gallery/<?=$row['product_image'];?>">
                 <img src="assets/product_gallery/<?=$row['product_image'];?>" width="100%">
              </a>

            </div>
          <?php } ?>

          </div>

        </div>

        <div class="col-12 col-sm-8 mb-5">
          <h4>
            <font color="blue"><?=$rowProduct['product_name'];?> </font>
            <font color="red">
               ราคา ร้อน : <?=number_format($rowProduct['price_hot'],2);?> บาท
               ราคา เย็น : <?=number_format($rowProduct['price_cold'],2);?> บาท
               ราคา ปั่น : <?=number_format($rowProduct['price_frappe'],2);?> บาท
            </font>
            QTY <?=$rowProduct['product_qty'];?> รายการ
          </h4>
             <?=$rowProduct['product_detail'];?>
             
             จำนวนการเข้าชม <?=$rowProduct['product_view'];?> ครั้ง
        </div>

      </div>
    </div>
     <!-- end product detail -->
