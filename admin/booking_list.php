
<?php
include('../config/condb.php');
include('header.php');
// include('navbar.php');
include('sidebar_menu.php');


//คิวรี่ข้อมูลห้อง
$queryRoom = $condb->prepare("SELECT * FROM tbl_room ORDER BY room_id DESC");
$queryRoom->execute();
$rsRoom = $queryRoom->fetchAll();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>จัดการข้อมูลห้องพัก
                        <a href="booking.php?act=add" class="btn btn-primary">+ข้อมูล</a>
                    </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="table-info">
                                        <th width="5%" class="text-center">No.</th>
                                        <th width="10%">ภาพ</th>
                                        <th width="25%">ชื่อห้อง</th>
                                        <th width="30%">รายละเอียด</th>
                                        <th width="10%" class="text-center">ราคา</th>
                                        <th width="10%" class="text-center">สถานะ</th>
                                        <th width="5%" class="text-center">แก้ไข</th>
                                        <th width="5%" class="text-center">ลบ</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1; //start number
                                    foreach ($rsRoom as $row) { ?>
                                        <tr>
                                            <td align="center"><?= $i++ ?></td>
                                            <td><img src="../assets/room_img/<?= $row['room_image']; ?>" width="70px"></td>
                                            <td><?= $row['room_name']; ?></td>
                                            <td><?= $row['room_detail']; ?></td>
                                            <td align="right"><?= number_format($row['room_price'], 2); ?></td>
                                            <td align="center"><?= $row['room_status']; ?></td>

                                            <td align="center">
                                                <a href="booking.php?act=edit&id=<?= $row['room_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                                            </td>

                                            <td align="center">
                                                <a href="booking_delete.php?id=<?= $row['room_id']; ?>&act=delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบห้องพัก?');">ลบ</a>

                                            </td>
                                        </tr>
                                    <?php } ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->