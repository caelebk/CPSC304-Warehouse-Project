<html>
<header>
        <title>Product Division</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </header>
    
    <body class="text-center">
    <h1 class='display-4 py-3 bg-dark text-light'> Product Division </h1>
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

            <h2>Division Query</h2>

            <h5>Find all products sold by all companys</h5>
            <hr />
            <form method="GET" action="product-division.php"> 
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            Select: DISTINCT P1.productName <br /><br />
            From: Product P1 <br /><br />
            Where: NOT EXISTS (SELECT B.companyName FROM Brand B) MINUS <br /><br />
            (SELECT P2.companyName 
            FROM Product P2 
            WHERE P2.productName = P1.productName)) <br /><br />
            <input type="submit" value="Submit" name="divisionQuery"></p>
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


        function handleDivisionRequest(){
            $query = "SELECT DISTINCT P1.productName FROM Product P1 WHERE NOT EXISTS (
                (SELECT B.companyName FROM Brand B) MINUS (
                    SELECT P2.companyName FROM Product P2 WHERE P2.productName = P1.productName
                )
            )";

            // ALL BRANDS - BRANDS = PRODUCT
            $result = executePlainSQL($query);
            printResult($result, array("Product Name"), "Division");
        }

        function printResult($result, $attributes, $name) { 
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

        function handleGETRequest(){
            if (connectToDB()) {
                if (array_key_exists('divisionQuery', $_GET)) {
                    handleDivisionRequest();
                }
                disconnectFromDB();
            }
        }
    
        if (isset($_GET['divisionRequest'])) {
            handleGETRequest();
        }
    
    
    
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>