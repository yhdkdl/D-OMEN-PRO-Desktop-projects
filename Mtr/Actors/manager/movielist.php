<style>
    td img {
        width: 50px;
        height: 75px;
        margin: auto;
    }
        /* Custom Styles */
        .btn-orangered {
            background-color: orangered;
            color: white;
        
        }

        .btn-orangered:hover {
            background-color: #ff6347; /* Lighter shade on hover */
        }
   
</style>
<?php include 'db_connection.php'; ?>

<!-- Bootstrap modal structure for displaying the movie form -->
<div class="modal fade" id="movieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="movieModalTitle">Manage Movie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Content will be loaded dynamically via AJAX -->
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-block btn-sm btn-primary btn-orangered col-sm-2" type="button" id="new_movie">
                <i class="fa fa-plus btn-orangered" ></i>+New Movie
            </button>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-12 mt-3">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Cover</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $movie = $conn->query("SELECT * FROM movies");
                        while ($row = $movie->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>
                                    <center><img src="./assets/img/<?php echo $row['cover_img']; ?>" alt=""></center>
                                </td>
                                <td><?php echo ucwords($row['title']); ?></td>
                                <?php if (strtotime(date('Y-m-d')) < strtotime($row['date_showing'])) : ?>
                                    <td>Pending</td>
                                <?php elseif (strtotime(date('Y-m-d')) > strtotime($row['date_showing']) && strtotime(date('Y-m-d')) < strtotime($row['end_date'])) : ?>
                                    <td>Showing</td>
                                <?php else : ?>
                                    <td>Ended</td>
                                <?php endif; ?>
                                <td>
                                    <center>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-orangered">Action</button>
                                            <button type="button" class="btn btn-primary dropdown-toggle btn-orangered dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only btn-orangered">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit_movie" href="javascript:void(0)" data-id='<?php echo $row['id']; ?>'>Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_movie" href="javascript:void(0)" data-id='<?php echo $row['id']; ?>'>Delete</a>
                                            </div>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Add/Edit Forms -->
<div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='submit' onclick="$('#manage-movie').submit()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- Required JavaScript libraries -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (Required for Bootstrap dropdowns) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Function to load modals
    function uni_modal(title, url) {
        $.ajax({
            url: url,
            success: function(response) {
                $('#uni_modal .modal-title').html(title);
                $('#uni_modal .modal-body').html(response);
                $('#uni_modal').modal('show');
            },
            error: function(err) {
                alert("An error occurred while opening the modal.");
            }
        });
    }

    // Button click events to open modals
    $('#new_movie').click(function(){
		uni_modal('New Movie','manage_movie.php');
    });
    $('.edit_movie').click(function() {
        uni_modal('Edit movie Group', 'manage_movie.php?id=' + $(this).attr('data-id'));
    });
   
    $('.delete_movie').click(function() {
        _conf('Are you sure you want to delete this movie group?', 'delete_movie', $(this).attr('data-id'));
    });
    // Manually initialize the dropdown to ensure it's functioning
    $('.dropdown-toggle').dropdown();

    function start_load() {
        console.log("Loading...");
    }

    function alert_toast(message, type) {
        alert(message);
    }

    function _conf(message, action, id) {
        if (confirm(message)) {
            window[action](id);
        }
    }


    function delete_movie(id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_movie',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("movie  successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error deleting movie ", 'danger');
                }
            },
            error: function() {
                alert_toast("An error occurred while processing the request", 'danger');
            }
        });
    }

</script>
