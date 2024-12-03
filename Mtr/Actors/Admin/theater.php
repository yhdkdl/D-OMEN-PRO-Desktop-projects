<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Management</title>
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
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
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- New Theater Button -->
            <button class="btn btn-block btn-sm btn-orangered col-sm-2" type="button" id="new_theater">
                <i class="fa fa-plus"></i> New Theater
            </button>

            <!-- New Seat Group Button -->
            <button class="btn btn-block btn-sm btn-orangered col-sm-2" type="button" id="new_group">
                <i class="fa fa-plus"></i> Seat Groups
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Theaters Section -->
        <div class="card col-md-4 mt-3">
            <div class="card-header">
                <large>Theaters</large>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('db_connection.php');
                        $i = 1;
                        $theater = $conn->query("SELECT * FROM theater ORDER BY name ASC");
                        while ($row = $theater->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td>
                                    <center>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm btn-orangered ">Action</button>
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle btn-orangered  dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only btn-orangered  btn-orangered  ">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu ">
                                                <a class="dropdown-item edit_theater" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_theater" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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

        <!-- Seat Groups Section -->
        <div class="card col-md-7 mt-3 ml-3">
            <div class="card-header">
                <large>Seat Groups</large>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Theater</th>
                            <th class="text-center">Group</th>
                            <th class="text-center">Seats</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $theater = $conn->query("SELECT ts.*, t.name FROM theater_settings ts INNER JOIN theater t ON ts.theater_id = t.id ORDER BY t.name ASC, ts.seat_group ASC");
                        while ($row = $theater->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['seat_group'] ?></td>
                                <td><?php echo $row['seat_count'] ?></td>
                                <td>
                                    <center>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm btn-orangered ">Action</button>
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle btn-orangered  dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only btn-orangered ">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit_seat" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_seat" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
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
    $('#new_theater').click(function() {
        uni_modal('New Theater', 'manage_theater.php');
    });

    $('#new_group').click(function() {
        uni_modal('New Seat Group', 'manage_seat.php');
    });

    // Edit and Delete actions
    $('.edit_theater').click(function() {
        uni_modal('Edit Theater', 'manage_theater.php?id=' + $(this).attr('data-id'));
    });

    $('.delete_theater').click(function() {
        _conf('Are you sure you want to delete this theater?', 'delete_theater', $(this).attr('data-id'));
    });

    $('.edit_seat').click(function() {
        uni_modal('Edit Seat Group', 'manage_seat.php?id=' + $(this).attr('data-id'));
    });

    $('.delete_seat').click(function() {
        _conf('Are you sure you want to delete this seat group?', 'delete_seat', $(this).attr('data-id'));
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

    function delete_theater(id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_theater',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Theater successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error deleting theater", 'danger');
                }
            },
            error: function() {
                alert_toast("An error occurred while processing the request", 'danger');
            }
        });
    }

    function delete_seat(id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_seat',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Seat group successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error deleting seat group", 'danger');
                }
            },
            error: function() {
                alert_toast("An error occurred while processing the request", 'danger');
            }
        });
    }
</script>

</body>
</html>
