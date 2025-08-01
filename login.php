<?php
//เริ่มต้นการใช้เซสซั่น
session_start();

//เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/condb.php';

//ลบตัวแปร
// unset($_SESSION['staff_name']);

//เคลียทั้งหมด
// session_destroy();

//แสดงตัวแปรเซสซั่นทั้งหมด
// echo '<pre>';
// print_r($_SESSION);

// exit;

//ประกาศตัวแปร
// $_SESSION['staff_id'] = 1;
// $_SESSION['staff_name'] = 'owen';
// $_SESSION['staff_role'] = 'admin';

// echo '<pre>';
// print_r($_POST);

//สร้างเงื่อนไขตรวจสอบ input ที่ส่งมาจากฟอร์ม
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action'] == 'login'){

     //ประกาศตัวแปรรับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = sha1($_POST['password']); //เก็บรหัสผ่านในรูปแบบ sha1 
 
    //check username  & password
      $stmtLogin = $condb->prepare("SELECT id, m_level FROM tbl_member WHERE username = :username AND password = :password");
      // STP INT
      $stmtLogin->bindParam(':username', $username , PDO::PARAM_STR);
      $stmtLogin->bindParam(':password', $password , PDO::PARAM_STR);
      $stmtLogin->execute();
 
      //กรอก username & password ถูกต้อง
      if($stmtLogin->rowCount() == 1){
        //fetch เพื่อเรียกคอลัมภ์ที่ต้องการไปสร้างตัวแปร session
        $row = $stmtLogin->fetch(PDO::FETCH_ASSOC); //single role
        //สร้างตัวแปร session
        $_SESSION['staff_id'] = $row['id'];
        $_SESSION['m_level'] = $row['m_level'];
        
        //เช็คว่ามีตัวแปร session อะไรบ้าง
        //print_r($_SESSION);
       // exit();

    //    $conndb= null; //close connect db

       //สร้างเงื่อนไขตรวจสอบสิทธิ์การใช้งาน
       if($_SESSION['m_level'] == 'admin'){//admin
        header('Location: admin/'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
       }else if($_SESSION['m_level'] == 'staff'){
        //staff
         header('Location: staff/'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
        }else if($_SESSION['m_level'] == 'member'){
        //staff
         header('Location: member/'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
       }
       
 
         
      }else{ //ถ้า username or password ไม่ถูกต้อง
 
         echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                             text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
              
            } //else

}//isset

?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css?v=3.2.0">

     <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

</head>

 <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
           <b>From</b>Login
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">

                <p class="login-box-msg">Login เข้าสู่ระบบ</p> 

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="username" class="form-control" placeholder="Email/Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                   
                        <div class="col-12">
                            <button type="submit" name="action" value="login" class="btn btn-danger btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <p>- ติดต่อ -</p>                    
                </div>
                <p class="mb-1">
                    <a href="index.php">กลับหน้าหลัก</a>
                </p>
                <p class="mb-0">
                    <a href="" class="text-center">แฟนเพจ</a>
                </p>
            </div>        
        </div>
    </div>
 </body>
</html>