<?php
$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$customerID = $_POST["CustomerID"];
	$stockID = $_POST["StockID"];
	$quantity = $_POST["Quantity"];
	$totalAmount = $_POST["TotalAmount"];
	$date = $_POST["Date"];

	// Connect to MySQL database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "WMA";
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check the connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Subtract quantity from stocks table
	$sql_update = "UPDATE stocks SET quantity = quantity - $quantity WHERE stock_id = '$stockID'";

	if ($conn->query($sql_update) === TRUE) {
		// Insert transaction data into the database
		$sql_insert = "INSERT INTO transactions (name, customer_id, stock_id, quantity, total_amount, transaction_date) 
            VALUES ('$name', '$customerID', '$stockID', '$quantity', '$totalAmount', '$date')";

		if ($conn->query($sql_insert) === TRUE) {
			$message = "New transaction added successfully";
		} else {
			$message = "Error inserting transaction data: " . $conn->error;
		}
	} else {
		$message = "Error updating stock quantity: " . $conn->error;
	}

	// Close the database connection
	$conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>New Transaction</title>
	<link rel="stylesheet" href="styles.css" type="text/css">
	<script>
		function checkStockQuantity() {
			var stockID = document.getElementById("StockID").value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					var response = JSON.parse(this.responseText);
					if (response.quantity <= 0) {
						alert("Stock is empty");
						document.getElementById("Quantity").disabled = true;
					} else {
						document.getElementById("Quantity").disabled = false;
					}
				}
			};
			xhttp.open("GET", "check_stock_quantity.php?stockID=" + stockID, true);
			xhttp.send();
		}
	</script>
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
					<li><a href="wholesaler.php">Home</a></li>
					<li class="selected-item"><a href="newtransaction.php">New Transaction</a></li>
					<li><a href="addsupplier.php">New Suppliers</a></li>
					<li><a href="stocks.php">New stocks</a></li>
					<li><a href="updatingstocks.php">Print Bill</a></li>
					<li><a href="login.php">Logout</a></li>
				</ul>
			</nav>
		</aside>

		<section id="content" class="column-right">
			<blockquote>
				<p>The Bulk Vault</p>
			</blockquote>

			<article>
				<table>
					<thead>
						<tr>
							<th>Stock ID</th>
							<th>Stock Name</th>
							<th>Price per Unit</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Connect to MySQL database
						$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname = "WMA";
						$conn = new mysqli($servername, $username, $password, $dbname);

						// Check the connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						// Fetch stock data from the database
						$sql = "SELECT stock_id, name, price_per_unit, quantity FROM stocks";
						$result = $conn->query($sql);

						// Check if there are any rows returned
						if ($result->num_rows > 0) {
							// Output data of each row
							while ($row = $result->fetch_assoc()) {
								// If quantity is negative, display it as 0
								$quantity = max(0, $row["quantity"]);
								echo "<tr><td>" . $row["stock_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["price_per_unit"] . "</td><td>" . $quantity . "</td></tr>";
							}
						} else {
							echo "<tr><td colspan='4'>No stocks available</td></tr>";
						}

						// Close the database connection
						$conn->close();
						?>
					</tbody>
				</table>
				<br>
				<br>
				<fieldset>
					<legend><strong>NEW TRANSACTION</strong></legend>
					<form action="newtransaction.php" method="POST">
						<p><label for="name"><strong>Name:</strong></label>
							<input type="text" name="name" id="name" placeholder="Customer Name" required />
						</p>

						<p><label for="CustomerID">Customer-ID:</label>
							<input type="text" name="CustomerID" id="CustomerID" placeholder="CustomerID" required /><br />
						</p>

						<p><label for="StockID">Stock-ID:</label>
							<input type="text" name="StockID" id="StockID" placeholder="Stock ID" required
								onchange="checkStockQuantity()" /><br />
						</p>

						<p><label for="Quantity">Quantity:</label>
							<input type="text" name="Quantity" id="Quantity" placeholder="How Much??" required /><br />
						</p>

						<p><label for="TotalAmount">Total-Amount:</label>
							<input name="TotalAmount" id="TotalAmount" required /><br />
						</p>

						<p><label for="Date">Date:</label>
							<input type="date" name="Date" id="Date" value="" required /><br />
						</p>

						<p><input type="submit" name="send" class="formbutton" value="Send" /></p>
					</form>
				</fieldset>

			</article>

			<footer class="clear">
				<p>&copy; WholeSale Business Management by Gowrav, Jithesh, and Deepak</p>
			</footer>

		</section>

		<div class="clear"></div>
	</section>
</body>

</html>