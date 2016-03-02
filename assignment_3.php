<?php

// This is the hostname or IP of the database server.
// Since we are using MySQL running on the same computer as your
// PHP code, you would use either 127.0.0.1 or localhost.  Both
// are reserved in the IP protocol to refer to this system (the local computer).
$db_hostname = '127.0.0.1';
$db_username = 'root';
$db_password = 'admin';
$db_database = 'classicmodels';

$mysql_connection = @new mysqli($db_hostname, $db_username, $db_password, $db_database);

// Make sure that the connection to the MySQL database is ok.
if ($mysql_connection->connect_errno) {
    printf("Failed to connect to the MySQL database server: %s\n", $mysql_connection->connect_error);
    exit(1);
}

// Perform a SELECT query using the object-oriented mysqli interface.
// http://php.net/manual/en/mysqli.query.php
//
// For your query, you will need to join the customers and employees
// tables together.
$query_result = $mysql_connection->query("SELECT `customerName`,`country`,`lastName`,`firstName`
                                          FROM `customers`,`employees`
                                          WHERE `salesRepEmployeeNumber` = `employeeNumber` ORDER BY `country` ASC ");
// Make sure there wasn't an error with the query.
if ($query_result !== false) {
    while($row_array = $query_result->fetch_assoc()) {
        // Your output goes here
        echo $row_array['customerName'] . " " . ", " . $row_array['country'] . " - " . $row_array['firstName']
            . " " .$row_array['lastName'] . ".\n";
    }
    $number_people = $query_result->num_rows;
    // We're done with the query result set, so free it.
    // This frees up the memory the result set object was using.
    // http://php.net/manual/en/mysqli-result.free.php
    $query_result->free();
} else {
    // http://php.net/manual/en/mysqli.error.php
    echo "The query failed: $mysql_connection->error\n";
    exit(2);
}
// We're all done with the MySQL connection so close it.
// http://php.net/manual/en/mysqli.close.php
$mysql_connection->close();
