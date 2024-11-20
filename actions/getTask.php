<?php
require '../DB/conn.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $check_id = "SELECT id from tasks WHERE id='$id'";
    $exist_id = mysqli_query($conn, $check_id);
    if(mysqli_num_rows($exist_id) > 0){
        $query = "SELECT id, title, description, status FROM tasks WHERE id=$id";
        $data = mysqli_query($conn, $query);
        $result = $data->fetch_assoc();
        echo json_encode($result);
    }else{
        echo json_encode(['message' => 'No data with the given id', 'success' => false]);
    }
}
?>