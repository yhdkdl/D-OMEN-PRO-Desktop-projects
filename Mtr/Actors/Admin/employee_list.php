<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
   .btn-orangered {
            background-color: orangered;
            color: white;
        
        }

        
   
</style>
</head>
<body>
  <?php include('db_connection.php');
   ?>

  <!-- Button to trigger Add Employee modal -->
  <button type="button" class="btn btn-primary btn-orangered" id="addEmployeeButton">
    Add Employee
  </button>

  <!-- Employee Table -->
  <div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 >Employee Profile</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <?php

            // Fetch employee data
            $query = "SELECT * FROM employee";
            $query_run = mysqli_query($conn, $query);
          ?>
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Start Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                   if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                      // Skip the row if the role is 'admin'
                      if ($row['role'] === 'admin') {
                        continue;
                      }
              ?>
                  <tr>
                    <td><?php echo $row['emp_id']; ?></td>
                    <td><?php echo $row['full_Name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
    <!-- Action button with dropdown menu -->
<center>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-orangered">Action</button>
                                            <button type="button" class="btn btn-primary dropdown-toggle btn-orangered dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only btn-orangered">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" onclick="editEmployee('<?php echo $row['emp_id']; ?>')">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" onclick="deleteEmployee('<?php echo $row['emp_id']; ?>')">Delete</a>
                                            </div>
                                        </div>
                                    </center>
                  </tr>
              <?php
                  }
                } else {
                  echo "No Record Found";
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Placeholder (for dynamically loading the modal) -->
  <div id="modalPlaceholder"></div>

  <!-- JS Includes -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script>
    // Manually initialize the dropdown to ensure it's functioning
    $('.dropdown-toggle').dropdown();

    $(document).ready(function() {
      // When the Add Employee button is clicked
      $('#addEmployeeButton').on('click', function() {
        // Load the modal form from 'manage_employee.php' and insert it into the #modalPlaceholder div
        $('#modalPlaceholder').load('manage_employee.php', function() {
          // After the modal is loaded, show it
          $('#addEmployeeModal').modal('show');
        });
      });
    });
   

function editEmployee(emp_id) {
    // Use AJAX to load the edit form with the specific employee's data from 'manage_employee.php'
    $('#modalPlaceholder').load('manage_employee.php?id=' + emp_id, function() {
        // After loading the modal content, show it
        $('#addEmployeeModal').modal('show');
    });}
    // Function to delete employee
    function deleteEmployee(emp_id) {
      if (confirm("Are you sure you want to delete this employee?")) {
        $.ajax({
          url: 'ajax.php?action=delete_employee',
          method: 'POST',
          data: { emp_id: emp_id },
          success: function(response) {
            alert(response);
            location.reload();
          }
        });
      }
    }
    
  </script>
</body>
</html>
