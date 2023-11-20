<?php
require('fpdf/fpdf.php');
include('../jovit_connection.php');

// Select data from MySQL database
$select = "SELECT * FROM `tbl_jovit` ORDER BY id";
$result = $conn->query($select);

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);

class PDF extends FPDF {
    // Page header
    function Header() {
        $this->SetFont('Arial','B',12);
        $this->SetFillColor(91,96,104);
        $this->SetTextColor(255);

        // Header
        $this->Cell(12,10,'ID',1,0,'C',true);
        $this->Cell(40,10,'First Name',1,0,'C',true);
        $this->Cell(40,10,'Last Name',1,0,'C',true);
        $this->Cell(25,10,'Gender',1,0,'C',true);
        $this->Cell(30,10,'Birthday',1,0,'C',true);
        $this->Cell(120,10,'Address',1,0,'C',true);
        


        // Line break
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,10,'Page '.$this->PageNo().' out of {nb}',0,0,'C');
    }
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(255);
$idNumber = 0; // Start ID count from 0
while($row = $result->fetch_object()) {
    $idNumber++; // Increment the ID count

    $id = $idNumber; // Use $idNumber directly as the ID
    $firstName = $row->firstName;
    $lastName = $row->lastName;
    $gender = $row->gender;
    $birthday = $row->birthDate;
    $address = $row->address;


    $pdf->SetFillColor($id % 2 == 0 ? 44 : 22, $id % 2 == 0 ? 62 : 160, $id % 2 == 0 ? 80 : 133);


    $pdf->Cell(12,10,$id,1,0,'C',true);
    $pdf->Cell(40,10,$firstName,1,0,'C',true);
    $pdf->Cell(40,10,$lastName,1,0,'C',true);
    $pdf->Cell(25,10,($gender) == '0' ? "Male" : "Female",1,0,'C',true);
    $pdf->Cell(30,10,($birthday),1,0,'C',true);
    $pdf->Cell(120,10,$address,1,0,'C',true);

    $pdf->Ln();
}

$pdf->Output();
?>