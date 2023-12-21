<?php
session_start();

require '../controllers/mobile/notification/Notification.php';

$servername = "localhost";
$username = "tifz1761_root";
$password = "tifnganjuk321";
$dbname = "tifz1761_arenafinder";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform a query to check for new data in the venue_membership table
$sql = "SELECT * FROM venue_booking ORDER BY created_at DESC";
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

    // get data email 
    $query = "SELECT email FROM venue_booking WHERE id_booking = $membershipId";
    $result = $conn->query($query);

    if ($result) {
        // Fetch the email data
        $row = $result->fetch_assoc();

        // Check if any row is returned
        if ($row) {
            // Access the email value
            $email = $row['email'];

            // GET DATA USER
            $query = "SELECT full_name FROM users WHERE email = '$email'";
            $dataUser = $conn->query($query);
            $rowUser = $dataUser->fetch_assoc();
            $nama = $rowUser['full_name'];

            // UPDATE STATUS PESANAN 
            $query = "UPDATE venue_booking SET payment_status = 'Accepted' WHERE id_booking = $membershipId";
            $result = $conn->query($query);

            // // Check if the query was successful
            if ($result) {

                // SEND NOTIFICATION
                $notif = new Notification();

                $sql = "SELECT device_token, COUNT(*) AS count FROM session WHERE email = '$email' GROUP BY device_token ORDER BY created_at DESC;";
                $result = mysqli_query($conn, $sql);

                $deviceTokens = array();

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {

                        // mendapatkan data device token
                        while ($row = mysqli_fetch_assoc($result)) {
                            $deviceTokens[] = $row['device_token'];
                        }

                        // mengirim notifikasi
                        foreach ($deviceTokens as $deviceToken) {

                            $title = "Halo, $nama";
                            $body = "Pesanan booking lapangan Anda telah kami terima.";
                            $data = [
                                "key1" => "data1",
                                "key2" => "data2"
                            ];

                            $status = $notif->sendNotif($deviceToken, $title, $body, $data);
                        }
                        $_SESSION['pesan_confirm'] = "Pesanan dari $nama telah dikonfirmasi.";
                    } else {
                        echo "Tidak ada data device_token.";
                    }
                } else {
                    echo "Perintah gagal dijalankan: " . mysqli_error($conn);
                }
            } else {
                echo "Error: " . $conn->error;
            }

            // Now you can use $email as needed
            echo "Email: " . $email;
        } else {
            // Handle the case where no row is returned
            echo "No data found for the specified id_booking.";
        }
    }

    // Perform the deletion using prepared statements to avoid SQL injection
    $query = "UPDATE venue_membership SET nama = 'Awokawokawok' WHERE id_membership = $membershipId";
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
    $countQuery = "SELECT COUNT(*) AS count FROM venue_booking";
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
