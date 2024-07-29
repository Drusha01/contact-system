<?php
    require_once '..\..\assets\contants\contants.php';
    require_once ROOT_PATH.'middleware\isNotLoggedIn.php';
    require_once ROOT_PATH.'components\header\user.php';
    require_once ROOT_PATH.'components\top-header\user-top-header.php';

    include_once ROOT_PATH.'assets\database\database.php';
    $db = new Database();
    $contact = [
        'id' => NULL,
        'user_id' => $_SESSION['user_id'],
        'name' => NULL,
        'company' => NULL,
        'phone' => NULL,
        'email' => NULL,
    ];

    try{
        $sql = "SELECT id,user_id,name,company,phone,email,is_active,date_created,date_updated FROM contacts
            WHERE user_id = :user_id";
        $query=$db->connect()->prepare($sql);
        $query->bindParam(':user_id', $contact['user_id']);
        if($query->execute()){
            $table_data = $query->fetchAll();
        }
    }catch (PDOException $e){
        return false;
    }
?>

    <div class="container-fluid">
        <h4 class=" my-3">Contacts</h4>
        <div class="row d-flex justify-content-end">
            <div class="col-3 my-2">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search ... ">
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                #
                            </th>
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
                            <th class="text-center align-middle">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($table_data as $key => $value) {
                                echo '<tr>';
                                echo '<td>'.($key+1).'</td>';
                                echo '<td>'.$value['name'].'</td>';
                                echo '<td>'.$value['company'].'</td>';
                                echo '<td>'.$value['phone'].'</td>';
                                echo '<td>'.$value['email'].'</td>';
                                echo '
                                    <td class="text-center align-middle">
                                        <button class="btn btn-danger"  onclick="setDelete('.$value['id'].')" >Delete</button>
                                        <a class="btn btn-success" id="deleteItem" href="/user/contacts/edit/?id='.$value['id'].'">Edit</a>
                                    </td>';
                                echo '</tr>';
                            }
                        ?>
                       
                    </tbody>
                </table>
            </div>
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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="contactDeleteForm">
                    <div class="modal-body">
                        <input type="number" id="delete_id" name="id" value="" class="d-none">
                        <div>Are you sure you want to delete this?</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setDelete(id) {
            $('#delete_id').val(id)
            $('#deleteModal').modal('toggle');
        }
        $( "#contactDeleteForm" ).on( "submit", function( event ) {
            event.preventDefault();
            $.ajax({
                url: 'delete/delete',
                type: 'post',
                dataType: 'json',
                data: $('form#contactDeleteForm').serialize(),
                success: function(result) {
                    var dalay = 1500;
                    if(result.response == 1){
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: 'Successfully deleted',
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