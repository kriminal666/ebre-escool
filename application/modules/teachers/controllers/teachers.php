<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class teachers extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header.php' ;

    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;

	
	function __construct()
    {
        parent::__construct();
        
        //GROCERY CRUD
		    $this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
    		$this->load->library('image_CRUD');  

        // Load FPDF        
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $params = array ('orientation' => 'P', 'unit' => 'mm', 'size' => 'A4', 'font_path' => 'font/');        
        $this->load->library('pdf',$params); // Load library

		    /* Set language */
		    $current_language=$this->session->userdata("current_language");
		    if ($current_language == "") {
		      $current_language= $this->config->item('default_language');
		    }
		    $this->lang->load('teachers', $current_language);	       

        //LANGUAGE HELPER:
        $this->load->helper('language');
	}

    public function teacher_sheet() {

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        //TODO
        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#teachers_reports';
        $active_menu['submenu2']='#teachers_sheet_report';
        
        $this->load->model('teachers_model');

        $all_teachers = $this->teachers_model->get_all_teachers();

        $default_group_code = $this->config->item('default_group_code');

        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_teachers") . ". " . $organization;

        $contador = 0;
        $professor = array();
      
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

        
//    }

    }

    function tutors_report() { // Tutors de Grup

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }


        //TODO
        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_mentor_list';

        echo "TODO";
        //$this->load->view('attendance_reports/Llistat_grup_tutor.php',$data);     

        $this->load_footer();     

    }     

	public function teacher() {
    
    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#teachers';

    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Grocery Crud */ 
    $this->current_table="teacher";
    $this->grocery_crud->set_table($this->current_table);
        
    $this->session->set_flashdata('table_name', $this->current_table); 
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang('teacher'));

    $this->common_callbacks($this->current_table);
        
    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_person_id',lang($this->current_table.'_person_id'));          
    $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));  
    $this->grocery_crud->display_as($this->current_table.'_department_id',lang($this->current_table.'_department_id'));   

    $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
    $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
    $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 

    //RELATIONS
    $this->grocery_crud->set_relation('teacher_person_id','person','{person_sn1} {person_sn2},{person_givenName} ({person_official_id}) - {person_id} '); 
    $this->grocery_crud->set_relation('teacher_department_id','department','{department_shortname}');   

    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data); 


       	//$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');
        //$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');

	}

//-->
  //CALLBACKS
function common_callbacks()
{
        //CALLBACKS        
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

  public function edit_field_callback_entryDate($value, $primary_key){
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
  }

  public function edit_callback_last_update($value, $primary_key){

    $data = date('d/m/Y H:i:s', time());
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. $data .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';

  }

  public function before_update_last_update($post_array, $primary_key) {
    $data= date('d/m/Y H:i:s', time());
    //$post_array['person_last_update'] = $data;
    $post_array[$this->session->flashdata('table_name').'_last_update'] = $data;
    //$post_array['lastupdateUserId'] = $this->session->userdata('user_id');
    return $post_array;
}  

public function add_field_callback_entryDate(){  

    $data= date('d/m/Y H:i:s', time());
    //return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="person_entryDate" id="field-entryDate" readonly>';    
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}  

protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

	
public function index() {
		$this->teacher();
	}


function check_logged_user()
{
    if (!$this->skeleton_auth->logged_in())
    {
        //redirect them to the login page
        redirect($this->skeleton_auth->login_page, 'refresh');
    }

    //CHECK IF USER IS READONLY --> unset add, edit & delete actions
    $readonly_group = $this->config->item('readonly_group');
    if ($this->skeleton_auth->in_group($readonly_group)) {
        $this->grocery_crud->unset_add();
        $this->grocery_crud->unset_edit();
        $this->grocery_crud->unset_delete();
    }
}


function userCreation_userModification($table_name)
{   
    //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($table_name.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($table_name.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_lastupdateUserId',$this->session->userdata('user_id'));
}

function renderitzar($table_name,$header_data)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
       $this->_load_html_header($header_data,$output); 
    
       // BODY       

       $this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       //$this->load->view('course.php',$output);     
       $this->load->view($table_name.'.php',$output);     
       
       //      FOOTER     
       $this->_load_body_footer();  

}    

  public function load_ace_files($active_menu) {
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
                base_url('assets/css/ace-fonts.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-responsive.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-skins.min.css'));      
/*
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js')); 

        $header_data['menu']= $active_menu;
        return $header_data;

  }

        function cmpTeachers($a, $b)    {
            return strnatcmp($a->code, $b->code);
        }


}
