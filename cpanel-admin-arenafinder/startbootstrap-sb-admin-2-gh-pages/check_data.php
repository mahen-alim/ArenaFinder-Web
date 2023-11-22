<?php
// get_venue_membership_data.php

// Connect to your database (replace these values with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "arenafinder";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform a query to check for new data in the venue_membership table
$sql = "SELECT * FROM venue_membership ORDER BY created_at DESC";

$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Output the number of rows
    echo $result->num_rows;

    // Fetch and output the data
    while ($row = $result->fetch_assoc()) {
        // Output your data here, for example:
        // echo $row['column_name'];
    }

    // Free the result set
    $result->free();
} else {
    // Output an error message if the query fails
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();

?>