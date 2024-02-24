<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>WholeSaler-Login</title>
	<link rel="stylesheet" href="styles.css" type="text/css" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
			background-color: white;
		}

		th {
			padding: 8px;
			text-align: left;
			background-color: #333;
			color: white;
		}

		td {
			border-bottom: 1px solid black;
			/* Add border only on the bottom */
			padding: 8px;
			text-align: left;
		}

		td:last-child {
			border-right: none;
			/* Remove border for the last column */
		}
	</style>
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
					<li><a href="newtransaction.php">New Transaction</a></li>
					<li class="selected-item"><a href="addsupplier.php">New Suppliers</a></li>
					<li><a href="stocks.php">New stocks</a></li>
					<li><a href="updatingstocks.php">Print Bill</a></li>
					<li><a href="login.php">Logout</a></li>
				</ul>
			</nav>

		</aside>

		<section id="content" class="column-right">

			<article>

				<blockquote>
					<p> The Bulk Vault</p>
				</blockquote>
				<p>&nbsp;</p>

				<fieldset>
					<legend><strong>NEW Supplier</strong></legend>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<p><label for="name"><strong>Name:</strong></label>
							<input type="text" name="name" id="name" placeholder="Name" required />
						</p>
						<p><label for="IndustryID">Industry ID:</label>
							<input type="text" name="IndustryID" id="IndustryID" required />
						</p>
						<p><label for="StockID">Stock ID:</label>
							<input type="text" name="StockID" id="StockID" required />
						</p>
						<p><label for="Address">Address:</label>
							<textarea name="Address" id="Address" required></textarea>
						</p>
						<p><label for="Quantity">Quantity:</label>
							<input type="text" name="Quantity" id="Quantity" required />
						</p>
						<p><input type="submit" name="send" class="formbutton" value="Send" /></p>
					</form>
				</fieldset>

			</article>

			<article>
				<?php
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "WMA";
				$conn = new mysqli($servername, $username, $password, $dbname);

				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				function updateStockQuantity($conn, $stockID, $quantity)
				{
					$update_sql = "UPDATE stocks SET quantity = quantity + $quantity WHERE stock_id = '$stockID'";
					if ($conn->query($update_sql) === TRUE) {
						echo "Quantity updated in stocks table<br>";
					} else {
						echo "Error updating quantity in stocks table: " . $conn->error . "<br>";
					}
				}

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$name = $_POST["name"];
					$industryID = $_POST["IndustryID"];
					$stockID = $_POST["StockID"];
					$address = $_POST["Address"];
					$quantity = $_POST["Quantity"];

					$check_sql = "SELECT * FROM stocks WHERE stock_id = '$stockID'";
					$result = $conn->query($check_sql);

					if ($result->num_rows > 0) {
						// If stock ID exists, update the quantity in stocks table
						updateStockQuantity($conn, $stockID, $quantity);
					} else {
						echo "Error: Invalid stock ID<br>";
					}

					// Insert supplier into suppliers table
					$sql = "INSERT INTO suppliers (name, industry_id, stock_id, address, quantity) 
                                VALUES ('$name', '$industryID', '$stockID', '$address', '$quantity')";
					if ($conn->query($sql) === TRUE) {
						echo "New supplier added successfully<br>";
					} else {
						echo "Error adding supplier: " . $sql . "<br>" . $conn->error;
					}
				}

				if ($conn) {
					$conn->close();
				}
				?>
			</article>

			<footer class="clear">
				<p>&copy; WholeSale Business Managment by Gowrav, Jithesh and Deepak</p>
			</footer>

		</section>

		<div class="clear"></div>

	</section>

</body>

</html>