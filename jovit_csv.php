<?php 

include('../jovit_connection.php');
 
// Fetch records from database 
$query = $conn->query("SELECT * FROM tbl_jovit ORDER BY id ASC"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('ID', 'First Name', 'Last Name', 'Birthday', 'Address', 'Gender'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $gender = ($row['gender'] == 0)?'Male':'Female';
         
        $lineData = array($row['id'], $row['firstName'], $row['lastName'], $row['birthDate'], $row['address'],  $gender); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    
    fpassthru($f); 
} 
exit; 
 
?>