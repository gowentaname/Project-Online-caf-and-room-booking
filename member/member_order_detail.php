<?php
session_start();
require_once('../config/condb.php');

// ตรวจสอบว่าล็อกอินแล้วหรือยัง
if (!isset($_SESSION['member_id'])) {
    echo "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    exit;
}

// รับค่า order_id
if (!isset($_GET['order_id'])) {
    echo "ไม่พบคำสั่งซื้อที่ระบุ";
    exit;
}

$order_id = $_GET['order_id'];
$member_id = $_SESSION['member_id'];

// ตรวจสอบว่าคำสั่งซื้อนี้เป็นของสมาชิกนี้จริง
$stmt = $condb->prepare("SELECT * FROM tbl_order WHERE order_id = :order_id AND member_id = :member_id");
$stmt->execute([
    'order_id' => $order_id,
    'member_id' => $member_id
]);
$order = $stmt->fetch();

if (!$order) {
    echo "ไม่พบคำสั่งซื้อของคุณ";
    exit;
}
?>

<h2>รายละเอียดคำสั่งซื้อ #<?= $order['order_id'] ?></h2>
<p><strong>เวลาสั่ง:</strong> <?= $order['order_date'] ?></p>
<p><strong>เวลารับ:</strong> <?= $order['pickup_time'] ?></p>
<p><strong>สถานะ:</strong> <?= $order['status'] ?></p>
<p><strong>หมายเหตุจากลูกค้า:</strong> <?= nl2br($order['customer_note']) ?></p>

<hr>

<h3>รายการสินค้า</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>ภาพ</th>
        <th>ชื่อสินค้า</th>
        <th>ประเภท</th>
        <th>จำนวน</th>
        <th>ราคาต่อหน่วย</th>
        <th>รวม</th>
    </tr>

    <?php
    $stmt_items = $condb->prepare("
        SELECT 
            oi.*, 
            p.product_name, 
            p.product_image,
            t.type_name 
        FROM tbl_order_item AS oi
        JOIN tbl_product AS p ON oi.product_id = p.id
        JOIN tbl_type AS t ON p.ref_type_id = t.type_id
        WHERE oi.order_id = :order_id
    ");
    $stmt_items->execute(['order_id' => $order_id]);
    $items = $stmt_items->fetchAll();

    $total = 0;
    foreach ($items as $item):
        $subtotal = $item['qty'] * $item['price'];
        $total += $subtotal;
    ?>
    <tr>
        <td><img src="../assets/product_img/<?= $item['product_image'] ?>" width="60"></td>
        <td><?= $item['product_name'] ?></td>
        <td><?= $item['type_name'] ?></td>
        <td align="center"><?= $item['qty'] ?></td>
        <td align="right"><?= number_format($item['price'], 2) ?></td>
        <td align="right"><?= number_format($subtotal, 2) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="5" align="right"><strong>รวมทั้งสิ้น:</strong></td>
        <td align="right"><strong><?= number_format($total, 2) ?> บาท</strong></td>
    </tr>
</table>

<p><a href="member_order_list.php">← ย้อนกลับ</a></p>
