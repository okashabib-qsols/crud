$(document).ready(function(){

    $('#task-form').submit(function (e) { 
        e.preventDefault();
        let formData = $(this).serialize();
        let taskId = $('#taskId').val();

        if(!taskId){            
            $.ajax({
                method: 'POST',
                url: "./actions/task.php",
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if(response.success){
                        Toastify({
                            text: response.message,
                            duration: 3000,
                            stopOnFocus: true,
                            position: "center",
                            style: {
                                borderRadius: "10px",
                            },
                            offset: {
                                y: 50
                            },
                        }).showToast()
                        $('#taskModal').modal('hide')
                        $('.modal-backdrop').remove();
                        $("#allTasks").append(
                            `
                                <div class="card mt-2 mx-2" style="width: 18rem;">
                                    <input type="hidden" name="id" id="taskId">
                                    <div class="card-body">
                                        <h5 class="card-title">${response.data.title}</h5>
                                        <p class="card-text">${response.data.description}</p>
                                        <span class="badge rounded-pill text-bg-primary">${response.data.status}</span>
                                        <hr>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                            <button class="btn btn-primary me-md-2 btn-sm badge rounded-pill editTask" type="button" data-card-id=${response.data.id}>Edit</button>
                                            <button class="btn btn-danger btn-sm badge rounded-pill deleteTask" title="Double click to delete" type="button" data-card-id=${response.data.id}>Delete</button>
                                        </div>
                                    </div>
                                </div>
                            `
                        )
                    }
                },
                error: function (err){
                    console.log(err, "Error");
                }
            });
        }

        if(taskId){
            let card = $(".card").filter(function() {
                return $(this).find('.editTask').data('card-id') == taskId;
            });
            $.ajax({
                method: 'POST',
                url: './actions/update.php?id='+taskId,
                data: formData,
                dataType: 'json',
                success: function(response){
                    if (response.success) {
                        Toastify({
                            text: response.message,
                            duration: 3000,
                            stopOnFocus: true,
                            position: "center",
                            style: {
                                borderRadius: "10px",
                            },
                            offset: {
                                y: 50
                            },
                        }).showToast();
                        $('#taskModal').modal('hide');
                        $('.modal-backdrop').remove();

                        card.find('.card-title').text(response.data.title);
                        card.find('.card-text').text(response.data.description);
                        card.find('.badge-status').text(response.data.status);
                    } else {
                        console.log(response.message);
                    }
                }
            })
        }
    });

    // GET SINGLE
    $('#allTasks').on('click', '.editTask', function (e) { 
        e.preventDefault();
        let taskId = $(this).data('card-id')
        $.ajax({
            method: 'GET',
            url: './actions/getTask.php',
            data: { id: taskId },
            dataType: 'json',
            success: function(response){
                $('#taskId').val(response.id)
                $('#title').val(response.title)
                $('#description').val(response.description)
                $('#taskStatus').val(response.status)
                $('.modal-title').text("Edit Task")
                $('#taskModal').modal('show')
            }
        })
    });

    // DELETE
    $('#allTasks').on('dblclick', '.deleteTask', function() {
        let taskId = $(this).data('card-id');
        let card = $(this).closest('.card')
        $.ajax({
            method: 'DELETE',
            url: './actions/delete.php?id='+taskId,
            dataType: 'json',
            success: function(response){
                if(response.success){
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        stopOnFocus: true,
                        position: "center",
                        style: {
                            borderRadius: "10px",
                        },
                        offset: {
                            y: 50
                        },
                    }).showToast();
                    card.remove()
                }
            }
        })
    })

    $('#taskModal').on('hidden.bs.modal', function(){
        $('#task-form')[0].reset()
        $('#taskId').val('')
        $('.modal-title').text("Add task")
    })
})