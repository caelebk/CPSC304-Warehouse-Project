<html>
    <header>
        <title>Product Insertion</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </header>
    <body class ='text-center'>
        <h1 class='display-4 text-center py-3 bg-dark text-light'> Product Insertion </h1>
        <a href="main-oracle.php"><button type="button" class="btn btn-secondary">Home</button></a>
        <a href="order-insert.php"><button type="button" class="btn btn-secondary">Order</button></a>
        <a href="product-insert.php"><button type="button" class="btn btn-secondary">Product</button></a>
        <hr />
        <a href="product-insert.php"><button type="button" class="btn btn-secondary">Insert</button></a>
        <a href="product-select.php"><button type="button" class="btn btn-secondary">Select</button></a>
        <a href="product-AggregationGB.php"><button type="button" class="btn btn-secondary">Aggregation with Group By</button></a>
        <a href="product-AggregationHaving.php"><button type="button" class="btn btn-secondary">Aggregation with Having</button></a>
        <a href="product-division.php"><button type="button" class="btn btn-secondary">Division</button></a>
        <hr />

        <h2 class>Insert Values into Category Table</h2>
        <form method="POST" action="product-insert.php"> 
            <input type="hidden" id="insertCategoryRequest" name="insertCategoryRequest">
            Title: <input type="text" name="Title"> <br /><br />
            Location: <input type="text" name="Location"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>
        <hr />
        <h2 class>Insert Values into EmployeeProduct Table</h2>
        <form method="POST" action="product-insert.php"> 
            <input type="hidden" id="insertEmployeeProductRequest" name="insertEmployeeProductRequest">
            (FOREIGN KEY) Employee ID: <input type="text" name="EID"> <br /><br />
            Product ID: <input type="text" name="PID"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>
        <hr />
        <h2 class>Insert Values into Brand Table</h2>
        <form method="POST" action="product-insert.php"> 
            <input type="hidden" id="insertBrandRequest" name="insertBrandRequest">
            Company Name: <input type="text" name="Cname"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>
        <hr />
        <h2 class>Insert Values into ProductStock Table</h2>
        <form method="POST" action="product-insert.php"> 
            <input type="hidden" id="insertProductStockRequest" name="insertProductStockRequest">
            Product Name: <input type="text" name="Pname"> <br /><br />
            Stock: <input type="text" name="Stock"> <br /><br />
            (FOREIGN KEY) Company Name: <input type="text" name="Cname"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>
        <hr />
        <h2 class>Insert Values into Product Table</h2>
        <form method="POST" action="product-insert.php"> 
            <input type="hidden" id="insertProductRequest" name="insertProductRequest">
            (FOREIGN KEY) Product Name: <input type="text" name="Pname"> <br /><br />
            (FOREIGN KEY) Company Name: <input type="text" name="Cname"> <br /><br />
            (FOREIGN KEY) Employee ID: <input type="text" name="EID"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>
        <hr />
        <h2 class>Insert Values into IsPartOf Table</h2>
        <form method="POST" action="product-insert.php"> 
            <input type="hidden" id="insertIsPartOfRequest" name="insertIsPartOfRequest">
            (FOREIGN KEY) Product ID: <input type="text" name="PID"> <br /><br />
            (FOREIGN KEY) Category Title: <input type="text" name="Title"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit" class='btn btn-primary'></p>
        </form>


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
                if (array_key_exists('insertCategoryRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Title'], ":bind2" => $_POST['Location']), "Category");
                } else if (array_key_exists('insertEmployeeProductRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['EID'], ":bind2" => $_POST['PID']), "EmployeeProduct");
                } else if (array_key_exists('insertProductStockRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Pname'], ":bind2" => $_POST['Stock'], ":bind3" => $_POST['Cname']), "ProductStock");
                } else if (array_key_exists('insertBrandRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Cname']), "Brand");
                } else if (array_key_exists('insertProductRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['Pname'], ":bind2" => $_POST['Cname'], ":bind3" => $_POST['EID']), "Product");
                } else if (array_key_exists('insertIsPartOfRequest', $_POST)) {
                    handleInsertRequest(array(":bind1" => $_POST['PID'], ":bind2" => $_POST['Title']), "IsPartOf");
                } 

                disconnectFromDB();
            }
        }

        if (isset($_POST['insertSubmit'])) {
            handlePOSTRequest();
        }
        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>