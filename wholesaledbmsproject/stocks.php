<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $stockID = $_POST["StockID"];
  $stockName = $_POST["Name"]; // Retrieve the name from the form
  $quantity = $_POST["Quantity"];
  $pricePerUnit = $_POST["Price"];
  $expiryDate = $_POST["Date"];

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

  // Insert data into the database
  $sql = "INSERT INTO stocks (stock_id, name, quantity, price_per_unit, expiry_date) 
            VALUES ('$stockID', '$stockName', '$quantity', '$pricePerUnit', '$expiryDate')";

  if ($conn->query($sql) === TRUE) {
    echo "New stock added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
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
  <title>stocks</title>
  <link rel="stylesheet" href="styles.css" type="text/css">
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
          <li class="selected-item"><a href="stocks.php">New stocks</a></li>
          <li><a href="updatingstocks.php">Print Bill</a></li>
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

        <!--	<a href="#" class="button">Read more</a>
        <a href="#" class="button button-reversed">Comments</a> -->
        <!--IN THIS FIELD WE CAN ADD THE CUSTOMER..-->
        <fieldset>
          <!--YOU NEED TO WRITE AN ACTION HERE...-->
          <legend><strong>NEW-STOCKS</strong></legend>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <p><label for="StockID">Stock-ID:</label>
              <input type="text" name="StockID" id="StockID" value="" required /><br />
            </p>

            <!-- Add a new input field for the stock name -->
            <p>
              <label for="Name">Stock Name:</label>
              <input type="text" name="Name" id="Name" value="" required /><br />
            </p>


            <p><label for="Quantity">Quantity:</label>
              <input type="text" name="Quantity" id="Quantity" value="" required /><br />
            </p>

            <p><label for="Price">Price-Per-Unit:</label>
              <input type="text" name="Price" id="Price" value="" required /><br />
            </p>

            <p><label for="Date">Expiry-Date:</label>
              <input type="date" name="Date" id="Date" value="" required /><br />
            </p>

            <p><input type="submit" name="send" class="formbutton" value="Send" /></p>
          </form>



        </fieldset>
        <br> <br> <br> <br> <br> <br> <br><br><br><br>

      </article>

      <footer class="clear">
        <p>&copy; WholeSale Business Managment by Gowrav,Jithesh and Deepak</p>
      </footer>

    </section>

    <div class="clear"></div>

  </section>


</body>

</html>