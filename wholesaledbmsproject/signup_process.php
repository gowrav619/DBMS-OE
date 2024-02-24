<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sign Up Page Wholesale</title>
  <style>
    body {
      background-image: url('g.jpg');
      background-color: #2c3338;
      /* Update background color */
      color: #606468;
      font: 400 0.875rem/1.5 "Open Sans", sans-serif;
      margin: 0;
      min-height: 100%;
      overflow-x: hidden;
      /* Prevent horizontal scrolling */
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
      color: #eee;
      /* Update text color */
      margin: 0;
      padding: 0;
      display: inline;
    }

    .site__container {
      margin: 0 auto;
      max-width: 400px;
      padding: 40px 20px;
      text-align: center;
    }

    .grid__container {
      margin: 0 auto;
      /* Center the grid container */
      width: 100%;
      max-width: 400px;
      /* Limit the width */
      padding: 20px;
      background-color: #2c3338;
      /* Update background color */
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form__field {
      margin-bottom: 20px;
    }

    .form__input {
      width: 100%;
      padding: 10px;
      border: 0;
      border-radius: 5px;
      font-size: 16px;
      background-color: #363b41;
      /* Update background color */
      color: #eee;
      /* Update text color */
    }

    .form__input:focus,
    .form__input:hover {
      background-color: #434A52;
      /* Update background color on hover */
    }

    .form__field input[type="submit"] {
      background-color: #ea4c88;
      color: #eee;
      font-weight: bold;
      text-transform: uppercase;
      border: 0;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .form__field input[type="submit"]:hover {
      background-color: #d44179;
    }

    .text--center {
      text-align: center;
      color: #eee;
      /* Update text color */
    }

    .hidden {
      display: none;
    }
  </style>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="site__container">
    <div class="grid__container">
      <form action="signup_process.php" method="post" class="form form--signup">
        <div class="the-container">
          <span class="the">BULK VAULT</span>
        </div>
        <div class="form__field">
          <label class="fontawesome-user hidden" for="signup__name">Name</label>
          <input id="signup__name" name="name" type="text" class="form__input" placeholder="Name" required>
        </div>

        <div class="form__field">
          <label class="fontawesome-user hidden" for="signup__username">Username</label>
          <input id="signup__username" name="username" type="text" class="form__input" placeholder="Username" required>
        </div>

        <div class="form__field">
          <label class="fontawesome-envelope hidden" for="signup__email">Email</label>
          <input id="signup__email" name="email" type="email" class="form__input" placeholder="Email" required>
        </div>

        <div class="form__field">
          <label class="fontawesome-lock hidden" for="signup__password">Password</label>
          <input id="signup__password" name="password" type="password" class="form__input" placeholder="Password"
            required>
        </div>

        <div class="form__field">
          <input type="submit" value="Sign Up">
        </div>
      </form>

      <p class="text--center">Already have an account? <a href="login.php">Sign in</a> <span
          class="fontawesome-arrow-right"></span></p>
    </div>
  </div>
</body>

</html>

<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate form inputs
  $name = $_POST['name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Perform any additional validation you require

  // Connect to your database (replace these variables with your actual database credentials)
  $servername = "localhost";
  $db_username = "root";
  $db_password = "";
  $dbname = "WMA";

  // Create connection
  $conn = new mysqli($servername, $db_username, $db_password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare and bind SQL statement
  $stmt = $conn->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $username, $email, $password);

  // Execute the statement
  if ($stmt->execute()) {
    // Registration successful, redirect to wholesaler.php
    $_SESSION['registration_success'] = true;
    header("Location: login.php");
    exit;
  } else {
    // Registration failed
    $error_message = "Registration failed. Please try again later.";
  }

  // Close connection
  $stmt->close();
  $conn->close();
}
?>