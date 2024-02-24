<?php
session_start();
if ($_SESSION['Login'] != "Active") {
	header("location:login.php");
}
?>
<!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>WholeSaler-Login</title>

	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th,
		td {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		th {
			background-color: #f2f2f2;
		}
	</style>
	<link rel="stylesheet" href="styles.css" type="text/css" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
</head>

<body>

	<section id="body" class="width">
		<aside id="sidebar" class="column-left">

			<header>
				<h1><a href="#">WholeSaler</a></h1>

				<h2>The Complete Info</h2>

			</header>
			<!--THE LEFT SIDE MENU IS DUE TO THE ABOVE CODE...!!-->
			<nav id="mainnav">
				<ul>
					<li><a href="wholesaler.php">Home</a></li>
					<li><a href="newtransaction.php">New Transaction</a></li>
					<li><a href="addsupplier.php">New Suppliers</a></li>
					<li><a href="stocks.php">New stocks</a></li>
					<li class="selected-item"><a href="updatingstocks.php">Print Bill</a></li>
					<li><a href="login.php">Logout</a></li>
				</ul>
			</nav>
		</aside>

		<section id="content" class="column-right">
			<article>
				<blockquote>
					<p>The Bulk Vault</p>
				</blockquote>
				<p>&nbsp;</p>

				<fieldset>
					<legend><strong>
							<h3>Bills for the transaction</h3>
						</strong></legend>
					<form action="updatingstocks.php" method="POST">
						<p><label for="name"><strong>Customer ID:</strong></label>
							<input type="integer" name="CustomerID" id="name" placeholder="Customer-ID" required />
						<p><input type="submit" name="show" class="formbutton" value="Show" /></p>
					</form>
				</fieldset>

				<?php if (isset($_POST['show'])) {
					$customerID = $_POST['CustomerID']; ?>
					<fieldset>
						<legend><strong>
								<h3>Bill for Customer ID:
									<?php echo $customerID; ?>
								</h3>
							</strong></legend>
						<?php
						$conn = mysqli_connect("localhost", "root", "", "WMA");
						$sql = "SELECT customers.name AS customer_name,
                                    stocks.name AS stock_name,
                                    transactions.quantity AS quantity,
                                    transactions.total_amount AS total_amount,
                                    transactions.transaction_date AS transaction_date
                                    FROM transactions
                                    JOIN customers ON transactions.customer_id = customers.customer_id
                                    JOIN stocks ON transactions.stock_id = stocks.stock_id
                                    WHERE customers.customer_id = '$customerID'";
						$result = mysqli_query($conn, $sql);

						// Check if any rows were returned
						if (mysqli_num_rows($result) > 0) {
							?>
							<table>
								<tr>
									<th>Customer Name</th>
									<th>Stock Name</th>
									<th>Quantity</th>
									<th>Total Amount</th>
									<th>Transaction Date</th>
								</tr>
								<?php
								while ($row = mysqli_fetch_assoc($result)) {
									?>
									<tr>
										<td>
											<?php echo $row['customer_name']; ?>
										</td>
										<td>
											<?php echo $row['stock_name']; ?>
										</td>
										<td>
											<?php echo $row['quantity']; ?>
										</td>
										<td>
											<?php echo $row['total_amount']; ?>
										</td>
										<td>
											<?php echo $row['transaction_date']; ?>
										</td>
									</tr>
									<?php
								}
								?>
							</table>
							<?php
						} else {
							echo "<p>Invalid customer ID. No transactions found.</p>";
						}
						?>
					</fieldset>
				<?php } ?>
				<br><br><br><br><br><br>
			</article>
			<footer class="clear">
				<p>&copy; WholeSale Business Managment by Gowrav,Jithesh and Deepak</p>
			</footer>
		</section>
		<div class="clear"></div>
	</section>
</body>

</html>