<?php
require '../DB/conn.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);
$check_id = "SELECT id FROM tasks WHERE id = $id";
$delete = mysqli_query($conn, $check_id);
if(mysqli_num_rows($delete) > 0){
    $task = "DELETE from tasks WHERE id=$id";
    $delete = mysqli_query($conn, $task);
    echo json_encode(['message'=>'Deleted Successfully', 'success' => true]);
}else if ($delete != $id){
    echo json_encode(['message'=>'Id not Found', 'success' => false]);
}
?>