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

    $page = 1;
    if(isset($_GET['page'])){
        $page = intval($_GET['page']);
    }
    $per_page = 2;
    if(isset($_GET['per_page'])){
        $per_page = intval($_GET['per_page']);
    }
    

    try{
        $sql = "SELECT count(*) as count FROM contacts
            WHERE user_id = :user_id";
        $query=$db->connect()->prepare($sql);
        $query->bindParam(':user_id', $contact['user_id']);
        if($query->execute()){
            $item_count = $query->fetch()['count'];
        }
    }catch (PDOException $e){
        return false;
    }
    
    $prev_page = null;
    if($page > 1){
        $prev_page = $page-1;
    }else{
        $prev_page = $page;
    }
    
    $next_page = intval($item_count/ $per_page )+1;
    if($page <= $item_count/ $per_page ){
        
    }

    try{
        $offset = $per_page * ($page-1);
        $limit = $per_page;
        $sql = "SELECT id,user_id,name,company,phone,email,is_active,date_created,date_updated FROM contacts
            WHERE user_id = :user_id
            ORDER BY id DESC
            LIMIT ".$limit." OFFSET ".$offset."
            ";
        $query=$db->connect()->prepare($sql);
        $query->bindParam(':user_id', $contact['user_id']);
        if($query->execute()){
            $table_data = $query->fetchAll();
        }
    }catch (PDOException $e){
        return false;
    }

    

    $paginate = [
        'active_page'=> [
            'page_number'=>$page,
            'id'=> NULL,
        ],
        'prev_page'=> [
            'page_number'=>$prev_page,
            'id'=> NULL,
        ],
        'next_page'=> [
            'page_number'=>$next_page,
            'id'=> NULL,
        ],
        'start_page'=> [
            'page_number'=>1,
            'id'=> NULL,
        ],
        'end_page'=> [
            'page_number'=>1,
            'id'=> NULL,
        ],
        'item_count'=> $item_count,
        'per_page'=>$per_page,
        'data'=> $table_data,
    ];


    
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
                            foreach ($paginate['data'] as $key => $value) {
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
                <a href="/user/contacts/?page=<?php echo $paginate['prev_page']['page_number'] ?>">
                    <button class="btn btn-outline-secondary mx-1"><</button>
                </a>
                <?php 
                    if(intval($paginate['item_count']/$paginate['per_page'])){
                        $by_side = 3;
                        if($paginate['active_page']['page_number']>1){
                            $temp_page = $paginate['active_page']['page_number']-$by_side;
                            while($temp_page+1 < $paginate['active_page']['page_number']){
                                $temp_page++;
                                if($temp_page){
                                    echo '
                                    <a href="/user/contacts/?page='.($temp_page).'">
                                        <button class="btn btn-outline-secondary mx-1">'.($temp_page).'</button>
                                    </a>
                                    ';
                                }
                            }
                        }
                    }
                ?>
                <a href="">
                    <button class="btn btn-secondary mx-1"><?php echo $paginate['active_page']['page_number'] ?></button>
                </a>
                <?php 
                if(($paginate['per_page']*$paginate['active_page']['page_number'] ) < $paginate['item_count']){
                    $by_side = 3;
                    $temp_page = $paginate['active_page']['page_number'];
                    while(($paginate['per_page'] * ($temp_page)) < $paginate['item_count']){
                        $temp_page++;
                        echo '
                        <a href="/user/contacts/?page='.($temp_page).'">
                            <button class="btn btn-outline-secondary mx-1">'.($temp_page).'</button>
                        </a>
                        ';
                    }
                }
                ?>
                <a href="/user/contacts/?page=<?php echo $paginate['next_page']['page_number'] ?>">
                    <button class="btn btn-outline-secondary mx-1">></button>
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