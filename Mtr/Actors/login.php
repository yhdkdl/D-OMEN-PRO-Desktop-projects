<?php
session_start();
require_once './Admin/db_connection.php'; // Include your DB connection here

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate email and password inputs
    if (!empty($email) && !empty($password)) {
        // Prepare SQL query to check user credentials and get their role from the `users` table
        $stmt = $conn->prepare("
            SELECT email, password, role FROM employee WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a matching user was found
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify the password (assuming the password is hashed in the DB)
            if (password_verify($password, $user['password'])) {
                // Store user information in the session
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = ucfirst($user['role']); // Store the user's role (Admin, Manager, or Cinema Staff)

                if ($_SESSION['user_role'] === 'Admin') {
                    header('Location:../Actors/Admin/adashboard.php');
                } elseif ($_SESSION['user_role'] === 'Manager') {
                    header('Location:../Actors/manager/mdashboard.php');
                }
                exit;
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "No account found with that email.";
        }
    } else {
        $error = "Please fill in all the fields.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Cinema Reservation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, lightgray);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            width: 450px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.2);
            margin: auto;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            color: #333; /* Dark gray */
            margin-bottom: 1.5rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group label {
            position: absolute;
            top: -18px;
            left: 15px;
            color: #555; /* Lighter gray */
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .input-group input {
            width: 100%;
            padding: 10px 15px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9; /* Light gray input background */
            outline: none;
        }

        .input-group input:focus {
            border: 2px solid #888; /* Slightly darker gray when focused */
            background-color: #fff;
        }

        .input-group input:focus ~ label {
            color: #888; /* Darker gray when focused */
        }

        .recover {
            text-align: right;
            margin-bottom: 1.5rem;
        }

        .recover a {
            text-decoration: none;
            color: #888; /* Gray for recovery link */
        }

        .recover a:hover {
            color: #333; /* Dark gray on hover */
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 5px;
            border: none;
            background-color: orangered; /* Dark gray button */
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #333; /* Even darker gray on hover */
        }

        .or {
            text-align: center;
            margin: 1.5rem 0;
            color: #555;
        }

        .icons {
            text-align: center;
        }

        .icons i {
            font-size: 1.5rem;
            color: #888; /* Gray for social icons */
            margin: 0 15px;
            transition: color 0.3s ease;
        }

        .icons i:hover {
            color: #333; /* Darker gray on hover */
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2 class="form-title">Staff Login</h2>

        <form method="POST" action="login.php">
            <div class="input-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>
            
            <div class="input-group">
                <input type="password" id="password" name="password" required minlength="6">
                <label for="password">Password</label>
            </div>
            
           
            
            <input type="submit" class="btn" value="Login">
            
            <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        </form>
        
    </div>

</body>
</html>
