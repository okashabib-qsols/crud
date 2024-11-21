<?php
require '../DB/conn.php';

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$status = $_POST['status'];

$check_id = "SELECT id FROM tasks WHERE id='$id'";
$exist_id = mysqli_query($conn, $check_id);
if(mysqli_num_rows($exist_id) > 0){
    $query = "UPDATE tasks SET `title`='$title', `description`='$description', `status`='$status' WHERE `id`='$id'";
    $update = $conn->query($query);
    if($update){
        $data = [
            'title' => $title,
            'description' => $description,
            'status' => $status
        ];
        echo json_encode([ 'data' => $data, 'message'=>'Task Updated!', 'success' => true]);
    } else {
        echo json_encode(['message' => "Error: " . mysqli_error($conn)]);
    }
}else{
    echo json_encode(['message' => 'No data with the given id']);
}
?>