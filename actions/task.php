<?php
require '../DB/conn.php';
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$status = $_POST['status'];

if(empty($id)){
    if (trim($title) == "" || trim($description) == "" || trim($status) == "") {
        echo json_encode(['message' => "All fields required", 'success' => false]);
        return;
    }
    $query = "INSERT INTO tasks (title, description, status) VALUES ('$title', '$description', '$status')";
    $insert = $conn->query($query);
    if($insert){
        echo json_encode(['message'=>'Task created!', 'success' => true]);
    }
}else {
    $query = "UPDATE tasks SET `title`='$title', `description`='$description', `status`='$status' WHERE `id`='$id'";
    $update = $conn->query($query);
    if($update){
        echo json_encode(['message'=>'Task Updated!', 'success' => true]);
    }
}
?>