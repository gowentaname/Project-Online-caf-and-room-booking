<?php
include('../config/condb.php');
include('header.php');
include('navbar.php');
include('sidebar_menu.php');

//  ดึงข้อมูลคำสั่งซื้อพร้อมยอดรวม
$sql = "SELECT o.*, m.name, m.surname,
               COALESCE(SUM(oi.qty * oi.price), 0) AS total_price
        FROM tbl_order AS o
        INNER JOIN tbl_member AS m ON o.member_id = m.id
        LEFT JOIN tbl_order_item AS oi ON o.order_id = oi.order_id
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";

$stmt = $condb->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <h3>จัดการข้อมูลห้องพัก</h3>
  <?php $i = 1; ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>ชื่อผู้ใช้</th>
        <th>วันเวลาที่สั่งซื้อ</th>
        <th>ชื่อสินค้า</th>
        <th>จำนวน</th>
        <th>จำนวนเงิน</th>
        <th>สลิป</th>
        <th>สถานะ</th>
        <th>อัปเดต</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
        <?php
        //  ดึงรายการสินค้าในแต่ละออเดอร์
        $stmt_items = $condb->prepare("SELECT oi.*, p.product_name
                                       FROM tbl_order_item oi
                                       LEFT JOIN tbl_product p ON oi.product_id = p.id
                                       WHERE oi.order_id = :order_id");
        $stmt_items->execute([':order_id' => $order['order_id']]);
        $items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <tr>
          <td><?= $i++; ?></td>
          <td><?= htmlspecialchars($order['name'] . ' ' . $order['surname']); ?></td>
          <td><?= date('Y-m-d H:i', strtotime($order['order_date'])); ?></td>
          <td>
            <?php foreach ($items as $item): ?>
              <?= htmlspecialchars($item['product_name']); ?><br>
            <?php endforeach; ?>
          </td>
          <td>
            <?php foreach ($items as $item): ?>
              <?= (int)$item['qty']; ?> ชิ้น<br>
            <?php endforeach; ?>
          </td>
          <td><?= number_format($order['total_price'], 2); ?> บาท</td>
          <td>
            <?php if (!empty($order['slip_image'])): ?>
              <a href="../assets/slips/<?= htmlspecialchars($order['slip_image']); ?>" target="_blank">
                <img src="../assets/slips/<?= htmlspecialchars($order['slip_image']); ?>" width="50">
              </a>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td>
  <form method="post" action="order_status_update.php">
    <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
    <select name="status" class="form-control" required>
      <option value="รอดำเนินการ" <?= $order['status'] == 'รอดำเนินการ' ? 'selected' : ''; ?>>รอดำเนินการ</option>
      <option value="กำลังทำ" <?= $order['status'] == 'กำลังทำ' ? 'selected' : ''; ?>>กำลังทำ</option>
      <option value="เสร็จสิ้น" <?= $order['status'] == 'เสร็จสิ้น' ? 'selected' : ''; ?>>เสร็จสิ้น</option>
      <option value="ยกเลิก" <?= $order['status'] == 'ยกเลิก' ? 'selected' : ''; ?>>ยกเลิก</option>
    </select>
</td>
<td>
    <button type="submit" class="btn btn-sm btn-primary" name="update">อัปเดต</button>
  </form>
</td>


        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include('footer.php'); ?>