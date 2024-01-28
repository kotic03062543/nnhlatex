<?php
$host = 'db';
$user = 'root';
$password = 'root';
$db = 'ltnnh';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    echo 'connection failed: ' . $conn->connect_error;
} else {
    // echo 'Successfully connected to MySQL';
}

// $sql = 'SELECT * FROM pp_users';
// $result = $conn->query($sql);
// if (!$result) {
//     echo 'Query error: ' . $conn->error;
// } elseif ($result->num_rows > 0) {
//     echo '<ul>';
//     while ($row = $result->fetch_assoc()) {
//         // ตรวจสอบก่อนที่จะใช้ค่าใน $row
//         if (isset($row['id'])) {
//             echo '<li>' . $row['id'] . '</li>';
//         } else {
//             echo '<li>Undefined id</li>';
//         }
//     }
//     echo '</ul>';
// } else {
//     echo '0 results';
// }


// $sql = 'SELECT * FROM pp_users';
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     echo '<ul>';
//     while ($row = $result->fetch_assoc()) {
//         echo '<li>' . $row['name'] . '</li>';
//     }
//     echo '</ul>';
// } else {
//     echo '0 results';
// }

?>
