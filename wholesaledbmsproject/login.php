<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are provided
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        // Define your database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "WMA";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL statement to retrieve user's password based on the provided username
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a row is found with the given username
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify the password
            if ($_POST["password"] === $row["password"]) {
                // Password is correct, set session variables and redirect to wholesaler.php
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $row["username"];
                header("Location: wholesaler.php");
                exit;
            } else {
                // Password is incorrect, show an error message
                $error_message = "Invalid username or password";
            }
        } else {
            // No user found with the given username, show an error message
            $error_message = "Invalid username or password";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    } else {
        // If either username or password is not provided, show an error message
        $error_message = "Please enter both username and password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page Wholesale</title>
    <style>
        body {
            background-image: url('g.jpg');
            background-color: #cccccc;
            /* Used if the image is unavailable */
            height: 500px;
            /* You must set a specified height */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;
            /* Resize the background image to cover the entire container */
        }

        .the-container {
            display: flex;
            justify-content: center;
        }

        .the {
            font-size: 70px;
            font-weight: bold;
            font-family: sans-serif;
            text-transform: uppercase;
            color: black;
            /* Black text color */
            margin: 0;
            /* Remove margin */
            padding: 0;
            /* Remove padding */
            display: inline;
            /* Display inline */
        }

        .site__container {
            margin: 0 auto;
            max-width: 400px;
            padding: 40px 20px;
            text-align: center;
        }

        .grid__container {
            display: grid;
            gap: 20px;
        }

        .form__field {
            margin-bottom: 20px;
        }

        .form__input {
            padding: 10px;
            width: 100%;
        }

        .text--center {
            text-align: center;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="site__container">
        <div class="grid__container">
            <form action="#" method="post" class="form form--login">
                <div class="the-container">
                    <span class="the">BULK VAULT</span>
                </div>
                <div class="form__field">
                    <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
                    <input id="login__username" name="username" type="text" class="form__input" placeholder="Username"
                        required>
                </div>

                <div class="form__field">
                    <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
                    <input id="login__password" name="password" type="password" class="form__input"
                        placeholder="Password" required>
                </div>

                <div class="form__field">
                    <input type="submit" value="Sign In" name="Login">
                </div>
            </form>


            <p class="text--center">Not a member? <a href="signup_process.php">Sign up now</a> <span
                    class="fontawesome-arrow-right"></span></p>
        </div>
    </div>

</body>

</html>