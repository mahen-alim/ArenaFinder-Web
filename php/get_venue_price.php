<?php
$host = "localhost";
$user = "tifz1761_root";
$pass = "tifnganjuk321";
$db = "tifz1761_arenafinder";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Tidak bisa terkoneksi");
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON data from the request body
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Check if the action is 'get_data'
    if ($requestData['action'] === 'get_data') {
        // Get the date from the request data
        $requestedDate = $requestData['date'];

        // Perform the SQL query to get data from venue_price based on the date
        $sql = "SELECT * FROM venue_price WHERE vp.date = '$requestedDate'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Fetch the data as an associative array
            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            // Return the data as JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            // If the query fails, return an error message with details
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to fetch data from venue_price.', 'mysqli_error' => mysqli_error($conn)]);
        }
    } else {
        // If the action is not 'get_data', return an error message
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid action.']);
    }
} else {
    // If the request method is not POST, return an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method.']);
}

// Close the database connection
mysqli_close($conn);

// // Check for a valid POST request with the correct action
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_data') {
//     // Get the date from the POST request
//     $date = $_POST['date'];

//     // Use prepared statement to prevent SQL injection
//     $query = "SELECT vp.*, v.sport, vb.payment_status
//               FROM venue_price vp
//               JOIN venues v ON vp.id_venue = v.id_venue
//               LEFT JOIN venue_booking vb ON vp.id_venue = vb.payment_status
//               WHERE vp.date=?";

//     $stmt = mysqli_prepare($conn, $query);
//     mysqli_stmt_bind_param($stmt, "s", $date);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);

//     // Check for errors
//     if (!$result) {
//         echo json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]);
//         exit;
//     }

//     // Fetch all data as an array
//     $data = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $data[] = $row;
//     }

//     // Return data as JSON response
//     header('Content-Type: application/json');
//     echo json_encode($data);
//     exit;
// } else {
//     // If it's not a valid POST request
//     echo json_encode(['error' => 'Invalid request']);
//     exit;
// }
?>