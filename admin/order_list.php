<?php
include('../config/condb.php');
include('header.php');
include('navbar.php');
include('sidebar_menu.php');

// ดึงข้อมูลคำสั่งซื้อ
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
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการคำสั่งซื้อ</h1>      
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
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
       <th width="2%" class="text-center">No.</th>
        <th width="15%">ชื่อผู้ใช้</th>
        <th width="10%">วันเวลาที่สั่งซื้อ</th>
        <th width="10%">ชื่อสินค้า</th>
        <th width="10%">ประเภทสินค้า</th>
        <th width="5%"  class="text-center">จำนวน</th>
        <th width="10%"  class="text-center">จำนวนเงิน</th>
        <th width="5%">สลิป</th>
        <th width="10%">รายละเอียดเพิ่มเติม</th>
        <th width="10%" class="text-center">สถานะ</th>
        <th width="5%" class="text-center">อัปเดต</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($orders as $order): ?>
        <?php
        $stmt_items = $condb->prepare("SELECT oi.*, p.product_name, t.type_name
                                       FROM tbl_order_item oi
                                       LEFT JOIN tbl_product p ON oi.product_id = p.id
                                       LEFT JOIN tbl_type t ON p.ref_type_id = t.type_id
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
              <?= htmlspecialchars($item['type_name']); ?><br>
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
          <td><?= !empty($order['note']) ? nl2br(htmlspecialchars($order['note'])) : '-'; ?></td>
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


<?php include('footer.php'); ?>
