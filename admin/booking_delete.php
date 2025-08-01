<?php
include('../config/condb.php'); // ต้องมีการเชื่อมต่อฐานข้อมูลด้วย

if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == 'delete')
{
    try {
        $id = $_GET['id'];

        // ดึงชื่อไฟล์ภาพจากฐานข้อมูล
        $stmtProductDetail = $condb->prepare("SELECT room_image FROM tbl_room WHERE room_id = ?");
        $stmtProductDetail->execute([$id]);
        $row = $stmtProductDetail->fetch(PDO::FETCH_ASSOC);

        if ($stmtProductDetail->rowCount() == 0) {
            echo '<script>
                setTimeout(function() {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        type: "error"
                    }, function() {
                        window.location = "booking_list.php";
                    });
                }, 1000);
            </script>';
        } else {
            // ลบข้อมูลห้อง
            $stmtDelProduct = $condb->prepare('DELETE FROM tbl_room WHERE room_id = :id');
            $stmtDelProduct->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDelProduct->execute();

            // ลบภาพ (หากไฟล์มีอยู่)
            if (!empty($row['room_image']) && file_exists("../assets/room/" . $row['room_image'])) {
                unlink('../assets/room/' . $row['room_image']);
            }

            if ($stmtDelProduct->rowCount() == 1) {
                echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "ลบข้อมูลสำเร็จ",
                            type: "success"
                        }, function() {
                            location.href = "booking_list.php";

                        });
                    }, 1000);
                </script>';
                exit();
            }
        }
    } catch (Exception $e) {
        echo '<script>
            setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: "' . $e->getMessage() . '",
                    type: "error"
                }, function() {
                   location.href = "booking_list.php";

                });
            }, 1000);
        </script>';
    }
}
?>
