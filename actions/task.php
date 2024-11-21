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
        $data = [
            'id' => $conn->insert_id,
            'title' => $title,
            'description' => $description,
            'status' => $status
        ];
        echo json_encode([ 'data' => $data, 'message' => 'Task created!', 'success' => true ]);
    } else {
        echo json_encode(['message' => "Error: " . mysqli_error($conn)]);
    }
}
?>