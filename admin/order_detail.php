<?php
include('../config/condb.php');
include('header.php');
include('navbar.php');
include('sidebar_menu.php');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// คำสั่ง SQL เพื่อดึงข้อมูลรายการสั่งซื้อ
$sql_order = "SELECT o.*, m.name, m.surname
              FROM tbl_order o
              INNER JOIN tbl_member m ON o.member_id = m.id
              WHERE o.order_id = :order_id";
$stmt = $condb->prepare($sql_order);
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// ดึงรายการสินค้าในคำสั่งซื้อ
$sql_items = "SELECT oi.*, p.p_name
              FROM tbl_order_item oi
              INNER JOIN tbl_product p ON oi.product_id = p.p_id
              WHERE oi.order_id = :order_id";
$stmt_items = $condb->prepare($sql_items);
$stmt_items->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt_items->execute();
$items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <h4>📄 รายละเอียดคำสั่งซื้อ #<?= $order['order_id']; ?></h4>
  <p><strong>ลูกค้า:</strong> <?= $order['name'] . ' ' . $order['surname']; ?></p>
  <p><strong>วันที่สั่ง:</strong> <?= $order['order_date']; ?></p>
  <p><strong>เวลารับ:</strong> <?= $order['pickup_time']; ?></p>
  <p><strong>สถานะ:</strong> <?= $order['status']; ?></p>

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>สินค้า</th>
        <th>จำนวน</th>
        <th>ราคา/หน่วย</th>
        <th>รวม</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($items as $item):
        $sum = $item['price'] * $item['qty'];
        $total += $sum;
      ?>
        <tr>
          <td><?= $item['p_name']; ?></td>
          <td><?= $item['qty']; ?></td>
          <td><?= number_format($item['price'], 2); ?></td>
          <td><?= number_format($sum, 2); ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td colspan="3" class="text-end"><strong>รวมทั้งหมด</strong></td>
        <td><strong><?= number_format($total, 2); ?> บาท</strong></td>
      </tr>
    </tbody>
  </table>

  <!-- ปุ่มอัปเดตสถานะ -->
  <form action="order_status_update.php" method="POST" class="mt-3">
    <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
    <label>อัปเดตสถานะ:</label>
    <select name="status" class="form-select w-25 d-inline">
      <option value="รอยืนยัน" <?= $order['status'] == 'รอยืนยัน' ? 'selected' : ''; ?>>รอยืนยัน</option>
      <option value="กำลังเตรียมสินค้า" <?= $order['status'] == 'กำลังเตรียมสินค้า' ? 'selected' : ''; ?>>กำลังเตรียมสินค้า</option>
      <option value="พร้อมรับ" <?= $order['status'] == 'พร้อมรับ' ? 'selected' : ''; ?>>พร้อมรับ</option>
      <option value="รับสินค้าแล้ว" <?= $order['status'] == 'รับสินค้าแล้ว' ? 'selected' : ''; ?>>รับสินค้าแล้ว</option>
    </select>
    <button type="submit" class="btn btn-sm btn-primary" name="update">อัปเดต</button>
  </form>

</div>

<?php include('footer.php'); ?>
