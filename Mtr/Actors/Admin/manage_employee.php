<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<?php
include 'db_connection.php';
$emp_data = []; // Initialize the data array

// Check if the employee ID is passed in the URL
if (isset($_GET['id'])) {
    $emp_id = $_GET['id']; // Get the employee ID from the URL
    
    // Ensure the emp_id is sanitized to prevent SQL injection
    $emp_id = mysqli_real_escape_string($conn, $emp_id); // Sanitize input

    // Check if the emp_id is numeric or a string, and build the query accordingly
    if (is_numeric($emp_id)) {
        $query = "SELECT * FROM employee WHERE emp_id = $emp_id"; // For numeric emp_id
    } else {
        // For non-numeric (string) emp_id, add quotes around the value
        $query = "SELECT * FROM employee WHERE emp_id = '$emp_id'"; // For string emp_id
    }

    // Run the query
    $emp = $conn->query($query);

    // Check if employee data exists
    if ($emp && $emp->num_rows > 0) {
        $emp_data = $emp->fetch_assoc(); // Fetch employee data for the given ID
    } else {
        echo "Employee not found."; // Handle if no employee is found
    }
}
?>

  <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="employeeForm" method="POST" action="ajax.php?action=save_employee">
          <div class="modal-body">
           <div class="form-group">
                <label> Employee id </label>
                <input type="text" name="emp_id" class="form-control" placeholder="id" 
                  <?php echo isset($_GET['id']) ? 'readonly' : ''; ?>
                  value="<?php echo isset($emp_data['emp_id']) ? $emp_data['emp_id'] : ''; ?>">
            </div>
          <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" name="fullName" id="fullName" class="form-control" 
                   placeholder="Enter Full Name" required
                   value="<?php echo isset($emp_data['full_Name']) ? $emp_data['full_Name'] : ''; ?>">
          </div>
          <div class="form-group">
          <label for="phone">Phone:</label>
          <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}" 
                 placeholder="Enter 10-digit phone number"
                 value="<?php echo isset($emp_data['phone']) ? $emp_data['phone'] : ''; ?>">
        </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required
                   value="<?php echo isset($emp_data['email']) ? $emp_data['email'] : ''; ?>">
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                            <option value="">Select</option>
                            <option value="Manager" <?php echo (isset($emp_data['role']) && $emp_data['role'] == 'Manager') ? 'selected' : ''; ?>>Manager</option>
                            <option value="Front_deskofficer" <?php echo (isset($emp_data['role']) && $emp_data['role'] == 'Front_deskofficer') ? 'selected' : ''; ?>>Front Desk Officer</option>
                        </select>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" 
                   <?php echo isset($emp_data['password']) ? '' : 'required'; ?>>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveEmployeeButton">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS Includes -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      // Show modal on page load if it's an "Add New Employee" page
      $('#addEmployeeModal').modal('show');
    });

    // Intercept form submission for AJAX processing
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Send form data via AJAX
        $.ajax({
            url: 'ajax.php?action=save_employee', // Update with your actual path
            method: 'POST',
            data: $(this).serialize(), // Serialize form data
            dataType: 'text', // Expect plain text (1 or 0) response
            success: function(response) {
                // Check response value
                if (response === '1') {
                    alert("Employee saved successfully!"); // Success alert
                    $('#addEmployeeModal').modal('hide'); // Hide modal
                    location.reload(); // Reload page to update employee list
                } else {
                    alert("Error saving employee. Please try again."); // Error alert
                }
            },
            error: function() {
                alert("An error occurred. Please try again.");
            }
        });
    });
  </script>
</body>
</html>
