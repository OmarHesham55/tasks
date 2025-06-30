$(document).ready(function (){
    const form = document.getElementById('registerForm');
    form.addEventListener('submit',function (e){
        e.preventDefault();
        const formData = new FormData(form);

        $.ajax({
            url: '../controllers/registerController.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response){
                if (response.status === 'success')
                {
                    Swal.fire({
                        title:"success",
                        text:"Registeration Completed Successfully",
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then((result)=> {
                        if (result.isConfirmed)
                        {
                            $("#registerForm")[0].reset();
                            window.location.href = 'login.php';
                        }
                });
                }else
                {
                    Swal.fire({
                       title: "Error!",
                       text: "Register failed",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function (xhr,status,error){
                Swal.fire({
                    title: "Error",
                    text: "An Error occured while processing",
                    icon: "Error",
                    confirmButtonText: "OK"
                });
                console.log("AJAX error",status,error);
            }
        });
    });
});