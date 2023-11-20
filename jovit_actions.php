<?php

session_start(); // Start the session
include "../jovit_connection.php";


// insert data
if (isset($_POST['saveBtn'])) {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $birthDate = mysqli_real_escape_string($conn, $_POST['birthDate']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $depId = mysqli_real_escape_string($conn, $_POST['department']);

$query = "INSERT INTO tbl_jovit (firstName, lastName, gender, birthDate, address, departmentId) 
          VALUES ('$firstName', '$lastName', '$gender', '$birthDate', '$address', '$depId')";


if ($conn->query($query) === TRUE) {
    // Data Inserted Successfully
    header('location: jovit_index2.php');
    echo "<script>
            $(document).ready(function() {
                $('#userTable1').DataTable().ajax.reload();
            });
          </script>";
} else {
    // Handle insertion error
    echo "Error: " . $query . "<br>" . $conn->error;
}
}




// edit data
// Edit data
if (isset($_POST['editBtn'])) {
    $id = $_POST['userId'];
    $arrayResult = [];

    $fetchQuery = "SELECT * FROM tbl_jovit WHERE id='$id'";
    $queryRun = mysqli_query($conn, $fetchQuery);

    if (mysqli_num_rows($queryRun) > 0) {
        while ($row = mysqli_fetch_array($queryRun)) {
            array_push($arrayResult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayResult);
        exit(); // Ensure to exit after sending the response
    }
}

//update data
if (isset($_POST['updateBtn'])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birthDate'];
    $address = $_POST['address'];
    $depId = $_POST['department'];

    $tblUpdate = "UPDATE tbl_jovit SET firstName='$firstName', lastName='$lastName', birthDate='$birthDate',
                 address='$address', gender='$gender', departmentId='$depId' WHERE id='$id' ";

    $tblUpdateQuery = mysqli_query($conn, $tblUpdate);

    if ($tblUpdateQuery) {
        $_SESSION['status'] = "Data Updated Successfully";
        header('location: jovit_index2.php');
    } else {
        $_SESSION['status'] = "Data Failed! " . mysqli_error($conn);
        header('location: jovit_index2.php');
    }
}

//delete
if(isset($_GET['id'])) {
    $id = $_GET['id']; // Change 'user_id' to 'id' to match the GET parameter

    // Check if the deleteBtn parameter is set and equals 'true'
    if(isset($_GET['deleteBtn']) && $_GET['deleteBtn'] === 'true') {
        $deleteQuery = "DELETE FROM tbl_jovit WHERE id='$id'";
        $deleteQueryRun = mysqli_query($conn, $deleteQuery);

        if($deleteQueryRun) {
            // echo json_encode(array("message" => "Deleted Successfully"));
            header('location: jovit_index2.php');
            exit(); // To prevent further execution after redirection
        } else {
            // echo json_encode(array("message" => "Deletion failed"));
            header('location: jovit_index2.php');
            exit(); // To prevent further execution after redirection
        }
    }
}
