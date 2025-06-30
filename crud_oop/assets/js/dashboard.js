let updatedItemID;
/***************************** HANDLE addItem **********************/
$(document).ready(function (){
    loadItems();
$("#addItemForm").on("submit",function (e){
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action','add');

    $.ajax({
        url: "../controllers/itemController.php",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if(response.status === 'success')
            {
                Swal.fire({
                    title:"success",
                    text:"Item Added Successfully",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then((result)=> {
                    if(result.isConfirmed)
                    {
                        $("#addItemForm")[0].reset();
                        loadItems();
                    }
                });
            }
            else
            {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to Add item",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function (xhr,status,error){
            Swal.fire({
                title: "Error",
                text: "An Error occured while processing",
                icon: "error",
                confirmButtonText: "OK"
            });
            console.log("AJAX error",status,error);
        }
    })
})
});

/***************************** HANDLE LOGOUT **********************/

$("#logoutButton").on("click", function() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to log out?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, log out',
        cancelButtonText: 'No, stay'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'logout.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Logged out successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'login.php';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || 'Failed to log out.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during logout.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error('AJAX error:', status, error);
                }
            });
        }
    });
});

/***************************** HANDLE Edit btn **********************/
$(document).on("click",'.btn-edit',function (e){
    updatedItemID = $(this).data("id");
    const itemTitle = $(this).data("title");
    const itemDescription = $(this).data("description");
    $('.add-item').addClass('d-none');
    $('.edit-item').removeClass('d-none');

    $('#edit-title').val(itemTitle);
    $('#edit-description').val(itemDescription);

})

$(document).on("submit",'#updateItemForm',function (e){
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('id',`${updatedItemID}`);
    formData.append('action','edit');

    $.ajax({
        url: '../controllers/itemController.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (result){
            if(result.status === 'success')
            {
                Swal.fire({
                    title: 'Success',
                    text: 'updated successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('.add-item').removeClass('d-none');
                    $('.edit-item').addClass('d-none');
                    loadItems();
                });
            }
            else
            {
                Swal.fire({
                    title: 'error',
                    text: 'updated failed || ' + result.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred during updating',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            console.error('AJAX error:', status, error);
        }
    });
});

/***************************** HANDLE Delete btn **********************/

$(document).on("click",'.btn-delete',function (){
    const itemId = $(this).data("id");
    Swal.fire({
        title: `Are You Sure`,
        text: "This Action cannot be undo",
        icon: "warning",
        showCancelButton: "Yes, Delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
       if(result.isConfirmed){
           $.ajax({
               url: '../controllers/itemController.php',
               method: 'POST',
               data: {
                   action: 'delete',
                   id: itemId
               },
               dataType: 'json',
               success: function (response){
                   if (response.status === 'success')
                   {
                       Swal.fire("Deleted!",response.message,"success");
                       loadItems();
                   }else
                   {
                       Swal.fire("Error!",response.message,"error");
                   }
               },
               error: function (){
                   Swal.fire("error","Failed to delete item.","error");
               }
           })
       }
    });

});


/***************************** Loaditems function **********************/

function loadItems() {
    $("#itemsTable").empty();
    $.ajax({
        url: '../controllers/itemController.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            $("#itemsTable").empty();
            if (response.status === 'success' && response.data.length > 0) {
                let html = '';
                response.data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.title}</td>
                            <td>${item.description}</td>
                            <td>${item.created_at}</td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">Delete</button>
                                <button class="btn btn-sm btn-warning btn-edit" data-title="${item.title}" data-description="${item.description}" data-id="${item.id}">Edit</button>
                            </td>
                        </tr>`;
                });
                $("#itemsTable").html(html);
            } else {
                $('#itemsTable').html('<tr><td colspan="4" class="text-center">No items found</td></tr>');
            }
        },
        error: function () {
            $('#itemsTable').html('<tr><td colspan="4" class="text-center text-danger">Error loading items</td></tr>');
        }
    });
}

