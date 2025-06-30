$(document).ready(function (){

$("#loginForm").on("submit",function (e){
    e.preventDefault();
    const formData = new FormData(this)

    $.ajax({
        url:"../controllers/loginController.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function (response){
            if (response.status === 'success')
            {
                Swal.fire({
                    title:"success",
                    text:"Login",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then((result)=> {
                    if(result.isConfirmed)
                    {
                        window.location.href = "dashboard.php";
                    }
                });
            }
            else
            {
                Swal.fire({
                    title: "Error!",
                    text: "Login failed.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function (xhr,status,error)
        {
            Swal.fire({
                title: "Error",
                text: "An Error occured while processing",
                icon: "error",
                confirmButtonText: "OK"
            });
            console.log("AJAX error",status,error);
        }
    });


})




















});