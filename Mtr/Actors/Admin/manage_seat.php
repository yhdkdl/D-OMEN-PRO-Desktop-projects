<?php 
include 'db_connection.php';
if(isset($_GET['id'])){
    $mov = $conn->query("SELECT * FROM theater_settings where id =".$_GET['id']);
    foreach($mov->fetch_array() as $k => $v){
        $meta[$k] = $v;
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <form id="manage-seat">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <label for="" class="control-label">Theater Name</label>
                <select name="theater_id" required="" class="custom-select browser-default">
                    <option value=""></option>
                    <?php 
                    $theater = $conn->query("SELECT * FROM theater order by name asc");
                    while($row = $theater->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['theater_id']) && $meta['theater_id'] == $row['id'] ? 'selected' : '' ?>>
                        <?php echo $row['name'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="" class="control-label">Group Name</label>
                <input type="text" name="seat_group" class="form-control" value="<?php echo isset($meta['seat_group']) ? $meta['seat_group'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Seat Count</label>
                <input type="number" name="seat_count" min="0" class="form-control text-right" value="<?php echo isset($meta['seat_count']) ? $meta['seat_count'] : '' ?>">
            </div>
        </form>
    </div>
</div>

<script>
// Form submission
$('#manage-seat').submit(function(e){
    e.preventDefault(); // Prevent default form submission
    start_load(); // Custom function to show loading

    $.ajax({
        url: 'ajax.php?action=save_seat', // Save seat action in ajax.php
        data: new FormData($(this)[0]), // Send form data
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        error: function(err) {
            console.log(err); // Log errors
        },
        success: function(resp) {
            if(resp == 1) {
                alert_toast('Data successfully saved.', 'success'); // Show success toast
                setTimeout(function(){
                    location.reload(); // Reload page after saving
                }, 1500);
            }
        }
    });
});
</script>
