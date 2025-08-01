 <?php 
 //คิวรี่หมวดหมู่สินค้า
$queryProductType = $condb->prepare ("SELECT * FROM tbl_type  ");
$queryProductType->execute();
$rsprdt = $queryProductType->fetchAll();
 
 ?>
 
 <!-- start menu -->
    <div class="container"
       <div class="row">
          <div class ="col-sm-12">
            <nav class="navbar navbar-expand-lg " style="background-color: red;">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="index.php">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="index.php">หน้าหลัก</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        หมวดหมู่สินค้า
                    </a>
                    <ul class="dropdown-menu">

                    <?php  foreach($rsprdt as $row){?>
                        <li>
                            <a class="dropdown-item" href="category.php?id=<?=$row['type_id'];?>&cat=แสดงสินค้า<?=$row['type_name'];?>">
                                <?=$row['type_name'];?>
                            </a>
                       </li>
                    <?php }?>

                    </ul>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link text-white" href="register.php">สมัครสมาชิก</a>
                    </li>
                    
                    <li class="nav-item">
                    <a href="login.php" class="nav-link text-white">Login</a></a>
                    </li>
                </ul>
                <form method="get" action="search.php" class="d-flex" role="search">
                    <input name="search" class="form-control me-2" type="search" placeholder="ค้นหาชื่อสินค้า" required aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">ค้นหา</button>
                </form>
                </div>
            </div>
            </nav>

          </div>
       </div>
    </div>
    <!-- end menu -->