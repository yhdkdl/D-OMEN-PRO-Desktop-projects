<?php 
include 'db_connection.php';
$meta = []; // Initialize the meta array
if (isset($_GET['id'])) {
    $mov = $conn->query("SELECT * FROM movies WHERE id =" . $_GET['id']);
    foreach ($mov->fetch_array() as $k => $v) {
        $meta[$k] = $v;
        if ($k == 'duration' && !is_numeric($k)) {
            $v = explode('.', $v);
            $meta['duration_hour'] = $v[0];
            $v[1] = isset($v[1]) ? $v[1] : 0;
            $meta['duration_min'] = 60 * ('.' . $v[1]);
        }
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <form id="manage-movie" enctype="multipart/form-data"> <!-- Ensure the form can handle file uploads -->
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div class="form-group">
                <label for="" class="control-label">Movie Title</label>
                <input type="text" name="title" required="" class="form-control" value="<?php echo isset($meta['title']) ? $meta['title'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Description</label>
                <textarea name="description" class="form-control" id="" cols="30" rows="3" required><?php echo isset($meta['description']) ? $meta['description'] : ''; ?></textarea>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-12">Duration</label>
                <input type="number" name="duration_hour" required="" class="form-control col-sm-2 offset-md-1" value="<?php echo isset($meta['duration_hour']) ? $meta['duration_hour'] : ''; ?>" max="12" min="0" placeholder="Hour">:
                <input type="number" name="duration_min" required="" class="form-control col-sm-2" max="59" min="0" value="<?php echo isset($meta['duration_min']) ? $meta['duration_min'] : ''; ?>" placeholder="Min">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Showing Schedule</label>
                <input name="date_showing" id="" type="date" class="form-control" value="<?php echo isset($meta['date_showing']) ? $meta['date_showing'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">End Date</label>
                <input name="end_date" id="" type="date" class="form-control" value="<?php echo isset($meta['end_date']) ? $meta['end_date'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <img src="./assets/img/ echo isset($meta['cover_img']) ? $meta['cover_img'] : ''; ?>" alt="" id="cover_img" width="50" height="75">
            </div>
            <div class="form-group input-group">
                <label for="" class="control-label">Cover Image</label>
                <br>
                <div class="input-group-prepend">
                    <span class="input-group-text">Upload</span>
                </div>
                <div class="custom-file">
                    <input type="file" name="cover" class="custom-file-input" id="cover-img" onchange="displayImg(this, $(this))">
                    <label class="custom-file-label" for="cover-img">Choose file</label>
                </div>
            </div>
            
            <!-- Save and Cancel Buttons -->
        </form>
    </div>
</div>

<script>
   $('#manage-movie').submit(function (e) {
    e.preventDefault();
    start_load(); // Start loading animation
    
    $.ajax({
        url: 'ajax.php?action=save_movie',
        data: new FormData($(this)[0]), // Pass FormData for file uploads
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        error: function(err) {
            console.error("Error during AJAX request:", err); // Log errors for debugging
            alert("An error occurred. Please try again.");
            end_load(); // End loading animation on error
        },
        success: function (resp) {
            console.log("Raw response from server: '" + resp + "'"); // Log server response for debugging
            
            // Trim any unexpected whitespace from the response
            resp = resp.trim();
            
            if (resp === "1") { // Ensure the response is exactly "1"
                alert_toast('Data successfully saved.', 'success');
                setTimeout(function () {
                    location.reload(); // Reload the page on success
                }, 1500);
            } else {
                // Log unexpected response
                console.error("Unexpected response from server: '" + resp + "'");
                alert_toast('Failed to save data. Server returned: ' + resp, 'danger');
            }
            end_load(); // End loading animation after processing
        }
    });
});


    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cover_img').attr('src', e.target.result);
                _this.siblings('label').html(input.files[0]['name']);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
