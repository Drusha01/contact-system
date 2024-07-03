<?php
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isLoggedIn.php';
require_once ROOT_PATH.'components\header\guest.php';
?>


    <div>
        <div class="d-flex vh-100 py-3">
            <div class="container p-4 d-flex align-self-center justify-content-center" >
                <div class="row border rounded-4 shadow bg-white" style="max-height:600px;width:600px;">
                    <div class="col p-3 py-5 align-self-center">
                        <div class="row">
                            <h3>
                                Sign up
                            </h3>
                        </div>
                        <div class="row">
                            <form id="signUpForm">
                                <div class="mb-1">
                                    <label for="username" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="username"  placeholder="Enter name" name="username" required>
                                </div>
                                <div class="mb-1">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email"  placeholder="Enter email" name="email" required>
                                </div>
                                <div class="mb-1">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" id="password"  placeholder="Enter passowrd" name="password" required>
                                </div>
                                <div class="mb-1">
                                    <label for="confirmpassword" class="form-label">Confirm password</label>
                                    <input class="form-control" type="password" id="confirmpassword"  placeholder="Enter confirm password" name="confirmpassword" required>
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button type="submit" id="submitbutton" class="btn btn-block btn-primary ">Sign up</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <p class="text-reset mt-2">have an account? <a href="../login/"  class="text-dark">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( "#signUpForm" ).on( "submit", function( event ) {
            event.preventDefault();
            $.ajax({
                url: 'signup',
                type: 'post',
                dataType: 'json',
                data: $('form#signUpForm').serialize(),
                success: function(data) {
                    if(data == 1){
                        window.location.href = '/user/authentication/thank-you-for-registering';
                    }else{
                        alert(data);
                    }
                }
            });
        });
    </script>
   
<?php
require_once ROOT_PATH.'components\footer\guest.php';
?>