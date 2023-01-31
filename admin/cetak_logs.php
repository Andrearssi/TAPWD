<?php
session_start();
if (!$_SESSION['status']) {
    header("location: ../login.php");
    die;
}

// memanggil library FPDF
require('fpdf/fpdf.php');


// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('l', 'mm', 'A5');
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 16);

// mencetak string
$pdf->Cell(190, 7, 'LOGS', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 7, 'EDIT CONTENT', 0, 1, 'C');

// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 7, '', 0, 1);

$left = 25;


//Cetak kepala table
$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetX($left);
$pdf->Cell(15, 6, 'NO', 1, 0, 'C');
$pdf->Cell(30, 6, 'USER', 1, 0, 'C');
$pdf->Cell(30, 6, 'TABEL', 1, 0, 'C');
$pdf->Cell(30, 6, 'ACTION', 1, 0, 'C');
$pdf->Cell(50, 6, 'TIME EDIT', 1, 1, 'C');
$pdf->SetFont('Arial', '', 11);

//koneksi
include '../connection.php';
//mengambil id dari url

$sql = "SELECT * FROM logs ORDER BY id DESC";

$jadwal = mysqli_query($conn, $sql);
$no = 1;
while ($row = mysqli_fetch_array($jadwal)) {
    $pdf->SetX($left);
    $pdf->Cell(15, 6, $no++, 1, 0);
    $pdf->Cell(30, 6, $row['user'], 1, 0);
    $pdf->Cell(30, 6, $row['tabel'], 1, 0);
    $pdf->Cell(30, 6, $row['action'], 1, 0);
    $pdf->Cell(50, 6, $row['time_edit'], 1, 1);;
}
$pdf->Output();
