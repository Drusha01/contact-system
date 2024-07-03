<?php
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isNotLoggedIn.php';
require_once ROOT_PATH.'components\header\user.php';
require_once ROOT_PATH.'components\top-header\user-top-header.php';
?>

    <div class="container-fluid">
        <h4 class=" my-3">Contacts</h4>

        <div class="row d-flex justify-content-center">
            <div class="d-flex justify-content-center"  >
                <form action="" class="border m-2"style="width:600px" >
                    <div class="body">
                        <div class=" m-3 mb-3 ">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
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
<?php
require_once ROOT_PATH.'components\footer\user.php';
?>