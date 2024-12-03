<?php 
include 'db_connection.php';
if(isset($_GET['id'])){
    $mov = $conn->query("SELECT * FROM theater WHERE id =" . $_GET['id']);
    foreach($mov->fetch_array() as $k => $v){
        $meta[$k] = $v;
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <form id="manage-theater">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <label for="" class="control-label">Theater Name</label>
                <input type="text" name="name" required="" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>">
        </form>
    </div>
</div>

<script>
    $('#save_btn').click(function() {
    // Trigger form submission (which should already have AJAX logic)
    $('#manage-theater').submit();
});

$('#manage-theater').submit(function(e) {
    e.preventDefault();  // Prevent default form submission
    $.ajax({
        url: 'ajax.php?action=save_theater',  // Your server-side processing script
        method: 'POST',
        data: $(this).serialize(),  // Serialize form data for submission
        success: function(response) {
            if (response == 1) {
                alert('Theater saved successfully');
                $('#uni_modal').modal('hide');  // Hide the modal after successful save
            } else {
                alert('An error occurred');
            }
        },
        error: function(err) {
            console.log('Error:', err);
        }
    });
});


</script>
