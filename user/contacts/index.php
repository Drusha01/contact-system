<?php
require_once '..\..\assets\contants\contants.php';
require_once ROOT_PATH.'middleware\isNotLoggedIn.php';
require_once ROOT_PATH.'components\header\user.php';
require_once ROOT_PATH.'components\top-header\user-top-header.php';
?>

    <div class="container-fluid">
        <h4 class=" my-3">Contacts</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Company
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>asdfa</td>
                    </tr>
                    <tr>
                        <td>asdfa</td>
                    </tr>
                    <tr>
                        <td>asdfa</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 d-flex justify-content-center">
                <a href="">
                    <button class="btn btn-secondary mx-1">1</button>
                </a>
                <a href="">
                    <button class="btn btn-outline-secondary mx-1">2</button>
                </a>
                <a href="">
                    <button class="btn btn-outline-secondary mx-1">3</button>
                </a>
                <a href="">
                    <button class="btn btn-outline-secondary mx-1">Next</button>
                </a>
            </div>
        </div>
    </div>


<?php
require_once ROOT_PATH.'components\footer\user.php';
?>