<?php
session_start();
require_once('../config/condb.php');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['member_id'])) {
    echo "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    exit;
}

$member_id = $_SESSION['member_id'];

// ดึงคำสั่งซื้อทั้งหมดของผู้ใช้
$stmt = $condb->prepare("SELECT * FROM tbl_order WHERE member_id = :member_id ORDER BY order_date DESC");
$stmt->execute(['member_id' => $member_id]);
$orders = $stmt->fetchAll();
?>

<h2>คำสั่งซื้อของคุณ</h2>

<table border="1" cellpadding="10" width="100%">
    <tr style="background-color:#f0f0f0;">
        <th>รหัสคำสั่งซื้อ</th>
        <th>เวลาสั่ง</th>
        <th>เวลารับ</th>
        <th>หมายเหตุ</th>
        <th>สถานะ</th>
        <th>รายละเอียด</th>
    </tr>

    <?php foreach ($orders as $row): ?>
        <tr>
            <td><?= $row['order_id'] ?></td>
            <td><?= $row['order_date'] ?></td>
            <td><?= $row['pickup_time'] ?></td>
            <td><?= htmlspecialchars($row['customer_note']) ?></td>
            <td>
                <?php
                switch ($row['status']) {
                    case 'รอดำเนินการ':
                        echo '<span style="color:orange;">รอดำเนินการ</span>';
                        break;
                    case 'กำลังทำ':
                        echo '<span style="color:blue;">กำลังทำ</span>';
                        break;
                    case 'เสร็จแล้ว':
                        echo '<span style="color:green;">เสร็จแล้ว</span>';
                        break;
                    default:
                        echo $row['status'];
                }
                ?>
            </td>
            <td><a href="member_order_detail.php?order_id=<?= $row['order_id'] ?>">ดู</a></td>
        </tr>
    <?php endforeach; ?>
</table>
