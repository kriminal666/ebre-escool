<?php

	$teachers_names=array();
	$teachers_sn1=array();
	$teachers_sn2=array();
	$teachers_codes=array();

	ksort($all_teachers);

foreach($all_teachers as $key => $value) {
    if(strlen($value)>0) {
	 	$teacher = explode(" ",$value);
	 	if(!array_key_exists(2,$teacher)) { $teacher[2] = ''; }
		$teachers_codes[]=$key;	 		 	
	 	$teachers_names[]=$teacher[0];
		$teachers_sn1[]=$teacher[1];
		$teachers_sn2[]=$teacher[2];
	}
}
	$count = count($teachers_codes);

//Crido la classe
$pdf = new FPDF();
//Defineixo els marges
$pdf->SetMargins(10,10,10);
//Obro una pàgina
$pdf->AddPage();
//$pdf->AddPage("P","A3");
//Es la posicio exacta on comença a escriure
$x=7;//10
$y=15;//24

$pdf->Image(base_url()."application/views/attendance_reports/logo_iesebre_2010_11.jpg",$x+2,5,40,15);
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc
$pdf->SetFont('Arial','B',15);
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
$pdf->SetXY(10,10);
$any_comencament = 2013;
$any_finalitzacio = 2014;
$pdf->Cell(190,6,"PROFESSORAT ".$any_comencament."-".$any_finalitzacio,0,0,'C');
$y=$y+6;

//Guardo les coordenades inicials de x i y
$x_start=$x;
$y_start=$y;

//Inicio les columnes i les files a 0
$col=0;
$row=0;

//Paràmetres de tamany de les fotos, $xx indica l'amplada de la foto, $yy indica
//l'altura de cada camp del professor, l'altura de la foto es 3 vegades aquest valor
//En cas de tocar aquest paràmetres caldria revisar el màxim de columnes i files  
$xx=11;//10//Amplada horitzontal de cada professor es tocada segons el nombre de professors que hi haguin

//Sergi Tur
//Si no s'indica l'amplada vertical es posa el que toca per mantenir les proporcions
//Fotos originals: 147x186:1.265306122
//Mida: 12x15,183673464
//$yy=5;//3//Amplada vertical de cada professor es tocada segons el nombre de professors que hi haguin

//No és l'açada de la FOTO! És la alçada del que ocupa cada bloc de profe (foto+dades)
$yy=4.75;

//Amb aquestes fòrmules defineixo les coordenades de cada camp de cada professor
//Fòrmula: posició inicial de x/y * columna * camps de cada professor 

//Ampla de la columna amb el nom i cognoms del professor
$x_name=12;
//Ampla de la columna de carrecs
$x_post=9;

$x=$x_start+$col*($xx+$x_name+$x_post);
$x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
$x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;

$y=$y_start+$row*$yy*3;
$y1=$y_start+$row*$yy*3+$yy;
$y2=$y_start+$row*$yy*3+$yy*2;

//La i és el marge entre professors
$i=0;
$page_one=true;

//Imprimeixo sempre els conserges i secretàries en una posició fixa el primer cop
//TODO: Obtenir les dades de les carpetes personal de Gosa:
        
//Posició inicial conserges:
$initial_x_personal=166;
$initial_y_personal=222;

$width_personal_foto=10;
        
$pdf->SetFont('Arial','B',8);
$pdf->Text($initial_x_personal+3,$initial_y_personal-2,utf8_decode("CONSERGES"));                
//Foto                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal,$initial_y_personal,$width_personal_foto);                
$pdf->SetFont('Arial','',5);                
//Nom                
$pdf->Text($initial_x_personal+1,$initial_y_personal+14,utf8_decode("Jordi"));                
//Cognom                
$pdf->Text($initial_x_personal+1,$initial_y_personal+16,utf8_decode("Caudet"));                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal+14,$initial_y_personal,$width_personal_foto);                
$pdf->Text($initial_x_personal+15,$initial_y_personal+14,utf8_decode("Leonor"));                  
$pdf->Text($initial_x_personal+15,$initial_y_personal+16,utf8_decode("Agramunt"));                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal+28,$initial_y_personal,$width_personal_foto);                
$pdf->Text($initial_x_personal+30,$initial_y_personal+14,utf8_decode("Jaume"));                
$pdf->Text($initial_x_personal+30,$initial_y_personal+16,utf8_decode("Benaiges"));                

