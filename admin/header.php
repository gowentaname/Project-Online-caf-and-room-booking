<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// print_r($_SESSION);

//สร้างเงื่อนไขตรวจสอบว่ามีการล็อคอินมาแล้วหรือยัง และเป็นสิทธ์ admin หรือไม่

//ถ้าไม่มีการล็อคอิน
if (empty($_SESSION['m_level']) && empty($_SESSION['staff_id'])){ 
    header('Location: ../logout.php'); //ดีดออกไป
}

//เช็คว่าเป็นแอดมินหรือไม่
if(isset($_SESSION['m_level']) && isset($_SESSION['staff_id']) && $_SESSION['m_level'] !='admin'){ 
    header('Location: ../logout.php'); //ดีดออกไป
}

//ไฟล์เชื่อมต่อฐานข้อมูล
  require_once '../config/condb.php';
?>

<!DOCTYPE html>
  <html lang="en">
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

   </head>
  <body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">