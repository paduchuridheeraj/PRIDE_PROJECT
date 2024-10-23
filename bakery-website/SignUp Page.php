<!doctype html>
<html>
<head>
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/815d5311a8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyle.css">
    <script src="myscript.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        /* Add your styles here */
    </style>
</head>
<body>

<div id="signUp">
    <div id="letsGo" style="font-size:10vh;font-family: 'Great Vibes', cursive;">Let's Go!!</div>

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
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username already exists
        $checkQuery = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username already exists. Please choose another.');</script>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $insertQuery = "INSERT INTO users (name, email, mobile, username, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssss", $name, $email, $mobile, $username, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Sign up successful!'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Error occurred. Please try again.');</script>";
            }
        }

        $stmt->close();
    }

    $conn->close();
    ?>

    <form method="POST" action="">
        <label for="fname" class="field"><b>Name</b><span style="color:red;"><b>*</b></span></label>
        <input class="inp" type="text" name="name" id="fname" placeholder="Enter your Name" size="35" required />

        <label for="mail" class="field"><b>Email</b></label>
        <input class="inp" type="email" name="email" id="mail" placeholder="Enter your Email id" size="35" />

        <label for="num" class="field"><b>Mobile No.</b><span style="color:red;"><b>*</b></span></label>
        <input class="inp" type="tel" name="mobile" id="num" placeholder="Enter your Mobile number" size="35" required />

        <label for="userN" class="field"><b>Username</b><span style="color:red;"><b>*</b></span></label>
        <input class="inp" type="text" name="username" id="userN" placeholder="Enter your Username" size="35" required />

        <label for="pass" class="field"><b>Password</b><span style="color:red;"><b>*</b></span></label>
        <input class="inp" type="password" name="password" id="pass" placeholder="Enter your Password" size="35" required />

        <button type="submit" class="btn" style="font-size:2.7vh; align-self: stretch; margin-bottom: 0.6rem;">Sign Up</button>

        Already have an account? <a href="login.php" class="login"><u>Click here to login!</u></a>
    </form>
</div>

</body>
</html>
