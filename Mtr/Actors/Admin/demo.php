<?php 
include 'db_connection.php';
$emp_data = []; // Initialize the data array

// Load employee data if an ID is provided for editing
if (isset($_GET['id'])) {
    $emp = $conn->query("SELECT * FROM employees WHERE emp_id =" . $_GET['id']);
    foreach ($emp->fetch_assoc() as $key => $value) {
        $emp_data[$key] = $value;
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12" id="modalPlaceholder">
        <form id="manage-employee" enctype="multipart/form-data"> <!-- Enable file uploads if needed -->
            
            <!-- Employee ID (read-only for editing) -->
            <div class="form-group">
                <label for="emp_id" class="control-label">Employee ID</label>
                <input type="text" name="emp_id" id="emp_id" class="form-control" 
                       value="<?php echo isset($emp_data['emp_id']) ? $emp_data['emp_id'] : ''; ?>"
                       <?php echo isset($emp_data['emp_id']) ? 'readonly' : ''; ?> placeholder="Enter Employee ID">
            </div>

            <!-- Full Name Field -->
            <div class="form-group">
                <label for="fullName" class="control-label">Full Name</label>
                <input type="text" name="fullName" id="fullName" required class="form-control" 
                       value="<?php echo isset($emp_data['fullName']) ? $emp_data['fullName'] : ''; ?>" 
                       placeholder="Enter Full Name">
            </div>

            <!-- Phone Field -->
            <div class="form-group">
                <label for="phone" class="control-label">Phone</label>
                <input type="tel" name="phone" id="phone" required class="form-control" 
                       value="<?php echo isset($emp_data['phone']) ? $emp_data['phone'] : ''; ?>" 
                       pattern="[0-9]{10}" placeholder="Enter 10-digit phone number">
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" name="email" id="email" required class="form-control" 
                       value="<?php echo isset($emp_data['email']) ? $emp_data['email'] : ''; ?>" 
                       placeholder="Enter Email">
            </div>

            <!-- Role Field -->
            <div class="form-group">
                <label for="role" class="control-label">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="">Select</option>
                    <option value="Manager" <?php echo (isset($emp_data['role']) && $emp_data['role'] == 'Manager') ? 'selected' : ''; ?>>Manager</option>
                    <option value="Front_deskofficer" <?php echo (isset($emp_data['role']) && $emp_data['role'] == 'Front_deskofficer') ? 'selected' : ''; ?>>Front Desk Officer</option>
                </select>
            </div>

            <!-- Password Field (Required for new employees only) -->
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" 
                       placeholder="Enter Password" <?php echo isset($emp_data['password']) ? '' : 'required'; ?>>
            </div>

            <!-- Modal Footer with Save and Close Buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

  <!-- JS Includes -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script>
$(document).ready(function() {
    // Trigger the modal and load data if edit button is clicked
    $('.edit-employee-btn').on('click', function() {
        var emp_id = $(this).data('id');
        
        // Load modal content dynamically with employee data
        $('#modalPlaceholder').load('manage_employee.php?id=' + emp_id, function() {
            $('#addEmployeeModal').modal('show');
        });
    });

    // Add Employee button
    $('#addEmployeeButton').on('click', function() {
        $('#modalPlaceholder').load('manage_employee.php', function() {
            $('#addEmployeeModal').modal('show');
        });
    });

    // Form submission for Add/Edit
    $('#manage-employee').on('submit', function(e) {
        e.preventDefault();
        start_load();

        $.ajax({
            url: 'ajax.php?action=save_employee',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                resp = resp.trim();

                if (resp === "1") {
                    alert_toast('Employee successfully saved.', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast('Failed to save employee. Server returned: ' + resp, 'danger');
                }
                end_load();
            },
            error: function(err) {
                alert("An error occurred. Please try again.");
                end_load();
            }
        });
    });
});
</script>

</body>
</html>
