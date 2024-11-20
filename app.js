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
                        $("#allTasks").load(location.href + ' #allTasks')
                    }
                },
                error: function (err){
                    console.log(err, "Error");
                }
            });
        }

        if(taskId){
            $.ajax({
                method: 'PUT',
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
                        $("#allTasks").load(location.href + ' #allTasks');
                    } else {
                        console.log(response.message);
                    }
                }
            })
        }
    });

    // GET SINGLE
    $('.editTask').click(function (e) { 
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
    $('.deleteTask').on('click', function() {
        let taskId = $(this).data('card-id');
        
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
                    $("#allTasks").load(location.href + ' #allTasks')
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