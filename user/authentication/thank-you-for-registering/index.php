<?php
require_once '..\..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isNotLoggedIn.php';
require_once ROOT_PATH.'components\header\guest.php';
?>


    <div>
        <div class="d-flex vh-100 py-3">
            <div class="container p-4 d-flex align-self-center justify-content-center" >
                <div class="row border rounded-4 shadow bg-white" style="max-height:600px;width:600px;">
                    <div class="col p-3 py-5 align-self-center">
                        <div class="row text-center mb-2">
                            <h3>
                                Thank you for registering
                            </h3>
                        </div>
                        <div class="row text-center my-2">
                            <a href="../../contacts/"  class="text-dark"><button class="btn btn-outline-secondary">Continue</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require_once ROOT_PATH.'components\footer\guest.php';
?>