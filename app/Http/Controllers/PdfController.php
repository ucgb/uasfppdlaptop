<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Post;


class PdfController extends Controller
{

    public function pdf(Fpdf $pdf)
    {

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 18);

        $pdf->MultiCell(0, 10, 'Pendataan Laptop', 0, 'C');
        $pdf->MultiCell(0, 10, 'Daftar Laptop', 0, 'C');
        $pdf->Ln();
        // header
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20, 10, 'No', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Merk Laptop', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Seri Laptop', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Tahun Produksi', 1, 0, 'C');
        $pdf->Ln();
        // data
        $data = post::all();

        $i = 1;
        foreach ($data as $d) {

            $pdf->Cell(20, 10, $i++, 1, 0, 'C');
            $pdf->Cell(50, 10, $d['merk'], 1, 0, 'C');
            $pdf->Cell(50, 10, $d['seri'], 1, 0, 'L');
            $pdf->Cell(50, 10, $d['tahun'], 1, 0, 'R');
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }
}
