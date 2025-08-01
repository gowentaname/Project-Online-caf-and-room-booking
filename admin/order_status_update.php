<?php
require_once('../config/condb.php');

if (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    try {
        if (!empty($order_id) && !empty($status)) {
           $stmt = $condb->prepare("UPDATE tbl_order SET status = ? WHERE order_id = ?");
            $result = $stmt->execute([$status, $order_id]);

            if ($result) {
                echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "อัปเดตสถานะสำเร็จ",
                            icon: "success"
                        }).then(function() {
                            window.location = "order_list.php";
                        });
                    }, 500);
                </script>';
                exit;
            } else {
                throw new Exception("ไม่มีการอัปเดตข้อมูล");
            }
        } else {
            throw new Exception("ข้อมูลไม่ครบ");
        }

    } catch (Exception $e) {
        echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
        echo '<script>
            setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: "' . $e->getMessage() . '",
                    icon: "error"
                }).then(function() {
                    window.location = "order_list.php";
                });
            }, 500);
        </script>';
    }
} else {
    // fallback เผื่อโดนเข้าตรง ๆ
    header("Location: order_list.php");
    exit;
}
?>
