$(document).ready(function(){
    console.log("Hello DOM")

    $('#task-form').submit(function (e) { 
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: "./actions/task.php",
            data: formData,
            success: function (response) {
                let res = JSON.parse(response)
                if(res.success){
                    Toastify({
                        text: res.message,
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
    });

    $('.editTask').click(function (e) { 
        e.preventDefault();
        let taskId = $(this).data('card-id')
        console.log(taskId)
        $.ajax({
            method: 'GET',
            url: './actions/getTask.php',
            data: { id: taskId },
            success: function(response){
                let res = JSON.parse(response);
                console.log(res)
                $('#taskId').val(res.id)
                $('#title').val(res.title)
                $('#description').val(res.description)
                $('#taskStatus').val(res.status)
                
                $('.modal-title').text("Edit Task")
                $('#taskModal').modal('show')
            }
        })
    });

    $('.deleteTask').on('click', function() {
        let taskId = $(this).data('card-id');
        
        $.ajax({
            method: 'GET',
            url: './actions/delete.php',
            data: { id: taskId },
            success: function(response){
                let res = JSON.parse(response)
                if(res.success){
                    Toastify({
                        text: res.message,
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