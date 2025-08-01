<?php
session_start();
require_once('../config/condb.php');

if (!isset($_SESSION['member_id'])) {
    echo "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    exit;
}

$member_id = $_SESSION['member_id'];

// ดึงรายการในตะกร้าของผู้ใช้
$sql = "SELECT c.*, p.product_name, p.product_price, p.product_image
        FROM tbl_cart AS c
        JOIN tbl_product AS p ON c.product_id = p.id
        WHERE c.member_id = :member_id";
$stmt = $condb->prepare($sql);
$stmt->execute(['member_id' => $member_id]);
$cart_items = $stmt->fetchAll();
?>

<h2>ตะกร้าสินค้าของคุณ</h2>

<form action="checkout.php" method="post">
<table border="1" cellpadding="10" width="100%">
    <tr style="background:#f0f0f0;">
        <th>สินค้า</th>
        <th>ราคา</th>
        <th>จำนวน</th>
        <th>รวม</th>
        <th>ลบ</th>
    </tr>
    <?php
    $total = 0;
    foreach ($cart_items as $item):
        $sum = $item['product_price'] * $item['qty'];
        $total += $sum;
    ?>
    <tr>
        <td>
            <img src="../assets/product_img/<?= $item['product_image'] ?>" width="50">
            <?= $item['product_name'] ?>
        </td>
        <td><?= number_format($item['product_price'], 2) ?></td>
        <td><?= $item['qty'] ?></td>
        <td><?= number_format($sum, 2) ?></td>
        <td><a href="cart_delete.php?cart_id=<?= $item['cart_id'] ?>" onclick="return confirm('ลบใช่ไหม?')">ลบ</a></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" align="right"><strong>รวมทั้งหมด:</strong></td>
        <td colspan="2"><strong><?= number_format($total, 2) ?> บาท</strong></td>
    </tr>
</table>

<br>
<a href="product_index.php"><< เลือกสินค้าเพิ่ม</a> |
<button type="submit">สั่งซื้อสินค้า</button>
</form>
