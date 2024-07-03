<?php
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isLoggedIn.php';
require_once ROOT_PATH.'components\header\guest.php';
?>
    <div>
        <div class="d-flex vh-100 py-3">
            <div class="container p-4 d-flex align-self-center justify-content-center" >
                <div class="row border rounded-4 shadow bg-white" style="max-height:500px;width:600px;">
                    <div class="col p-3 py-5 align-self-center">
                        <div class="row">
                            <h3>
                                Sign in
                            </h3>
                        </div>
                        <div class="row">
                            <form id="signUpForm">
                                <div class="mb-1">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="text" id="email"  placeholder="Enter name" name="email">
                                </div>
                                <div class="mb-1">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" id="password"  placeholder="Enter password" name="password">
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button type="submit" class="btn btn-block btn-primary ">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <p class="text-reset mt-2">Don't have an account? <a href="../signup/"  class="text-dark">Sign up</a></p>
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
                url: 'login',
                type: 'post',
                dataType: 'json',
                data: $('form#signUpForm').serialize(),
                success: function(data) {
                    if(data == '1'){
                        window.location.href = '/user/contact/';
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