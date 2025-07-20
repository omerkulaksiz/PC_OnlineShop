<?php
// Ensure no output before PDF generation
ob_clean();

require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
session_start();

// Prüfe, ob die nötigen Session-Daten vorhanden sind
if (
    empty($_SESSION['gehause']) ||
    empty($_SESSION['cpu']) ||
    empty($_SESSION['ram']) ||
    empty($_SESSION['user_id']) ||
    empty($_SESSION['user_adresse']) // Optional: falls du Adresse separat speicherst
) {
    die('Nicht alle Bestelldaten vorhanden.');
}

// Optional: Adresse aus Session holen, falls du sie so speicherst
$user = $_SESSION['user_adresse'] ?? [
    'name'      => $_SESSION['user_name'] ?? '',
    'firmenname'=> $_SESSION['user_firma'] ?? '',
    'zusatz'    => $_SESSION['user_zusatz'] ?? '',
    'plz'       => $_SESSION['user_plz'] ?? '',
];

// Gesamtpreis berechnen
$total = 0;
$total += (float)$_SESSION['gehause']['preis'];
$total += (float)$_SESSION['cpu']['preis'];
$total += (float)$_SESSION['ram']['preis'];
if (!empty($_SESSION['zubehor'])) {
    foreach ($_SESSION['zubehor'] as $item) {
        $total += (float)$item['preis'];
    }
}

// PDF-Erstellung
class OrderPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'Mustermann IT-Systeme', 0, 1, 'C');
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0, 10, 'Ihre PC Bestellung', 0, 1, 'C');
        $this->Ln(10);
    }
}

$pdf = new OrderPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->SetCreator('Mustermann IT-Systeme');
$pdf->SetAuthor('Mustermann IT-Systeme');
$pdf->SetTitle('Ihre Bestellung');
$pdf->AddPage();

// Adresse
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Lieferadresse:', 0, 1);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $user['name'], 0, 1);
if (!empty($user['firmenname'])) $pdf->Cell(0, 10, $user['firmenname'], 0, 1);
if (!empty($user['zusatz'])) $pdf->Cell(0, 10, $user['zusatz'], 0, 1);
$pdf->Cell(0, 10, $user['plz'], 0, 1);
$pdf->Ln(10);

// Tabelle
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(90, 10, 'Komponente', 1, 0);
$pdf->Cell(60, 10, 'Details', 1, 0);
$pdf->Cell(40, 10, 'Preis', 1, 1, 'R');
$pdf->SetFont('helvetica', '', 12);

// Gehäuse
$pdf->Cell(90, 10, 'Gehäuse', 1, 0);
$pdf->Cell(60, 10, $_SESSION['gehause']['typ'], 1, 0);
$pdf->Cell(40, 10, number_format((float)$_SESSION['gehause']['preis'], 2, ',', '.') . ' €', 1, 1, 'R');

// CPU
$pdf->Cell(90, 10, 'CPU', 1, 0);
$pdf->Cell(60, 10, $_SESSION['cpu']['model'], 1, 0);
$pdf->Cell(40, 10, number_format((float)$_SESSION['cpu']['preis'], 2, ',', '.') . ' €', 1, 1, 'R');

// RAM
$pdf->Cell(90, 10, 'RAM', 1, 0);
$pdf->Cell(60, 10, $_SESSION['ram']['size'] . ' GB', 1, 0);
$pdf->Cell(40, 10, number_format((float)$_SESSION['ram']['preis'], 2, ',', '.') . ' €', 1, 1, 'R');

// Zubehör
if (!empty($_SESSION['zubehor'])) {
    foreach ($_SESSION['zubehor'] as $item) {
        $pdf->Cell(90, 10, 'Zubehör', 1, 0);
        $pdf->Cell(60, 10, $item['name'], 1, 0);
        $pdf->Cell(40, 10, number_format((float)$item['preis'], 2, ',', '.') . ' €', 1, 1, 'R');
    }
}

// Gesamtpreis
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(150, 10, 'Gesamtpreis:', 1, 0);
$pdf->Cell(40, 10, number_format($total, 2, ',', '.') . ' €', 1, 1, 'R');

// Clean any output before sending PDF
ob_end_clean();

// Output PDF
$pdf->Output('Bestellung.pdf', 'D');