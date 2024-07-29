<?php
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isNotLoggedIn.php';
require_once ROOT_PATH.'components\header\user.php';
require_once ROOT_PATH.'components\top-header\user-top-header.php';
?>

    <div class="container-fluid">
        <h4 class=" my-3">Add Contact</h4>

        <div class="row d-flex justify-content-center">
            <div class="d-flex justify-content-center"  >
                <form id="contactForm" style="width:600px" >
                    <div class="body">
                        <div class=" m-3 mb-3 ">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class=" m-3 mb-3 ">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company">
                        </div>
                        <div class=" m-3 mb-3 ">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class=" m-3 mb-3 ">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email"  name="email">
                        </div>
                    </div>
                    <div class="footer ">
                        <div class="m-3 mb-3 d-flex justify-content-center">
                            <button type="submit" id="submitForm" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
       
    </div>
    <script>
        $( "#contactForm" ).on( "submit", function( event ) {
            event.preventDefault();
            $.ajax({
                url: 'add',
                type: 'post',
                dataType: 'json',
                data: $('form#contactForm').serialize(),
                success: function(result) {
                    var dalay = 1500;
                    if(result.response == 1){
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: 'Successfully added',
                            showConfirmButton: false,
                            timer: dalay
                        });
                        setTimeout(function() {
                            window.location.href = '/user/contacts';
                        }, dalay);
                     
                    }else{
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: result.response,
                            showConfirmButton: false,
                            timer: dalay
                        });
                    }
                },error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
        });
    </script>
<?php
require_once ROOT_PATH.'components\footer\user.php';
?>