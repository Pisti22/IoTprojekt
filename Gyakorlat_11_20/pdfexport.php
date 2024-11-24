<?php

require('fpdf186/fpdf.php');

// Valtozok ----------------------------
$cellwidth = 12;
$cellheight = 10;
$datecellwidth = 20;
$titlefontsize = 24;
$tablefontsize = 5;
// -------------------------------------


$connect = mysqli_connect("localhost", "root", "", "adatbazis");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql1 = "SELECT DISTINCT datum FROM hisztorikus WHERE register_id=3028";
$datum_result = mysqli_query($connect, $sql1);


$pdf = new FPDF();
$pdf->AddPage();

// Kep beszurasa
$pdf->Image('meter.png',7, 7, -500);


$pdf->SetFont('Helvetica', 'B', $titlefontsize);
$pdf->SetTextColor(59, 106, 120);


$pdf->Cell(0, 10, 'Hisztorikus Adatok Export PDF', 0, 1, 'C');
$pdf->Ln();
$pdf->Ln();



$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell($datecellwidth, $cellheight, 'Datum', 1);
$pdf->Cell($cellwidth, $cellheight, 'U1', 1);
$pdf->Cell($cellwidth, $cellheight, 'U2', 1);
$pdf->Cell($cellwidth, $cellheight, 'U3', 1);
$pdf->Cell($cellwidth, $cellheight, 'I1', 1);
$pdf->Cell($cellwidth, $cellheight, 'I2', 1);
$pdf->Cell($cellwidth, $cellheight, 'I3', 1);
$pdf->Cell($cellwidth, $cellheight, 'P', 1);
$pdf->Cell($cellwidth, $cellheight, 'Q', 1);
$pdf->Cell($cellwidth, $cellheight, 'S', 1);
$pdf->Cell($cellwidth, $cellheight, 'f', 1);
$pdf->Cell($cellwidth, $cellheight, 'IEC', 1);
$pdf->Cell($cellwidth, $cellheight, 'P', 1);
$pdf->Cell($cellwidth, $cellheight, 'Q', 1);
$pdf->Cell($cellwidth, $cellheight, 'S', 1);
$pdf->Ln();


$pdf->SetFont('Helvetica', '', $tablefontsize);
$pdf->SetTextColor(0,0,0);


if ($datum_result) {
    while($row = mysqli_fetch_assoc($datum_result)) {
        $date = $row["datum"];
        
        
        $sql2 = "SELECT meres FROM hisztorikus WHERE datum = ?";
        $stmt = $connect->prepare($sql2);
        $stmt->bind_param("s", $date);  
        $stmt->execute();
        $adat_result = $stmt->get_result();
 
        
        $adatok = [$date];
        
        $i = 0;
        while($row2 = $adat_result->fetch_assoc()) {
            if ($i < 14) {
                $adatok[] = $row2['meres'];
                $i++;
            } else {
                break;
            }
        }
        
        
        while (count($adatok) < 15) {
            $adatok[] = '';  
        }
        
        
        $pdf->Cell($datecellwidth, $cellheight, $adatok[0], 1);  // Elso cella szelessege: datecellwidth
        for ($j = 1; $j < count($adatok); $j++) {
            $pdf->Cell($cellwidth, $cellheight, $adatok[$j], 1);  // Tobbi cella szelessege: cellwidth
        }
        $pdf->Ln();  
    }
} else {
    echo "Error in date query: " . mysqli_error($connect);
}


mysqli_close($connect);

// Output a PDF-nek, letoltes
$pdf->Output('D', 'hisztorikus_adatok_export.pdf');
?>
