

<?php
// Include database connection
include('db_connection.php');

// Fetch feedback from the database
$sql = "SELECT customer_email, message, date_submitted FROM feedback ORDER BY date_submitted DESC";
$result = $conn->query($sql);
?>

<div class="container">
  <h1>Customer Feedback</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Customer Email</th>
        <th>Message</th>
        <th>Date Submitted</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
          // Output data of each row
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['customer_email']}</td>
                      <td>{$row['message']}</td>
                      <td>{$row['date_submitted']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='3'>No feedback found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php
// Close connection
$conn->close();
?>

