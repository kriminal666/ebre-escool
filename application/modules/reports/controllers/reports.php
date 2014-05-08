<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class reports extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php';
	//public $html_header_view ='/include/ebre_escool_html_header.php';

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;
	public $body_footer_view ='include/ebre_escool_body_footer' ;


	function __construct()
    {
        parent::__construct();
        
        $this->load->library('ebre_escool_ldap');
        
        // Load FPDF        
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $params = array ('orientation' => 'P', 'unit' => 'mm', 'size' => 'A4', 'font_path' => 'font/');        
        $this->load->library('pdf',$params); // Load library
        
	}
	
	/*
	 * Include teachers sheet and other info like employees
	 */
	function general_sheet() {
		
		

		if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
		
		$this->load->model('reports_model');

        $all_teachers = $this->reports_model->get_all_teachers();
/*
        echo "<table border=1px>";
        foreach($all_teachers as $t){

        	$photo = base_url('uploads/person_photos')."/".$t->photo_url;
        	echo "<tr>";
        	echo "<td>".$t->teacher_id."</td>";
        	echo "<td>".$t->givenName." ".$t->sn1." ".$t->sn2."</td>";
        	echo "<td><img src=". $photo. " /></td>";        	        	
        	echo "</tr>";

        }
        echo "</table>";
*/

        $default_group_code = $this->config->item('default_group_code');

        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_teachers") . ". " . $organization;
    
//        $all_teachers = $this->ebre_escool_ldap->getAllTeachers("ou=Profes,ou=All,dc=iesebre,dc=com");
        $all_conserges = $this->ebre_escool_ldap->getAllTeachers("ou=Consergeria,ou=Personal,ou=All,dc=iesebre,dc=com");
        $all_secretaria = $this->ebre_escool_ldap->getAllTeachers("ou=Secretaria,ou=Personal,ou=All,dc=iesebre,dc=com");
/*
echo "Conserges<br/>";
foreach($all_conserges as $conserge){
	echo $conserge['name']."<br />";
}

echo "<br />Secretaries<br />";
foreach($all_secretaria as $secretaria){
	echo $secretaria['name']."<br />";
}
*/

        //print_r(array_keys($all_teachers[0]));
        
		$contador = 0;
		$professor = array();
		$conserge = array();
		$secretaria = array();
		/*
		echo "<pre>";
		print_r($all_secretaria);
		echo "</pre>";
		*/
		/* CONSERGES */
		foreach($all_conserges as $cons) {

			$nom = explode(" ",rtrim($cons['name']));
			$conserge[$contador]['name']=$nom[0];
			$conserge[$contador]['sn']=$nom[1];
			$conserge[$contador]['photo']=$cons['photo'];

			$tipus = substr($conserge[$contador]['photo'],0,10);

			if(strlen($tipus)==8){
				$extensio = "cap";
			} else {
				$isJPG  = strpos($tipus, 'JFIF');
				if($isJPG){
					$extensio = ".jpg";
				} else {
					$isPNG = strpos($tipus, 'PNG');
					if($isPNG){
					$extensio = ".png";
					}
				}
			}

			$jpeg_filename="/tmp/".$conserge[$contador]['name'].$conserge[$contador]['sn'].$extensio;
			$jpeg_file_cons[$contador]="/tmp/".$conserge[$contador]['name'].$conserge[$contador]['sn'].$extensio;

			$outjpeg = fopen($jpeg_filename, "wb");
			fwrite($outjpeg, $conserge[$contador]['photo']);
			fclose ($outjpeg);
			$jpeg_data_size = filesize( $jpeg_filename );

			$contador++;
		}
		/*
		echo "<pre>";
		print_r($conserge);
		echo "</pre>";
		*/
		$contador = 0;

		/* SECRETARIES */
		foreach($all_secretaria as $secr) {

			$nom = explode(" ",rtrim($secr['name']));

			$secretaria[$contador]['name']=$nom[0];
			$secretaria[$contador]['sn']=$nom[1];
			$secretaria[$contador]['photo']=$secr['photo'];

			$tipus = substr($secretaria[$contador]['photo'],0,10);

			if(strlen($tipus)==8){
				$extensio = "cap";
			} else {
				$isJPG  = strpos($tipus, 'JFIF');
				if($isJPG){
					$extensio = ".jpg";
				} else {
					$isPNG = strpos($tipus, 'PNG');
					if($isPNG){
					$extensio = ".png";
					}
				}
			}

			$jpeg_filename="/tmp/".$secretaria[$contador]['name'].$secretaria[$contador]['sn'].$extensio;
			$jpeg_file_secr[$contador]="/tmp/".$secretaria[$contador]['name'].$secretaria[$contador]['sn'].$extensio;

			$outjpeg = fopen($jpeg_filename, "wb");
			fwrite($outjpeg, $secretaria[$contador]['photo']);
			fclose ($outjpeg);
			$jpeg_data_size = filesize( $jpeg_filename );

			$contador++;
		}

		$contador = 0;

		/* PROFESSORS */
		// Guardo les dades dels professors en un array
		foreach($all_teachers as $teacher) {

			$professor[$contador]['code']=$teacher->teacher_id;
			$professor[$contador]['name']=$teacher->givenName;
			$professor[$contador]['sn1']=$teacher->sn1;
			$professor[$contador]['sn2']=$teacher->sn2;

			if( file_exists(getcwd().'/uploads/person_photos/'.$teacher->photo_url)) {
			
				$professor[$contador]['photo']=base_url('uploads/person_photos')."/".$teacher->photo_url;
			} else {
				$professor[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
			}

			$professor[$contador]['carrec']="Càrrec ".$professor[$contador]['code'];
			
/*
			$tipus = substr($professor[$contador]['photo'],0,10);

			if(strlen($tipus)==8){
				$extensio = "cap";
			} else {
				$isJPG  = strpos($tipus, 'JFIF');
				if($isJPG){
					$extensio = ".jpg";
				} else {
					$isPNG = strpos($tipus, 'PNG');
					if($isPNG){
					$extensio = ".png";
					}
				}
			}

			$jpeg_filename="/tmp/".$professor[$contador]['code'].$extensio;
			$jpeg_file[$contador]="/tmp/".$professor[$contador]['code'].$extensio;

			$outjpeg = fopen($jpeg_filename, "wb");
			fwrite($outjpeg, $professor[$contador]['photo']);
			fclose ($outjpeg);
			$jpeg_data_size = filesize( $jpeg_filename );
*/
			$contador++;
		}

		$count = count($professor);

		//Crido la classe
		$pdf = new FPDF('P', 'mm', 'A4','font/');
		//Defineixo els marges
		$pdf->SetMargins(10,10,10);
		//Obro una pàgina
		$pdf->AddPage();
				//$pdf->Image($jpeg_file_cons[0],166,222,10);        
		//$pdf->AddPage("P","A3");
		//Es la posicio exacta on comença a escriure
		$x=7;//10
		$y=15;//24

		//Logo
		$pdf->Image(base_url().APPPATH.'third_party/skeleton/assets/img/logo_iesebre_2010_11.jpg',$x+2,5,40,15);
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
		$y3=$y_start+$row*$yy*3+$yy*2;

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
			$pdf->SetFont('Arial','',5); 	
			
			$x_personal=$initial_x_personal;
			$y_personal=$initial_y_personal;
			for($cont=0;$cont<count($conserge);$cont++){

				$pdf->Image($jpeg_file_cons[$cont],$x_personal,$y_personal,$width_personal_foto); 
				$pdf->Text($x_personal,$y_personal+15,utf8_decode($conserge[$cont]['name']));                
				$pdf->Text($x_personal,$y_personal+17,utf8_decode($conserge[$cont]['sn']));   
				$x_personal=$x_personal+14;
				if(($cont+1)%3==0){
					$x_personal=$initial_x_personal;
					$y_personal=$initial_y_personal+40;			
				}		
			}	

			$pdf->SetFont('Arial','B',8);   
			$pdf->Text($initial_x_personal+3,$initial_y_personal+22,utf8_decode("SECRETÀRIES"));	
			$pdf->SetFont('Arial','',5); 

			$x_personal=$initial_x_personal;
			$y_personal=$initial_y_personal+24;
			for($cont=0;$cont<count($secretaria);$cont++){

				$pdf->Image($jpeg_file_secr[$cont],$x_personal,$y_personal,$width_personal_foto); 
				$pdf->Text($x_personal,$y_personal+15,utf8_decode(ucfirst($secretaria[$cont]['name'])));                
				$pdf->Text($x_personal,$y_personal+17,utf8_decode(ucfirst($secretaria[$cont]['sn'])));   
				$x_personal=$x_personal+14;
				if(($cont+1)%3==0){
					$x_personal=$initial_x_personal;
					$y_personal=$initial_y_personal+42;			
				}
			}	

		/*	
			//Foto                
			$pdf->Image($jpeg_file_cons[0],$initial_x_personal,$initial_y_personal,$width_personal_foto);                
			$pdf->SetFont('Arial','',5);                
			//Nom                
			$pdf->Text($initial_x_personal+1,$initial_y_personal+15,utf8_decode($conserge[0]['name']));                
			//Cognom                
			$pdf->Text($initial_x_personal+1,$initial_y_personal+17,utf8_decode($conserge[0]['sn']));                
			$pdf->Image($jpeg_file_cons[1],$initial_x_personal+14,$initial_y_personal,$width_personal_foto);                
			$pdf->Text($initial_x_personal+15,$initial_y_personal+14,utf8_decode($conserge[1]['name']));                  
			$pdf->Text($initial_x_personal+15,$initial_y_personal+16,utf8_decode($conserge[1]['sn']));                
			$pdf->Image($jpeg_file_cons[2],$initial_x_personal+28,$initial_y_personal,$width_personal_foto);                
			$pdf->Text($initial_x_personal+30,$initial_y_personal+14,utf8_decode($conserge[2]['name']));                
			$pdf->Text($initial_x_personal+30,$initial_y_personal+16,utf8_decode($conserge[2]['sn']));                
		*/
			/*
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
		*/
		//Si escrivim per la sortida aleshores no es podrà utilitzar PDF (headers already sent...)
		//echo "prova!";

		function cmpTeachers($a, $b)	{
			return strnatcmp($a->code, $b->code);
		}

		{

		$x = $x -22;
		//$y = 21;
		for($j=0;$j<$count; $j++) {

				$pdf->SetFont('Arial','B',6);
				$pdf->SetTextColor(255,0,0);
				
				$pdf->Text($x+22,$y,utf8_decode($professor[$j]['code']));
				
				$pdf->SetFont('Arial','',4);
				$pdf->SetTextColor(0,0,0);		
				$pdf->Text($x+44,$y,utf8_decode($professor[$j]['carrec']));
				$pdf->Text($x+22,$y1-1,utf8_decode($professor[$j]['name']));
				$pdf->Text($x+22,$y2-2,utf8_decode($professor[$j]['sn1']));
				$pdf->Text($x+22,$y+11,utf8_decode($professor[$j]['sn2']));
				//$pdf->Image($jpeg_file[$j],$x1-2,$y-2,$xx);                
				$pdf->Image($professor[$j]['photo'],$x1-2,$y-2,$xx);                
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

		
	}

	/*
	 * Only teachers: at teachers module
	 */
	/*function teacher_sheet() {
		echo "TODO";
	}*/

}
