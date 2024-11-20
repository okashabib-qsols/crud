<?php
require '../DB/conn.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT id, title, description, status FROM tasks WHERE id=$id";
    $data = mysqli_query($conn, $query);
    $result = $data->fetch_assoc();
    echo json_encode($result);
}
?>