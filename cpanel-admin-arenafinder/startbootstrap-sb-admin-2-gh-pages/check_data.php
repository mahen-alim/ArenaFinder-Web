<?php
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
// Check if the form is submitted with the Konfirmasi button
if (isset($_GET['membershipId'])) {
    $membershipId = $_GET['membershipId'];

    // Perform the deletion using prepared statements to avoid SQL injection
    $query = "DELETE FROM venue_membership WHERE id_membership = ?";
    $stmt = $conn->prepare($query);

    // Bind the parameter
    $stmt->bind_param("i", $membershipId);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        // Redirect back to the original page after deletion
        header("Location: pesanan.php");
        exit();
    } else {
        echo "Error deleting membership" . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Check if the form is submitted with the Batalkan button
elseif (isset($_POST['cancelButton'])) {
    // You can add additional logic here if needed
    echo "Cancel button clicked";

    // Fetch the updated count after canceling
    $countQuery = "SELECT COUNT(*) AS count FROM venue_membership";
    $countResult = mysqli_query($conn, $countQuery);

    if ($countResult) {
        $rowCount = mysqli_fetch_assoc($countResult)['count'];
        echo json_encode(['count' => $rowCount]);
    } else {
        echo json_encode(['error' => 'Error fetching updated count']);
    }
}

// Close the database connection
$conn->close();
?>