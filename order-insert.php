<html>
    <head>
        <title>Order Insertions</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class = 'text-center'>
        <h1 class='display-4 text-center py-3 bg-dark text-light'> Order Insertions </h1>
        <a href="main-oracle.php"><button type="button" class="btn btn-secondary">Home</button></a>
        <a href="order-insert.php"><button type="button" class="btn btn-secondary">Order</button></a>
        <a href="product-insert.php"><button type="button" class="btn btn-secondary">Product</button></a>
        <hr />
        <a href="order-insert.php"><button type="button" class="btn btn-secondary">Insert</button></a>
        <a href="order-delete.php"><button type="button" class="btn btn-secondary">Delete</button></a>
        <a href="order-update.php"><button type="button" class="btn btn-secondary">Update</button></a>
        <a href="order-select.php"><button type="button" class="btn btn-secondary">Select</button></a>
        <a href="order-join.php"><button type="button" class="btn btn-secondary">Join</button></a>
        <a href="order-nestedAggregationGB.php"><button type="button" class="btn btn-secondary">Nested Aggregation with Group By</button></a>
        <hr />

        <h2 class>Insert Values into Customer Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertCustomerRequest" name="insertCustomerRequest">
            Email: <input type="text" name="Email"> <br /><br />
            Name: <input type="text" name="Cname"> <br /><br />
            Address: <input type="text" name="Address"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into Employee Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertEmployeeRequest" name="insertEmployeeRequest">
            EmployeeID: <input type="text" name="EID"> <br /><br />
            Name: <input type="text" name="Ename"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into EmployeeParking Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertEmployeeParkingRequest" name="insertEmployeeParkingRequest">
            Age: <input type="text" name="Age"> <br /><br />
            Parking Spot: <input type="text" name="Pspot"> <br /><br />
            Years of Experience: <input type="text" name="Experience"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into Truck Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertTruckRequest" name="insertTruckRequest">
            Parking Spot: <input type="text" name="Pspot"> <br /><br />
            Truck Number: <input type="text" name="TruckNum"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into Driver Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertDriverRequest" name="insertDriverRequest">
            Age: <input type="text" name="Age"> <br /><br />
            Years of Experience: <input type="text" name="Experience"> <br /><br />
            (FOREIGN KEY) EmployeeID: <input type="text" name="EID"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into Packer Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertPackerRequest" name="insertPackerRequest">
            (FOREIGN KEY) EmployeeID: <input type="text" name="EID"> <br /><br />
            Basket Number: <input type="text" name="Bnum"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into GoesTo Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertGoesToRequest" name="insertGoesToRequest">
            (FOREIGN KEY) EmployeeID: <input type="text" name="EID"> <br /><br />
            (FOREIGN KEY) Customer Email: <input type="text" name="Email"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into PlaceOrder Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertPlaceOrderRequest" name="insertPlaceOrderRequest">
            Order ID: <input type="text" name="OID"> <br /><br />
            (FOREIGN KEY) Customer Email: <input type="text" name="Email"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into Package Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertPackageRequest" name="insertPackageRequest">
            Size: <input type="text" name="Size"> <br /><br />
            Stock: <input type="text" name="Stock"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into Requires Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertRequiresRequest" name="insertRequiresRequest">
            (FOREIGN KEY) Size: <input type="text" name="Size"> <br /><br />
            (FOREIGN KEY) Order ID: <input type="text" name="OID"> <br /><br />
            (FOREIGN KEY) Customer Email: <input type="text" name="Email"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>

        <hr />
        <h2 class>Insert Values into WorksOn Table</h2>
        <form method="POST" action="order-insert.php"> 
            <input type="hidden" id="insertWorksOnRequest" name="insertWorksOnRequest">
            (FOREIGN KEY) Order ID: <input type="text" name="OID"> <br /><br />
            (FOREIGN KEY) Customer Email: <input type="text" name="Email"> <br /><br />
            (FOREIGN KEY)Employee ID: <input type="text" name="EID"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>


    </body>
    <?php
        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False;


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


        function handleInsertRequest($tuple, $table) {
            global $db_conn;

            $query = "insert into " . $table . " values (";
            $count = 0;
            $size = count($tuple);
            foreach($tuple as $key => $val) {
                if($count == $size-1){
                    $query = $query . $key . ")";
                    break;
                }
                $query = $query . $key . ", ";
                $count++;
            }

            $alltuples = array (
                $tuple
            );
            
            executeBoundSQL($query, $alltuples);
            OCICommit($db_conn);
        }

        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('insertCustomerRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Email'], ":bind2" => $_POST['Cname'], ":bind3" => $_POST['Address']), "Customer");
                } else if (array_key_exists('insertEmployeeRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['EID'], ":bind2" => $_POST['Ename']), "Employee");
                } else if (array_key_exists('insertEmployeeParkingRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Age'], ":bind2" => $_POST['Pspot'], ":bind3" => $_POST['Experience']), "EmployeeParking");
                } else if (array_key_exists('insertTruckRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Pspot'], ":bind2" => $_POST['TruckNum']), "Truck");
                } else if (array_key_exists('insertDriverRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Age'], ":bind2" => $_POST['Experience'], ":bind3" => $_POST['EID']), "Driver");
                } else if (array_key_exists('insertPackerRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['EID'], ":bind2" => $_POST['Bnum']), "Packer");
                } else if (array_key_exists('insertGoesToRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['EID'], ":bind2" => $_POST['Email']), "GoesTo");
                } else if (array_key_exists('insertPlaceOrderRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['OID'], ":bind2" => $_POST['Email']), "PlaceOrder");
                }else if (array_key_exists('insertPackageRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Size'], ":bind2" => $_POST['Stock']), "Package");
                } else if (array_key_exists('insertRequiresRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Size'], ":bind2" => $_POST['OID'], ":bind3" => $_POST['Email']), "Requires");
                }else if (array_key_exists('insertWorksOnRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['OID'], ":bind2" => $_POST['Email'], ":bind3" => $_POST['EID']), "WorksOn");
                }

                disconnectFromDB();
            }
        }

        if (isset($_POST['insertSubmit'])) {
            handlePOSTRequest();
        }

    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>
