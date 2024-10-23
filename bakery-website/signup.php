<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css" class="rel">
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>

        <?php
        // Database connection
        $servername = "localhost";
        $db_username = "root";  // default username for MySQL
        $db_password = "";  // default password for MySQL
        $dbname = "bakery_db";

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

            // Prepared statement to avoid SQL injection
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                echo "<script>alert('Sign up successful! Redirecting to login page.'); window.location.href = 'login1.php';</script>";
            } else {
                // Show a user-friendly message if username already exists
                if ($stmt->errno === 1062) {
                    echo "<script>alert('Username already taken. Please choose a different username.');</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }

            $stmt->close();
        }

        $conn->close();
        ?>

        <form action="" method="POST">
            <div class="input-group">
                <!-- <label for="username">Username</label> -->
                <input type="text" id="username" placeholder="Username" name="username" required>
            </div>
            <div class="input-group">
                <!-- <label for="email">Email</label> -->
                <input type="email" id="email" placeholder="Enter the mail id" name="email" required>
            </div>
            <div class="input-group">
                <!-- <label for="password">Password</label> -->
                <input type="password" id="password" placeholder="Password" name="password" required>
            </div>
            <button type="submit" class="signup-btn">Sign Up</button>
        </form>
    </div>
</body>
</html>
