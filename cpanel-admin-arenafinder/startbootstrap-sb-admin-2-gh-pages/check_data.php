<?php
session_start();

$userLevel = '';
if (isset($_SESSION['level'])) {
    // Jika level sudah di-set di session, gunakan nilainya
    $userLevel = $_SESSION['level'];
}

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

// Check if the form is submitted with the Konfirmasi button
if (isset($_GET['membershipId'])) {
    $membershipId = $_GET['membershipId'];

    if ($userLevel === "ADMIN") {
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
                $query = "UPDATE venue_booking SET payment_status = 'Rejected' WHERE id_booking = $membershipId";
                $result = $conn->query($query);

                // Check if the query was successful
                if ($result) {

                    // SEND NOTIFICATION
                    $notif = new Notification();

                    $sql = "SELECT device_token, COUNT(*) AS count FROM session WHERE email = '$email' GROUP BY device_token;";
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
                                $body = "Pesanan booking lapangan Anda telah kami tolak.";
                                $data = [
                                    "key1" => "data1",
                                    "key2" => "data2"
                                ];

                                $status = $notif->sendNotif($deviceToken, $title, $body, $data);
                            }
                            $_SESSION['pesan_alert'] = "Pesanan dari $nama telah dibatalkan.";
                        } else {
                            echo "Tidak ada data device_token.";
                        }
                    } else {
                        echo "Perintah gagal dijalankan: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                // Handle the case where no row is returned
                echo "No data found for the specified id_booking.";
            }
        }

        if ($result) {
            // Redirect back to the original page after rejection
            header("Location: pesanan.php");
            exit();
        } else {
            echo "Error rejecting booking" . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo 'Anda super admin, tidak dapat membatalkan pesanan.';
    }
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
?>