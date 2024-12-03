<?php
session_start();
include('db_connection.php');

// Protect admin area
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $first_name = filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $last_name = filter_var(trim($_POST['last_name']), FILTER_SANITIZE_STRING);
    $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Additional server-side validation
    if (empty($first_name) || empty($last_name) || empty($phone) || empty($email) || empty($password)) {
        echo "<script>alert('All fields are required.'); window.location.href = 'admin.php';</script>";
        exit;
    }

    // Validate phone number (ensure it's 10 digits)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Phone number must be a 10-digit number.'); window.location.href = 'admin.php';</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email is already in use
    $stmt = $conn->prepare("SELECT email FROM managers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Manager already exists with this email.'); window.location.href = 'admin.php';</script>";
    } else {
        // Insert the manager into the database (without start_date)
        $insert_stmt = $conn->prepare("INSERT INTO managers (first_name, last_name, phone, email, password) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssss", $first_name, $last_name, $phone, $email, $hashed_password);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Manager added successfully.'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error adding manager.'); window.location.href = 'admin.php';</script>";
        }
    }

    // Close the statements
    $stmt->close();
    $insert_stmt->close();
    $conn->close();
}
?>
