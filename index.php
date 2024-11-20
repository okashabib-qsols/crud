<?php
require './DB/conn.php';
$all_tasks = "
    SELECT id, title, description, status from tasks
";
$get_data = mysqli_query($conn, $all_tasks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CRUD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>

    <!-- Add Modal Button -->
    <div class="text-right mt-2 mx-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
        Add
        </button>
    </div>

    <!-- Form Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <form method="post" id="task-form">
            <input type="hidden" name="id" id="taskId">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="taskModalLabel">Add Task</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
                            <input type="text" class="form-control" id="title" aria-label="Sizing example input" name="title" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description"></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <label class="input-group-text" for="status">Status</label>
                            <select class="form-select" id="taskStatus" name="status">
                                <option selected disabled>Choose...</option>
                                <option value="Todo">Todo</option>
                                <option value="Doing">Doing</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- All Task -->
    <div class="row mx-3" id="allTasks">
        <?php
        if($get_data){
            while($row = $get_data->fetch_assoc()){
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $status = $row['status'];
        ?>

        <div class="card mt-2 mx-2" style="width: 18rem;">
            <input type="hidden" name="id" id="taskId">
            <div class="card-body">
                <h5 class="card-title"><?= $title; ?></h5>
                <p class="card-text"><?= $description; ?></p>
                <span class="badge rounded-pill text-bg-primary"><?= $status; ?></span>
                <hr>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <button class="btn btn-primary me-md-2 btn-sm badge rounded-pill editTask" type="button" data-card-id="<?php echo $id; ?>">Edit</button>
                    <button class="btn btn-danger btn-sm badge rounded-pill deleteTask" type="button" data-card-id="<?php echo $id; ?>">Delete</button>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "no data found!";
        }
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./app.js"></script>
</body>
</html>