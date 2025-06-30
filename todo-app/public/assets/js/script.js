$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function (){
        //for create new todo
        const dataTable = $('#data-table').DataTable();

    $('#createTodoBtn').click(function (){
        $("#todo-form")[0].reset();
        $("#todo-form input, #todo-form textarea").removeAttr("disabled");
        $("#todo-form button[type=submit]").removeClass("d-none").text("Save");
        $(".modal-title").text("Create Todo");
        $("#todo-form").attr("action", `${baseUrl}/todos`);
        $("#hidden-todo-id").val();
        $("#todo-modal").modal("toggle");
    });
    $('#todo-form').validate({
       rules: {
           title: {
               required:true,
               minlength: 3,
               maxlength: 20
           },
           description: {
               required: true,
               minlength: 10,
               maxlength: 255,
           }
       },
        messages: {
           title: {
               required: "Title field is required",
               minlength:"min length 3",
               maxlength:"max length 20"
           },
            description: {
               required: "Description field is required",
                minlength: "min length 10",
                maxlength: "max Length 50"
            }
        },
        submitHandler: function (form){
           const dataForm = $(form).serializeArray();
           const todoId = $("#hidden-todo-id").val();
           const methodType = todoId ? "PUT" : "POST";
           const formAction = $(form).attr("action");

           $.ajax({
              url: formAction,
              type: methodType,
              data: dataForm,
               success: function (response){
                    if (response.status === 'success')
                    {
                        Swal.fire({
                            icon:"success",
                            title:response.status,
                            text:response.message,
                        });
                        $("#todo-modal").modal("hide");
                        if(todoId){
                            $(`#todo_row_${response.todo.id} td:nth-child(2)`).html(response.todo.title);
                            $(`#todo_row_${response.todo.id} td:nth-child(3)`).html(response.todo.description);
                        }
                        else
                        {

                            const newTodoRow =
                                `<tr id="todo_row_${response.todo.id}">
                                <td>${response.todo.id}</td>
                                <td>${response.todo.title}</td>
                                <td>${response.todo.description}</td>
                                <td>${response.todo.is_completed ? 'Yes' : 'No'}</td>
                                <td>
                                    <a class="btn btn-info" href="javascript:void(0)" data-id="${response.todo.id}">View</a>
                                    <a class="btn btn-success" href="javascript:void(0)" data-id="${response.todo.id}">Edit</a>
                                    <a class="btn btn-danger" href="javascript:void(0)" data-id="${response.todo.id}">Delete</a>
                                </td>
                            </tr>`;
                            dataTable.row.add($(newTodoRow)).draw(false);
                        }
                    }
                    else
                    {
                        Swal.fire({
                            icon:"error",
                            title:error.status || "Error",
                            text:error.message || "something went wrong",
                        });
                    }
                },
               error: function (error){
                   Swal.fire({
                       icon:"error",
                       title:error.status + "something went wrong ",
                       text:error.message,
                   });
              }
           });
           return false;
        }
    });

    //for view Todo
    $('.view-btn').click(function (){
        const btnId = $(this).data("id");
        fetchTodo(btnId,"view");
    })

    //for updating todo
    $(".edit-btn").click(function (){
        const btnId = $(this).data("id");
        fetchTodo(btnId,"edit")
    });

    function fetchTodo(btnId, mode= null)
    {
        if(btnId)
        {
            $.ajax({
                url: `todos/${btnId}`,
                type: 'GET',
                success: function (response){
                    const todo = response.todo;
                    if(response.status === 'success')
                    {
                        $("#todo-modal #title").val(todo.title);
                        $("#todo-modal #description").val(todo.description);

                        if(mode === "view")
                        {
                            $("#todo-form input, #todo-form textarea").attr("disabled",true);
                            $("#todo-form button[type=submit]").addClass("d-none");
                            $(".modal-title").text("Todo Detail");
                            $("#todo-form").removeAttr("action");
                        }
                        else if(mode === "edit")
                        {
                            $("#todo-form input, #todo-form textarea").removeAttr("disabled");
                            $(".btn-save").removeClass("d-none");
                            $(".modal-title").text("Update Todo");
                            $(".btn-save").text("Update");
                            $("#todo-form").attr("action",`${baseUrl}/todos/${todo.id}`);
                            $("#hidden-todo-id").val(`${todo.id}`);
                        }

                        $("#todo-modal").modal("toggle");
                    }
                },
            })
        }
    }

    //for delete todo

    $("#data-table").on('click','.delete-btn',function (){
        const todoId = $(this).data("id");
        if(todoId)
        {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete",
            }).then((result)=>{
               if(result.isConfirmed){
                   $.ajax({
                      url:`todos/${todoId}`,
                      type:"DELETE",
                      success: function (response){
                          if (response.status === 'success')
                          {
                              Swal.fire({
                                  title: "Deleted!",
                                  text: "Todo has been deleted.",
                                  icon: "success",
                                  timer: 1500,
                              });
                              if(response.todo)
                              {
                                  $(`#todo_row_${response.todo.id}`).remove();
                              }

                          }else
                          {
                              Swal.fire({
                                  title: "Failed!",
                                  text: "Unable to delete!",
                                  icon: "error",
                                  timer: 1500,
                              });
                          }
                      },
                       error:function (){
                           Swal.fire({
                               title: "Failed!",
                               text: "Unable to delete Todo!",
                               icon: "error",
                           });
                       }
                   });
               }
            });
        }
    })

    $('#data-table').on('change','.toggle-completed',function (){
        const todoId = $(this).data('id');
        $.ajax({
            url:`${baseUrl}/todos/${todoId}/toggle-completed`,
            type:'PATCH',
            success: function (response){
              if(response.status === 'success')
              {
                  Swal.fire({
                     icon:'success',
                      title:"updated",
                      text:'todo completed',
                      timer: 1000,
                      showConfirmation: false,
                  });
              } else{
                  Swal.fire({
                      icon:'error',
                      title:"Error",
                      text:'Failed to updated',
                  });
              }
            },
            error: function (){
                Swal.fire({
                    icon:"error",
                    title:"Error",
                    text:"Failed"
                });
            }
        })
    });

});
