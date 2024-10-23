<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="login-container">
        <h2>Welcome to F.R.I.E.N.D.S Bakery</h2>


        <?php
        // Database connection
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
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
            $password = $_POST['password'];

            // Query to check if user exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Redirect to Homepage.html if login is successful
                    echo "<script>alert('Login successful!'); window.location.href = 'Homepage.html';</script>";
                } else {
                    echo "<script>alert('Invalid password. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Invalid username. Please try again.');</script>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>

        <form action="" method="POST">
            <div class="input-group">
                <!-- <label for="username">Username</label> -->
                <input type="text" id="username" placeholder="Enter your username" name="username" required>
            </div>
            <div class="input-group">
                <!-- <label for="password">Password</label> -->
                <input type="password" id="password" placeholder="Enter your username" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <div class="signup-section">
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
        </form>
    </div>
</body>
</html>