$pdf->SetFont('Arial','B',8);                
$pdf->Text($initial_x_personal+3,$initial_y_personal+21,utf8_decode("SECRETÀRIES"));                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal,$initial_y_personal+22,$width_personal_foto);                
$pdf->SetFont('Arial','',5);                
$pdf->Text($initial_x_personal+1,$initial_y_personal+36,utf8_decode("Cinta"));                
$pdf->Text($initial_x_personal+1,$initial_y_personal+38,utf8_decode("Tomas"));                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal+14,$initial_y_personal+22,$width_personal_foto);                
$pdf->Text($initial_x_personal+15,$initial_y_personal+36,utf8_decode("Yolanda"));                
$pdf->Text($initial_x_personal+15,$initial_y_personal+38,utf8_decode("Domingo"));                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal+28,$initial_y_personal+22,$width_personal_foto);                
$pdf->Text($initial_x_personal+29,$initial_y_personal+36,utf8_decode("Lluisa"));                
$pdf->Text($initial_x_personal+29,$initial_y_personal+38,utf8_decode("Gárcia"));                
$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal,$initial_y_personal+40,$width_personal_foto);
$pdf->Text($initial_x_personal,$initial_y_personal+54,utf8_decode("Sònia"));
$pdf->Text($initial_x_personal,$initial_y_personal+56,utf8_decode("Alegria"));

//Si escrivim per la sortida aleshores no es podrà utilitzar PDF (headers already sent...)
//echo "prova!";

function cmpTeachers($a, $b)	{
    return strnatcmp($a->code, $b->code);
}

{

	$i=0;
$x = $x -22; ;
for($j=0;$j<$count; $j++) {

	 	$pdf->SetFont('Arial','B',6);
		$pdf->SetTextColor(255,0,0);
		
		$pdf->Text($x+22,$y,utf8_decode($teachers_codes[$j]));
		
		$pdf->SetFont('Arial','',4);
		$pdf->SetTextColor(0,0,0);		
		$pdf->Text($x+44,$y,utf8_decode("càrrec ".$teachers_codes[$j]));
		$pdf->Text($x+22,$y1-1,utf8_decode($teachers_names[$j]));
		$pdf->Text($x+22,$y2-2,utf8_decode($teachers_sn1[$j]));
		$pdf->Text($x+22,$y+11,utf8_decode($teachers_sn2[$j]));
		$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$x1-2,$y-2,$xx);                
	//incremento la fila
	$row++;
	//incremento el marge
	$i=$i+0.3;

	//Recàlculo les coordenades
	$y=$y_start+$i+$row*$yy*3;
	$y1=$y_start+$i+$row*$yy*3+$yy;
	$y2=$y_start+$i+$row*$yy*3+$yy*2;

	//màxim de files per pàgina 
	if($row>17){//26//Maxim de registre per columnes si es toca el tamny del professor tambe es tocara aquesta dada.
		//incremento la columna
		$col++;
		//reinicio les files i el marge
		$row=0;
		$i=0;
		//Recàlculo les coordenades
		$x=$x_start+$col*($xx+$x_name+$x_post)-22;   
		$x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
		$x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;
		
		$y=$y_start+$i+$row*$yy*3;
		$y1=$y_start+$i+$row*$yy*3+$yy;
		$y2=$y_start+$i+$row*$yy*3+$yy*2;

	}
	//Quan arribem a la última fila vigilem de no escriure a sobre dels conserges i secretàries
	if($col==5 && $row==21 && $page_one){
		//Ho tornem a posar tot a 0 i obrim una nova pàgina
		$col=0;
		$row=0;
		$i=0;
		$x=$x_start+$col*$xx;
		$x1=$x_start+$col*$xx*3+$xx;
		$x2=$x_start+$col*$xx*3+$xx*2;

		$y=$y_start+$i+$row*$yy*3;
		$y1=$y_start+$i+$row*$yy*3+$yy;
		$y2=$y_start+$i+$row*$yy*3+$yy*2;
		$page_one=false;
		$pdf->AddPage();
	}
}
}

//enviem tot al pdf
$pdf->Output("Professorat_".$any_comencament."-".$any_finalitzacio."_(".date("d-m-Y").").pdf", "I");

?>
