<?php
session_start();
include 'includes/db.php';

// ตรวจสอบว่าล็อกอินแล้วหรือยัง
if (!isset($_SESSION['member_id'])) {
    echo "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    exit;
}

$member_id = $_SESSION['member_id'];

// ดึงคำสั่งซื้อของผู้ใช้
$sql = "SELECT * FROM tbl_order WHERE member_id = $member_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<h2>คำสั่งซื้อของคุณ</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>รหัสคำสั่งซื้อ</th>
        <th>เวลาสั่ง</th>
        <th>เวลารับ</th>
        <th>สถานะ</th>
        <th>รายละเอียด</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['order_id'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td><?= $row['pickup_time'] ?></td>
            <td><?= $row['customer_note'] ?></td>
            <td>
                <?php
                if ($row['status'] === 'รอดำเนินการ') {
                    echo '<span style="color:orange;">รอดำเนินการ</span>';
                } elseif ($row['status'] === 'กำลังทำ') {
                    echo '<span style="color:blue;">กำลังทำ</span>';
                } else {
                    echo '<span style="color:green;">เสร็จแล้ว</span>';
                }
                ?>
            </td>
            <td><a href="my_order_detail.php?order_id=<?= $row['order_id'] ?>">ดู</a></td>
        </tr>
    <?php } ?>
</table>
