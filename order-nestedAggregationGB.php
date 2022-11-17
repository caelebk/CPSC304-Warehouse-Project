<html>
    <header>
    <title>Order Nested Aggregation with Group By</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </header>
    <body class = 'text-center'>
    <h1 class='display-4 text-center py-3 bg-dark text-light'> Order Nested Aggregation with Group By </h1>
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

        <h5>For each group of drivers with the same number of years of experience, what is the youngest age in each group (assuming a group has at least 2 individuals)? </h5>
        <form method="GET" action="order-nestedAggregationGB.php"> 
            <input type="hidden" id="nestedQueryRequest" name="nestedQueryRequest">
            Select: d1.experienceLevel, MIN(d1.age) <br /><br />
            From: Driver d1 <br /><br />
            GroupBy: d1.experienceLevel <br /><br />
            Having: 1 < (SELECT COUNT(*) FROM Driver d2 WHERE d1.experienceLevel = d2.experienceLevel) <br /> <br />
            <input type="submit" value="Submit" name="nestedQuery"></p>
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



        function handleNestedRequest(){
            $query = "SELECT d1.experienceLevel, MIN(d1.age) FROM Driver d1 GROUP BY d1.experienceLevel HAVING 1 < (SELECT COUNT(*) FROM Driver d2 WHERE d1.experienceLevel = d2.experienceLevel)";
            $result = executePlainSQL($query);
            printResult($result, array("ExperienceLevel", "Age"), "Nested Aggregation");
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
                if (array_key_exists('nestedQuery', $_GET)) {
                    handleNestedRequest();
                }

                disconnectFromDB();
            }
        }

        if (isset($_GET['nestedQueryRequest'])) {
            handleGETRequest();
        }

        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>