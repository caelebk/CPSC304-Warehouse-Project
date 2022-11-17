<html>
    <head>
        <title>Product Selection</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class = 'text-center'>
    <h1 class='display-4 text-center py-3 bg-dark text-light'> Product Selection </h1>
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

        <h2>Select Query</h2>

        <p>Must follow all SQL Syntax inside SELECT and WHERE textbox with existing attributes of the subset of 5 tables given and valid conditions (Includes AND).</p>
        <p>To select multiple attributes use ", " to separate. Leave the WHERE textbox empty if no conditions. For strings in the WHERE textbox, please use single quotations eg. cname = 'example@gmail.com'</p>
        <form method="GET" action="product-select.php"> 
            <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
            Select: <input type="text" name="Select"> <br /><br />
            From: <select name="Tables" id="Tables">
                    <option value="Category">Category</option>
                    <option value="EmployeeProduct">EmployeeProduct</option>
                    <option value="ProductStock">ProductStock</option>
                    <option value="Product">Product</option>
                    <option value="IsPartOf">IsPartOf</option>
                  </select><br /><br />
            Where: <input type="text" name="Where"> <br /><br />
            <input type="submit" value="select" name="selectQuery"></p>
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

        function handleSelectRequest(){
            global $db_conn;
            $select = $_GET["Select"];
            $from = $_GET["Tables"];
            $where = $_GET["Where"];

            $query = "SELECT " . $select . " FROM " . $from;
            if ($where != ""){
                $query = $query . " WHERE " . $where;
            }

            $result = executePlainSQL($query);

            echo "FULL SQL Query: " . $query;
            echo "<hr />";
            printResult($result, explode(", ", $select), "SELECTED " . $from);

        }

        function handleGETRequest(){
            if (connectToDB()) {
                if (array_key_exists('selectQuery', $_GET)) {
                    handleSelectRequest();
                }

                disconnectFromDB();
            }
        }

        if (isset($_GET['selectQueryRequest'])) {
            handleGETRequest();
        }

    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>
