<?php
require_once('method.php');

/*according to the grammar of fpdf set care plan's style
 * include HEADER，FOOTER，WATERMARK，TABLESTYLE;
 *
 * */

class PLANPDF extends PDFMETHOD
{


function Header()
{
    //水印
//    $this->Image('images/plan/12.png',90,150,100);

	if($this->PageNo()%2!=0)
	{
		$this->Image('images/plan/title.png',6,3,200);
		$this->SetFont('simhei','',20);
		$this->Cell(80);

		$this->Ln(25);
	}else
	{
        $this->Image('images/plan/title.png',6,3,200);
        $this->SetFont('simhei','',20);
        $this->Cell(80);

        $this->Ln(25);
	}
	
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','I',8);
	$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

function BasicTable($header, $data)
{
	// Header
	$this->SetFont('simhei','',10);
	foreach($header as $col)
		$this->Cell(40,10,$col,1);
	$this->Ln();
	// Data

	foreach($data as $row)
	{
		foreach($row as $col)
			$this->Cell(40,6,$col,1);
		$this->Ln();
	}
}

function LoadData($file)
{
	// Read file lines
	$lines = file($file);
	$data = array();
	$this->SetFont('simhei','',10);

	foreach($lines as $line)
		// $data[] = explode(';',trim($line));
		$data[] = [iconv("utf-8","gbk",'清檬'),iconv("utf-8","gbk",'养老'),iconv("utf-8","gbk",'清养'),'100'];
	return $data;
}



}


// $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// $pdf=new PDF();
// $pdf->AddGBFont(); 
// $pdf->AliasNbPages('序');
// // $pdf->SetLineWidth(2);
// // $pdf->AddBig5Font();
// $pdf->AddPage();
// // $pdf->SetFont('Big5','',20);
// // $pdf->AddGBFont(); 
// $pdf->SetFont('GB','',15);
// // $pdf->Write(10,'甲乙丙丁午己庚辛壬癸');
//  $pdf->MultiCell(0,7,$txt,'1');
// // $pdf->Cell(40,10,);
// $pdf->AddPage();
// $data = $pdf->LoadData('countries.txt');	

// // // $pdf->SetFont('Arial','',14);
// // $pdf->AddPage();
// $pdf->BasicTable($header,$data);
// $pdf->Output();
