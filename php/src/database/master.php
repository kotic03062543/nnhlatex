<?php
require_once 'connect.php';

// Get pp_users
function getUsers()
{
    global $conn;

    $sql = "SELECT * FROM pp_users";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

// ger pp_fresh_latex ราคาน้ำยางเเต่ละวัน
function getFreshLatexCategories()
{
    global $conn;

    $sql = "SELECT * FROM pp_fresh_latex ORDER BY create_date DESC";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    $categories = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    return $categories;
}

function insertFreshLatexCategory($price, $price_unit_eng, $price_unit_loc, $weight_unit_eng, $weight_unit_loc)
{
    global $conn;

    $sql = "INSERT INTO pp_fresh_latex (price, price_unit_eng, price_unit_loc, weight_unit_eng, weight_unit_loc, create_date) 
            VALUES ('$price', '$price_unit_eng', '$price_unit_loc', '$weight_unit_eng', '$weight_unit_loc', NOW())";

    $result = $conn->query($sql);

    if (!$result) {
        // An error occurred during insertion
        return $conn->error;
    }

    return 1; // No error
}

// update
function updateFreshLatexCategory($id, $price, $weight_unit_eng)
{
    global $conn;

    $sql = "UPDATE pp_fresh_latex SET price = '$price', weight_unit_eng = '$weight_unit_eng' WHERE id = $id";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }
}

// delete
function deleteFreshLatexCategory($id)
{
    global $conn;

    $sql = "DELETE FROM pp_fresh_latex WHERE id = $id";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }
}

// get by id
function getFreshLatexCategoryById($id)
{
    global $conn;

    $sql = "SELECT * FROM pp_fresh_latex WHERE id = $id";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    $category = $result->fetch_assoc();

    return $category;
}

function getFreshLatexCategoryLimit()
{
    global $conn;

    $sql = "SELECT * FROM pp_fresh_latex ORDER BY create_date DESC LIMIT 1";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        return $categories;
    } else {
        // Handle the case when no rows are returned
        return [];
    }
}

function SavePpPurchaseInfo($userId, $weighed, $percentage, $rubberDry, $priceTotal)
{
    global $conn;

    // Set the timezone to the one you desire
    date_default_timezone_set('Asia/Bangkok');

    // Get the current local timestamp
    $localTimestamp = date('Y-m-d H:i:s');

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO pp_purchase_info (user_id, weighed, percentage, rubber_dry, price_total, create_date) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssss", $userId, $weighed, $percentage, $rubberDry, $priceTotal, $localTimestamp);

        if ($stmt->execute()) {
            // Insertion successful
            $stmt->close();
            return 1;
        } else {
            // An error occurred during insertion
            $stmt->close();
            return "Error: " . $stmt->error;
        }
    } else {
        return "Error in prepared statement: " . $conn->error;
    }
}



function getPpPurchaseInfo($date)
{
    global $conn;

    // Escape the date value and enclose it in single quotes
    $escapedDate = $conn->real_escape_string($date);

    $sql = "SELECT pi.id, pi.weighed, pi.percentage, pi.rubber_dry, pi.price_total, pi.create_date, pu.username, pu.email
            FROM pp_purchase_info as pi
            INNER JOIN pp_users as pu
            ON pi.user_id = pu.id
            WHERE DATE(pi.create_date) = DATE('$escapedDate') 
            ORDER BY pi.create_date DESC";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    $purchaseInfo = [];

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $purchaseInfo[] = $row;
        }
    }

    return $purchaseInfo;
}

function getPpPurchaseInfoById($date, $id)
{
    global $conn;

    // Escape the date value and enclose it in single quotes
    $escapedDate = $conn->real_escape_string($date);
    $id = $conn->real_escape_string($id);

    $sql = "SELECT pi.id, pi.weighed, pi.percentage, pi.rubber_dry, pi.price_total, pi.create_date, pu.username, pu.email
            FROM pp_purchase_info as pi
            LEFT JOIN pp_users as pu
            ON pi.user_id = pu.id
            WHERE DATE(pi.create_date) = DATE('$escapedDate') 
            AND pi.id = $id
            ORDER BY pi.create_date DESC";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    $row = $result->fetch_assoc();

    return $row;
}


function getSumTotalLatex1Date($date)
{
    global $conn;

    $escapedDate = $conn->real_escape_string($date);

    $sql = "SELECT SUM(pui.weighed) as weighed,
                   SUM(pui.price_total) as price_total
            FROM `pp_purchase_info` as pui
            LEFT JOIN `pp_users` as pus
            ON pui.user_id = pus.id
            WHERE DATE(pui.create_date) = DATE('$escapedDate');";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }

    // Fetch the first (and only) row directly without looping
    $row = $result->fetch_assoc();

    // Free the result set
    $result->free();

    return $row;
}


// msg alert success & error ใช้ javascript แสดงผล
function sweetAlert($title, $text, $icon = 'success')
{
    echo "<script>
        Swal.fire({
            title: '$title',
            text: '$text',
            icon: '$icon',
            showCancelButton: false,
            confirmButtonText: 'OK'
        });
    </script>";
}

function sweetAlertWithRedirect($title, $message, $icon, $location)
{
    echo "<script>
            Swal.fire({
                title: '$title',
                text: '$message',
                icon: '$icon',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '$location';
                }
            });
          </script>";
}
