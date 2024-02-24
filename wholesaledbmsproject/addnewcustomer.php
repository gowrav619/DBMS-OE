<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$cname = $_POST["Cname"];
	$customerID = $_POST["CustomerID"];
	$address = $_POST["Address"];

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "WMA";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Input validation
	if (empty($cname) || empty($customerID) || empty($address)) {
		$error = "Error: All fields are required";
	} else {
		// Prepare and bind the SQL statement
		$insert_query = "INSERT INTO customers (name, customer_id, address) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($insert_query);
		$stmt->bind_param("sss", $cname, $customerID, $address);

		// Attempt to execute the statement
		if ($stmt->execute()) {
			echo "New record created successfully";
		} else {
			// Check if the error is due to duplicate entry
			if ($conn->errno == 1062) {
				$error = "Error: Customer ID already exists. Please use a different ID.";
			} else {
				$error = "Error: " . $stmt->error;
			}
		}
		$stmt->close();
	}

	$conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
	<link rel="stylesheet" href="styles.css" type="text/css" />
</head>

<body>
	<section id="body" class="width">
		<aside id="sidebar" class="column-left">
			<header>
				<h1><a href="#">WholeSaler</a></h1>
				<h2>The Complete Info</h2>
			</header>
			<nav id="mainnav">
				<ul>
					<li class="selected-item"><a href="wholesaler.php">Home</a></li>
					<li><a href="newtransaction.php">New Transaction</a></li>
					<li><a href="addsupplier.php">New Suppliers</a></li>
					<li><a href="stocks.php">New stocks</a></li>
					<li><a href="updatingstocks.php">Print Bill</a></li>
					<li><a href="login.php">Logout</a></li>
				</ul>
			</nav>
		</aside>
		<section id="content" class="column-right">
			<blockquote>
				<p> The Bulk Vault</p>
			</blockquote>
			<p>&nbsp;</p>
			<article>
				<fieldset>
					<legend><strong>Sign Up</strong></legend>
					<?php if (!empty($error)) { ?>
						<div>
							<?php echo $error; ?>
						</div>
					<?php } ?>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<p><label for="name"><strong>Name:</strong></label>
							<input type="text" name="Cname" id="name" placeholder="Name" required />
						</p>
						<p><label for="CustomerID">Customer-ID:</label>
							<input type="text" name="CustomerID" id="CustomerID" required /><br />
						</p>
						<p><label for="Address">Address:</label>
							<textarea cols="60" rows="8" name="Address" id="Address" required></textarea><br />
						</p>
						<p><input type="submit" name="send" class="formbutton" value="Sign Up" /></p>
					</form>
				</fieldset>
			</article>
		</section>
		<div class="clear"></div>
	</section>
</body>

</html>