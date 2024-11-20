<?php
require '../DB/conn.php';
$id = $_GET['id'];
$task = "
    DELETE from tasks WHERE id=$id
";
$delete = mysqli_query($conn, $task);
if($delete){
    echo json_encode(['message'=>'Task deleted Successfully', 'success' => true]);
}else{
    echo json_encode(['message' => 'Something went wrong', 'success' => false]);
}
?>