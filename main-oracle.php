<html>
    <head>
        <title> Warehouse Database Project </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class='text-center'>
        <h1 class='display-4 text-center py-3 bg-dark text-light'> Warehouse Database Project </h1>

        <a href="main-oracle.php"><button type="button" class="btn btn-secondary">Home</button></a>
        <a href="order-insert.php"><button type="button" class="btn btn-secondary">Order</button></a>
        <a href="product-insert.php"><button type="button" class="btn btn-secondary">Product</button></a>
        <hr />

        <h2>Reset</h2>
        <p>Reset/Intialize the Tables</p>

        <form method="POST" action="main-oracle.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset" class='btn btn-primary'></p>
        </form>
        <hr />

        <!-- <h2>Count the Tuples in Table</h2>
        <form method="GET" action="main-oracle.php">
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" value="Count"name="countTuples" class='btn btn-primary'></p>
        </form>
        <hr /> -->

        <h2>Display the Tuples in all Tables</h2>
        <form method="GET" action="main-oracle.php"> 
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" value="Display"name="displayTuples" class='btn btn-primary'></p>
        </form>
        <hr />

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr); 

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_ckoharjo", "a18539551", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        //ARGUMENTS: (SQL STATEMENT, ARRAY OF ATTRIBUTES, NAME OF RELATION)
        function printResult($result, $attributes, $name) { //prints results from a select statement
            $size = count($attributes);
            $header = "<tr>";
            foreach($attributes as $attr){
                $header = $header . "<th scope='col'>" . $attr . "</th>";
            }
            $header = $header . "</tr>";
            echo "<h5 class='text-decoration-underline'>". $name . " Table </h5>";
            echo "<table class='table table-bordered'>";
            echo $header;
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $temp = "<tr>";
                for($x = 0; $x < $size; $x++){
                    $temp = $temp . "<td>" . $row[$x] . "</td>";
                }
                $temp = $temp . "</tr>";
                echo $temp;
            }

            echo "</table>";
        }

        function printAll(){
            printResult(executePlainSQL("SELECT * FROM Customer"), array("Email", "CName", "Address"), "Customer");
            printResult(executePlainSQL("SELECT * FROM Employee"), array("EmployeeID", "EName"), "Employee");
            printResult(executePlainSQL("SELECT * FROM EmployeeParking"), array("Age", "ParkingSpot", "ExperienceLevel"), "EmployeeParking");
            printResult(executePlainSQL("SELECT * FROM Truck"), array("ParkingSpot", "TruckNumber"), "Truck");
            printResult(executePlainSQL("SELECT * FROM Driver"), array("Age", "ExperienceLevel", "EmployeeID"), "Driver");
            printResult(executePlainSQL("SELECT * FROM Packer"), array("EmployeeID", "BasketNum"), "Packer");
            printResult(executePlainSQL("SELECT * FROM GoesTo"), array("EmployeeID", "Email"), "GoesTo");
            printResult(executePlainSQL("SELECT * FROM PlaceOrder"), array("OrderID", "Email"), "Place-Order");
            printResult(executePlainSQL("SELECT * FROM Package"), array("PSize", "Stock"), "Package");
            printResult(executePlainSQL("SELECT * FROM Requires"), array("PSize", "OrderID", "Email"), "Requires");
            printResult(executePlainSQL("SELECT * FROM WorksOn"), array("OrderID", "Email", "EmployeeID"), "WorksOn");


            printResult(executePlainSQL("SELECT * FROM Category"), array("Title", "Location"), "Category");
            printResult(executePlainSQL("SELECT * FROM EmployeeProduct"), array("EmployeeID", "ProductID"), "EmployeeProduct");
            printResult(executePlainSQL("SELECT * FROM Brand"), array("CompanyName"), "Brand");
            printResult(executePlainSQL("SELECT * FROM Product"), array("ProductName", "CompanyName", "EmployeeID"), "Product");
            printResult(executePlainSQL("SELECT * FROM ProductStock"), array("ProductName", "Stock", "CompanyName"), "ProductStock");
            printResult(executePlainSQL("SELECT * FROM IsPartOf"), array("ProductID", "Title"), "IsPartOf");
        }


        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Customer cascade constraints");
            executePlainSQL("DROP TABLE Employee cascade constraints");
            executePlainSQL("DROP TABLE EmployeeParking");
            executePlainSQL("DROP TABLE Truck");
            executePlainSQL("DROP TABLE Driver");
            executePlainSQL("DROP TABLE Packer cascade constraints");
            executePlainSQL("DROP TABLE GoesTo");
            executePlainSQL("DROP TABLE PlaceOrder cascade constraints");
            executePlainSQL("DROP TABLE WorksOn");
            executePlainSQL("DROP TABLE Package cascade constraints");
            executePlainSQL("DROP TABLE Requires");
            executePlainSQL("DROP TABLE Category cascade constraints");
            executePlainSQL("DROP TABLE EmployeeProduct cascade constraints");
            executePlainSQL("DROP TABLE Brand cascade constraints");
            executePlainSQL("DROP TABLE Product");
            executePlainSQL("DROP TABLE ProductStock");
            executePlainSQL("DROP TABLE IsPartOf");

            //Create new tables
            echo "<br> Resetting/Creating new Tables</br>";

            //Order
            executePlainSQL("CREATE TABLE Customer (email CHAR(20) PRIMARY KEY, CName CHAR(20), address CHAR(50))");
            executePlainSQL("CREATE TABLE Employee (employeeID int PRIMARY KEY, EName CHAR(20))");
            executePlainSQL("CREATE TABLE EmployeeParking (age int, parkingSpot CHAR(3), experienceLevel CHAR(10),PRIMARY KEY (age, parkingSpot, experienceLevel))");
            executePlainSQL("CREATE TABLE Truck (parkingSpot CHAR(3), truckNumber int, PRIMARY KEY (parkingSpot))");
            executePlainSQL("CREATE TABLE Driver (age int, experienceLevel CHAR(10), employeeID int, FOREIGN KEY (employeeID) REFERENCES Employee ON DELETE CASCADE, PRIMARY KEY (age, experienceLevel))");
            executePlainSQL("CREATE TABLE Packer (employeeID int, basketNum int, FOREIGN KEY (employeeID) REFERENCES Employee ON DELETE CASCADE, PRIMARY KEY (employeeID))");
            executePlainSQL("CREATE TABLE GoesTo (employeeID int, email CHAR(20), PRIMARY KEY (employeeID, email), FOREIGN KEY (employeeID) REFERENCES Employee ON DELETE CASCADE, FOREIGN KEY (email) REFERENCES Customer ON DELETE CASCADE)");
            executePlainSQL("CREATE TABLE PlaceOrder (orderID int, email CHAR(20), PRIMARY KEY (orderID, email), FOREIGN KEY (email) REFERENCES Customer ON DELETE CASCADE)");
            executePlainSQL("CREATE TABLE Package (psize CHAR(10) PRIMARY KEY, stock int)");
            executePlainSQL("CREATE TABLE Requires (psize CHAR(10), orderID int, email CHAR(20), PRIMARY KEY (psize, orderID, email), FOREIGN KEY (psize) REFERENCES Package, FOREIGN KEY (orderID, email) REFERENCES PlaceOrder ON DELETE CASCADE)");
            executePlainSQL("CREATE TABLE WorksOn (orderID int, email CHAR(20), employeeID int, PRIMARY KEY (orderID, email, employeeID), FOREIGN KEY (employeeID) REFERENCES Employee ON DELETE CASCADE,FOREIGN KEY (orderID,email) REFERENCES PlaceOrder ON DELETE CASCADE)");

            //Product
            executePlainSQL("CREATE TABLE Category (title CHAR(20) PRIMARY KEY, location CHAR(3))");
            executePlainSQL("CREATE TABLE EmployeeProduct(employeeID int, productID int PRIMARY KEY, FOREIGN KEY (employeeID) REFERENCES Packer ON DELETE CASCADE)");
            executePlainSQL("CREATE TABLE Brand (companyName CHAR(30) PRIMARY KEY)");
            executePlainSQL("CREATE TABLE Product (productName CHAR(80), companyName CHAR(30) NOT NULL, employeeID int, PRIMARY KEY (productName, companyName, employeeID),FOREIGN KEY (employeeID) REFERENCES Packer ON DELETE CASCADE,FOREIGN KEY (companyName) REFERENCES Brand)");
            executePlainSQL("CREATE TABLE ProductStock (productName CHAR(80), stock int, companyName CHAR(30), PRIMARY KEY (productName, companyName), FOREIGN KEY (companyName) REFERENCES Brand)");
            executePlainSQL("CREATE TABLE IsPartOf (productID int, title CHAR(20), PRIMARY KEY(productID, title), FOREIGN KEY (productID) REFERENCES EmployeeProduct, FOREIGN KEY (title) REFERENCES Category)");
            
            OCICommit($db_conn);
        }

        //TODO: NOT IMPLEMENTED YET
        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM demoTable");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
            }
        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } 

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('displayTuples', $_GET)) {
                    printAll();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTupleRequest'])) {
            handleGETRequest();
        }
		?>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>