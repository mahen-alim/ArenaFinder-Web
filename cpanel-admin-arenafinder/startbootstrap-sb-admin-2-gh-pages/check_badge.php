<?php
session_start();
include('database.php');

// Perform a query to check for new data in the venue_membership table
$sql = "SELECT id_booking, id_venue, total_price, payment_method, payment_status, date_confirmed, membership, created_at
        FROM venue_booking
        WHERE payment_status = 'Pending' AND id_venue = '$_SESSION[id_venue]'
        ORDER BY created_at DESC";
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

// Tutup koneksi
$conn->close();
?>