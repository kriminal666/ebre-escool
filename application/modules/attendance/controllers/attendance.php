<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class attendance extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;

	public $body_footer_view ='include/ebre_escool_body_footer' ;


	public function load_header_data(){

		//CSS URLS
		$jquery_ui_css_url = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		$jquery_ui_editable_css_url = "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
		$select2_css_url = "http://cdn.jsdelivr.net/select2/3.4.5/select2.css";
		//JS URLS
		$jquery_url= "http://code.jquery.com/jquery-1.9.1.js";
		$jquery_ui_url= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$select2_url= "http://cdn.jsdelivr.net/select2/3.4.5/select2.js";
		$jquery_ui_editable_url= "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

		if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
  			$jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
  			$jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
  			$select2_css_url = base_url('assets/css/select2.css');

  			$jquery_url= base_url('assets/js/jquery-1.9.1.js');
			$jquery_ui_url= base_url('assets/js/jquery-ui.js');
			$select2_url= base_url('assets/js/select2.js');
			$jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			$jquery_ui_css_url);
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$jquery_ui_editable_css_url);
		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$select2_css_url);
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 
		
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
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
        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));        

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));        

		//JS Already load at skeleton main!!!
		//$header_data= $this->add_javascript_to_html_header_data(
		//	$header_data,
		//	$jquery_url);

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_url);	
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$select2_url);
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_editable_url);
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-tooltip.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-collapse.js'));                
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal-shared.js'));        
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal-timetable.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));

		return $header_data; 
        
    }
	
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('attendance_model');
        $this->load->library('ebre_escool_ldap');

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language','skeleton_auth');
		}
		$this->grocery_crud->set_language($current_language);
    	$this->lang->load('skeleton', $current_language);	       
    	
    	$this->lang->load('attendance', $current_language);	
    	
		$this->lang->load('managment', $current_language);        
        
	}

	public function time_slots () {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

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






		$table_name="time_slot";
        $this->grocery_crud->set_table($table_name);  
		
		//Establish subject:
        $this->grocery_crud->set_subject(lang("time_slot"));

        //RELATIONS
        //$this->grocery_crud->set_relation('person_official_id_type','person_official_id_type','{person_official_id_type_shortname} - {person_official_id_type_id}',null,null,"persons");
        

        $this->grocery_crud->display_as('time_slot_id',lang('time_slot_id'));
       	$this->grocery_crud->display_as('time_slot_start_time',lang('time_slot_start_time'));       
       	$this->grocery_crud->display_as('time_slot_end_time',lang('time_slot_end_time'));       
       	$this->grocery_crud->display_as('time_slot_entryDate',lang('time_slot_entryDate'));
       	$this->grocery_crud->display_as('time_slot_last_update',lang('time_slot_last_update'));
       	$this->grocery_crud->display_as('time_slot_creationUserId',lang('time_slot_creationUserId'));
       	$this->grocery_crud->display_as('time_slot_lastupdateUserId',lang('time_slot_lastupdateUserId'));
       	$this->grocery_crud->display_as('time_slot_markedForDeletion',lang('time_slot_markedForDeletion'));
       	$this->grocery_crud->display_as('time_slot_markedForDeletionDate',lang('time_slot_markedForDeletionDate'));

        //$this->grocery_crud->set_default_value($table_name,'person_creationUserId','TODO');
        $this->grocery_crud->set_default_value($table_name,'person_markedForDeletion','n');

        $output = $this->grocery_crud->render();
		
        $this->_load_html_header($header_data,$output); 
	    $this->_load_body_header();

		$this->load->view('time_slots',$output); 
                
		$this->_load_body_footer();	 	
	}

/* proves ajax, json */

	public function prova () {

		//CSS
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
			
		$this->_load_html_header($header_data); 
		$this->_load_body_header();
        $this->load->view('attendance/prova.php');    
		$this->_load_body_footer();	
	}

	public function read($table=null){

		$this->db->select('alumne, incidencia, data, hora');
		$this->db->where('alumne', $_POST['alumne']); 
		$this->db->where('hora', $_POST['hora']);
		$query = $this->db->get($table);
		$resultat = array();
		$resultat[] = "Alumne  - Incidencia - Data - Hora";

		foreach ($query->result() as $row)
		{
		    $resultat[] = $row->alumne ." - ".$row->incidencia." - ".$row->data." - ".$row->hora;
		}
		print_r(json_encode($resultat));
	}	

	public function insert($table=null){

		//echo $table;
		$this->db->insert($table, $_POST); 
		$rows = $this->db->affected_rows();
		print_r(json_encode($this->db->affected_rows()));
		//$this->db->insert($table, $data); 
		//print_r(json_encode($data));
	}		

	public function update(){

		$data = array(
           'cycle_shortname' => 'cic mod 1',
           'cycle_name' => 'cicle modificat 1',
           'cycle_entryDate' => date("Y-m-d H:i:s")
        );

		$this->db->where('cycle_id', '6');
		$this->db->update('cycle', $data); 
		print_r(json_encode($data));
	}	

	public function delete(){
		$data = array(
			'Esborrat' => 'id 8'		
		);
		$this->db->where('cycle_id', '8');
		$this->db->delete('cycle'); 
		print_r(json_encode($data));
	}	

/* fi proves ajax json */	

	
	public function mentoring_groups ( $class_room_group_id = null ) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data = $this->load_header_data();
        $this->_load_html_header($header_data);
		/*
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			"http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css");
		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			"http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 

		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-tooltip.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-collapse.js'));                
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal-shared.js'));        
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal-timetable.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.min.js'));
*/	
		//$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		//Check if user is manager -> Show all groups

		// IF USER IS NOT MANAGER -> IS MENTOR? -> SHOW GROUPS user is mentor

		$data = array();
		$data['default_classroom_group_id'] = 2;

		$data['check_attendance_date'] = date('d/m/Y');

		if ( $class_room_group_id != null ) {
			$data['default_classroom_group_id'] = $class_room_group_id;			
		}

		
		//$data['classroom_groups'] = array ( 1 => "Grup1" , 2 => "Grup 2", 3 => "Grup 3");
		$data['classroom_groups'] = $this->attendance_model->get_all_groups();

		$this->load->view('mentoring_groups',$data);	

		$this->_load_body_footer();		

	}

	public function mentoring_attendance_by_student () {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data = $this->load_header_data();
        $this->_load_html_header($header_data);
/*
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			
		$this->_load_html_header($header_data); 
*/		
		$this->_load_body_header();

		$data = array();
		
		$this->load->view('mentoring_attendance_by_student',$data);	

		$this->_load_body_footer();		
	}
	
	public function pdf_exemple() {
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('fpdf');
		$pdf=new FPDF();
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Image('http://fpdf.org/logo.gif');
		$pdf->Cell(0,10,utf8_decode('¡Hola, Món!'),1,2,'L');
		$pdf->Output();
	}




	public function classroom_groups() {
		//Cargar la llibreria fpdf
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('pdf');
		$pdf=new PDF();




		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
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
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js'));   			

		$this->current_table="classroom_group";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);


        //ESTABLISH SUBJECT        
        $this->grocery_crud->set_subject(lang('ClassroomGroup'));

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

		//Mandatory fields
        $this->grocery_crud->required_fields('classroom_group_code','classroom_group_name','classroom_group_shortName','classroom_group_markedForDeletion');
        
        //express fields
        $this->grocery_crud->express_fields('name','shortName','code');

        //Camps last update no editable i automàtic        
        //$this->grocery_crud->callback_add_field('classroom_group_last_update',array($this,'add_callback_last_update'));
      
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('classroom_group_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('classroom_group_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('classroom_group_last_update',array($this,'edit_callback_last_update'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('classroom_group_last_update');
        
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('classroom_group_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'classroom_group_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('classroom_group_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'classroom_group_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("classroom_group_creationUserId","classroom_group_lastupdateUserId","classroom_group_parentLocation");
        
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'classroom_group_parentLocation',1);
        
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'classroom_group_markedForDeletion','n');

        $this->grocery_crud->display_as('classroom_group_id',lang('idGroup'));
        $this->grocery_crud->display_as('classroom_group_code',lang('GroupCode'));
		$this->grocery_crud->display_as('classroom_group_shortName',lang('GroupShortName'));
		$this->grocery_crud->display_as('classroom_group_name',lang('GroupName'));
		$this->grocery_crud->display_as('classroom_group_description',lang('GroupDescription'));
		$this->grocery_crud->display_as('classroom_group_educationalLevelId',lang('EducationalLevelId'));
		$this->grocery_crud->display_as('classroom_group_mentorId',lang('MentorId'));
        $this->grocery_crud->display_as('classroom_group_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('classroom_group_last_update',lang('last_update'));
        $this->grocery_crud->display_as('classroom_group_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('classroom_group_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('classroom_group_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('classroom_group_markedForDeletionDate',lang('markedForDeletionDate')); 		

		/* show only specified columns */
		$this->grocery_crud->columns('classroom_group_id','classroom_group_code','classroom_group_shortName','classroom_group_name','classroom_group_description','classroom_group_mentorId','classroom_group_entryDate','classroom_group_last_update','classroom_group_creationUserId','classroom_group_lastupdateUserId');

		$output = $this->grocery_crud->render();
                        
        $this->_load_html_header($header_data,$output); 
	    $this->_load_body_header();
			
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="classroom_group_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('attendance/classroom_groups_view.php',$output);     


		$this->_load_body_footer();

	}

	public function check_attendance_classroom_group() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data = $this->load_header_data();
        $this->_load_html_header($header_data);

        /*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();

		$teacher_code = null;

		if ($teacher_code == null) {
	    	//TODO: Default teacher: current logged user
	    	$teacher_code = 41;
	    } else {
	    	//TODO: Check if user is admin: if not admin it could not select the teacher: Force teacher to be himself
	    	if (false) { $teacher_code = 41; }
	    }

	    $teacher_department_id = 2;

		$teacher_id = $this->attendance_model->get_teacher_id_from_teacher_code($teacher_code);     

	    //echo "teacher_id: $teacher_id<br/>";       
	    //echo "teacher_code: $teacher_code<br/>";   

	    $user_is_admin=true;
	    $user_is_teacher=true;

	    //Departaments
	    $data['departments']=array();
	    $data['selected_department_key']=2;
	    $data['selected_department_name']=$this->attendance_model->get_teacher_departmentName($teacher_id);
		if ($user_is_admin) {
	    	//Get all classroom_groups
	    	$data['departments']= $this->attendance_model->get_all_departments();
	    } else {
	    	$data['departments']= $this->attendance_model->get_teacher_departments($teacher_id);
	    }
            
	    #Obtain class_room_groups
	    //TODO:
	    $data['classroom_groups']=array();
	    if (false) {
	    	//Get all classroom_groups
	    	$data['classroom_groups']= $this->attendance_model->get_all_groupscodenameByDeparment($teacher_department_id);
	    } else {
	    	//IF TEACHER
	    	if($user_is_teacher) {
	    		$data['classroom_groups']=$this->attendance_model->get_all_groupscodenameByTeacher($teacher_id);
	    	}
			$data['classroom_groups']=array();
	    }

	    $data['study_modules']=array();
	    if ($user_is_admin) {
	    	$data['study_modules']= array ( 1 => "M 8", 2 => "M 9", 3 => "M 10", 4 => "M 11", 5 => "M 12" );
	    } else {
			$data['study_modules']=array();
	    }

	    if ($user_is_admin) {
	    	$time_slot1 = new stdClass;
			$time_slot1->hour = "15:30";
			$time_slot1->range = "15:30 - 16:30";
			$time_slot1->study_module_shortname = "M9";
			$time_slot1->study_module_name = "Mòdul 9";
			$time_slot1->teacher_name = "Sergi Tur Badenas";

			$time_slot2 = new stdClass;
			$time_slot2->hour = "16:30";
			$time_slot2->range = "16:30 - 17:30";
			$time_slot2->study_module_shortname = "M10";
			$time_slot2->study_module_name = "Mòdul 10";
			$time_slot2->teacher_name = "Mireia Consarnau";

			$time_slot3 = new stdClass;
			$time_slot3->hour = "17:30";
			$time_slot3->range = "17:30 - 18:30";
			$time_slot3->study_module_shortname = "M11";
			$time_slot3->study_module_name = "Mòdul 11";
			$time_slot3->teacher_name = "Jordi Varas";

			$time_slot4 = new stdClass;
			$time_slot4->hour = "19:00";
			$time_slot4->range = "19:00 - 20:00";
			$time_slot4->study_module_shortname = "M3";
			$time_slot4->study_module_name = "Mòdul 3";
			$time_slot4->teacher_name = "Manu Macias";

			$time_slot5 = new stdClass;
			$time_slot5->hour = "20:00";
			$time_slot5->range = "20:00 - 21:00";
			$time_slot5->study_module_shortname = "M1";
			$time_slot5->study_module_name = "Mòdul 1";
			$time_slot5->teacher_name = "TODO";

			$time_slot6 = new stdClass;
			$time_slot6->hour = "21:00";
			$time_slot6->range = "21:00 - 22:00";
			$time_slot6->study_module_shortname = "M4";
			$time_slot6->study_module_name = "Mòdul 4";
			$time_slot6->teacher_name = "TODO 1";

		    $data['time_slots']=array();
		    $data['selected_time_slot_key'] = 4;
			
	    	$data['time_slots'] = array ( 1 => $time_slot1, 2 => $time_slot2, 3 => $time_slot3, 4 => $time_slot4, 5 => $time_slot5, 6 => $time_slot6 );
	    } else {
			$data['time_slots'] = array();
	    }

	    $data['group_teachers']= array ( 1 => "Mireia Consarnau (tutora)", 2 => "Sergi Tur", 3 => "Santi Sabaté", 4 => "Manu Macias");
	    $data['selected_group_teacher']= "Mireia Consarnau (tutora)";
	    $data['group_teachers_default_teacher_key']= 1;

	    $data['selected_classroom_group_key']= 25;
	    $data['selected_classroom_group_shortname'] = "2ASIX";
		$data['selected_classroom_group'] = "2n Desenvolupament d'Aplicacions Multiplataforma";

		$data['selected_study_module_key']= 2;
	    $data['selected_study_module_shortname'] = "M 9";
		$data['selected_study_module'] = "Mòdul 9 bla bla bla";
        
		//TODO: select current user (sessions user as default teacher)
	    $data['default_teacher'] = $teacher_code;

	    $data['selected_day'] = "20/01/2014";;
	    $data['selected_time_slot'] = "19:00 - 20:00";

	    $data['total_number_of_students'] = 3;
		$data['selected_module_shortname'] = "M 9";

		//classroom_group_students

		$student1 = new stdClass;
		$student1->givenName = "Julia";
		$student1->sn1 = "Adell";
		$student1->sn2 = "Girbes";
		$student1->photo_url = "/assets/avatars/avatar3.png";
		$student1->username = "juliaadell";
		$student1->email = "juliaadell@email.com";
		$student1->notes = "Esta setmana està faltant molt";

		$student2 = new stdClass;
		$student2->givenName = "Manuel";
		$student2->sn1 = "Blanch";
		$student2->sn2 = "Garzon";
		$student2->photo_url = "/assets/avatars/avatar1.png";
		$student2->username = "manuelblanch";
		$student2->email = "manuelblanch@email.com";
		$student2->notes = "";

		$student3 = new stdClass;
		$student3->givenName = "Josep Francesc";
		$student3->sn1 = "Borrell";
		$student3->sn2 = "Girbes";
		$student3->photo_url = "/assets/avatars/avatar2.png";
		$student3->username = "josepborrell";
		$student3->email = "josepborrell@email.com";
		$student3->notes = "";

		$data['classroom_group_students'] = array (
			1 => $student1,
			2 => $student2,
			3 => $student3
			);

	    

		/* fi llista alumnes grup */
		$this->load->view('attendance/check_attendance_classroom_group',$data);
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();	
	}


	public function check_attendance(

		$teacher_code = null, $day = null, $month = null, $year = null ,$url_group_code = null) {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$header_data = $this->load_header_data();
        $this->_load_html_header($header_data);

		/*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();

		if ($teacher_code == null) {
	    	//TODO: Default teacher: current logged user
	    	$teacher_code = 41;
	    } else {
	    	//TODO: Check if user is admin: if not admin it could not select the teacher: Force teacher to be himself
	    	if (false) { $teacher_code = 41; }
	    }

	    $teacher_id = $this->attendance_model->get_teacher_id_from_teacher_code($teacher_code);     

	    //echo "teacher_id: $teacher_id<br/>";       
	    //echo "teacher_code: $teacher_code<br/>";       
        
		//TODO: USER IS ADMIN: Show all teachers dropdown
		if (true) {
			//Load teachers from Model
			$teachers_array = $this->attendance_model->get_all_teachers_ids_and_names();

			$data['teachers'] = $teachers_array;
		} else {
			//Show Only one teacher
			$teachers_array = $this->attendance_model->get_teacher_ids_and_names($teacher_id);
			$data['teachers'] = $teachers_array;
		}

		//TODO: select current user (sessions user as default teacher)
	    $data['default_teacher'] = $teacher_code;


		$data['check_attendance_date'] = null;
		//YYYY-MM-DD
		$iso_date = null;

	    if ( ($day != null) && ($month != null) && ($year != null) ) {
	    	$data['check_attendance_date'] = $day . "/" . $month . "/" .$year;
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    } else {
	    	$data['check_attendance_date'] = date('d/m/Y');	
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    }

	    $day_of_week_number = date('N', strtotime($iso_date));

		$data['day_of_week_number'] = $day_of_week_number;
	    $timestamp = strtotime('next Monday');
		$days_of_week = array();
		for ($i = 1; $i < 8; $i++) {
 			$days_of_week[$i] = strftime('%A', $timestamp);
 			$timestamp = strtotime('+1 day', $timestamp);
		}

		$data['days_of_week'] = $days_of_week;

	    
	    //Obtain Time Slots
    	$time_slots_array = $this->attendance_model->getAllTimeSlots()->result_array();
    	$time_slots_array_byteacher_and_day = null;

    	$time_slots_array_byteacher_and_day = $this->attendance_model->getAllTimeSlotsByTeacherCodeAndDay($teacher_id,$day_of_week_number);

    	if ($time_slots_array_byteacher_and_day != null) {
    		$time_slots_array_byteacher_and_day = $time_slots_array_byteacher_and_day->result_array();
    	} else {
    		$time_slots_array_byteacher_and_day = array();
    	}

    	
    	$lessons_array_byteacher_and_day = $this->attendance_model->getAllLessonsByTeacherCodeAndDay($teacher_id,$day_of_week_number);

	    $data['time_slots_array'] = $time_slots_array;
	    $data['time_slots_array_byteacher_and_day'] = $time_slots_array_byteacher_and_day;

	    //print_r($time_slots_array);

	    $teacher_groups_current_day=array();
	    
	    $all_time_slots=array();
	    $all_time_slots_reduced=array();

	    $classroom_groups_colours = $this->_alt_assign_colours($lessons_array_byteacher_and_day,"classroom_group_code");
		$study_modules_colours = $this->_assign_colours($lessons_array_byteacher_and_day,"study_module_id");

	    foreach ($time_slots_array as $time_slot)	{
	    	$group_code = "";
			$base_url =  "";
			$group_shortname =  "";
			$group_name =  "";
			
			
			$lesson_code =  "";
			$lesson_shortname =  "";
			$lesson_name =  "";

			$lesson_location =  "";
   			$time_slot_data = new stdClass;
			$time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
			$time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];
			$time_slot_id = $time_slot['time_slot_id'];

			$study_module_id = null;
			$group_code = null;
			$time_slot_data->lesson_colour = "btn-default";
			if (is_array($lessons_array_byteacher_and_day)) {
				if (array_key_exists($time_slot_id, $lessons_array_byteacher_and_day)) {
    				$group_code = $lessons_array_byteacher_and_day[$time_slot_id]->group_code;
					$base_url = $lessons_array_byteacher_and_day[$time_slot_id]->base_url;
					$group_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->group_shortname;	
					$group_name = $lessons_array_byteacher_and_day[$time_slot_id]->group_name;
					$study_module_id = $lessons_array_byteacher_and_day[$time_slot_id]->study_module_id;
					$lesson_code = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_code;
					$lesson_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_shortname;
					$lesson_name = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_name;
					$lesson_location = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_location;
				} 
			}
			
			$time_slot_data->group_code = $group_code;
			$time_slot_data->group_url= $base_url;
			$time_slot_data->group_shortname = $group_shortname;
			$time_slot_data->group_name = $group_name;
			
			$time_slot_data->lesson_location = $lesson_location;
			$time_slot_data->lesson_code = $lesson_code;
			$time_slot_data->lesson_shortname = $lesson_shortname;
			$time_slot_data->lesson_name = $lesson_name;
			
			$time_slot_data->classroom_group_colour = "btn-default";
			if ( $group_code != null ) {
				if (array_key_exists($group_code, $classroom_groups_colours)) {
					$time_slot_data->classroom_group_colour = $classroom_groups_colours[$group_code];
				} 
			}
			if ( $study_module_id != null ) {
				if (array_key_exists($study_module_id, $study_modules_colours)) {
					$time_slot_data->lesson_colour = $study_modules_colours[$study_module_id];
				} 
			}

   			$all_time_slots[$time_slot_id] = $time_slot_data;
		}

		foreach ($time_slots_array_byteacher_and_day as $time_slot)	{
			$group_code = "";
			$base_url =  "";
			$group_shortname =  "";
			$group_name =  "";
			
			$lesson_code =  "";
			$lesson_shortname =  "";
			$lesson_name =  "";


			$lesson_location =  "";
   			$time_slot_data = new stdClass;
			$time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
			$time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];
			$time_slot_id = $time_slot['time_slot_id'];

			//Obtain lesson for this teacher date and time slot
			$study_module_id = null;
			$time_slot_data->lesson_colour = "btn-default";
			if (array_key_exists($time_slot_id, $lessons_array_byteacher_and_day)) {
				$group_code = $lessons_array_byteacher_and_day[$time_slot_id]->group_code;
				$base_url = $lessons_array_byteacher_and_day[$time_slot_id]->base_url;
				$group_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->group_shortname;
				$group_name = $lessons_array_byteacher_and_day[$time_slot_id]->group_name;
				$study_module_id = $lessons_array_byteacher_and_day[$time_slot_id]->study_module_id;
				$lesson_code = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_code;
				$lesson_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_shortname;
				$lesson_name = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_name;
				$lesson_location = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_location;
			}

			$time_slot_data->group_code = $group_code;
			$time_slot_data->group_url= $base_url;
			$time_slot_data->group_shortname = $group_shortname;
			$time_slot_data->group_name = $group_name;
			$time_slot_data->lesson_code = $lesson_code;
			$time_slot_data->lesson_shortname = $lesson_shortname;
			$time_slot_data->lesson_name = $lesson_name;
			$time_slot_data->lesson_location = $lesson_location;
			if ( $group_code != null ) {
				if (array_key_exists($group_code, $classroom_groups_colours)) {
					$time_slot_data->classroom_group_colour = $classroom_groups_colours[$group_code];
				} 
			}
			if ( $study_module_id != null ) {
				if (array_key_exists($study_module_id, $study_modules_colours)) {
					$time_slot_data->lesson_colour = $study_modules_colours[$study_module_id];
				}
			}

   			$all_time_slots_reduced[$time_slot_id] = $time_slot_data;
		}
		
		$data['all_time_slots']=$all_time_slots;
		$data['all_time_slots_reduced']=$all_time_slots_reduced;
		
		//Obtain all teacher groups for selected date		

		if(isset($group_code)){
			$data['$group_code'] = $group_code;	
		}	

		$data['check_attendance_day']="TODO";
		$data['check_attendance_table_title']=lang('check_attendance_table_title');
		$data['choose_date_string']=lang('choose_date_string');
		$data['today']=date('d-m-Y');

		$teacher_groups_current_day=array();
		
		/* Llista alumnes grup */

        $default_group_code = $group_code;
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;

        $data['all_groups']=$all_groups->result();

        $data['all_groups']=$all_groups->result();
        $data['photo'] = false;
        if ($group_code) {
            $data['selected_group']= urldecode($group_code);
                $data['photo'] = true;
        }   else {
            $data['selected_group']=$default_group_code;
        }
		/* fi llista alumnes grup */
		$this->load->view('attendance/check_attendance',$data);
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		
	}

	protected function _alt_assign_colours($items,$item_id) {
        $items_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-greenyellow " ,
                   2 => "btn-darkred",
                   3 => "btn-coral",
                   4 => "btn-olivedrab",
                   5 => "btn-yellowgreen",
                   6 => "btn-mignightblue",
                   7 => "btn-chocolate",
                   8 => "btn-crimson",
                   9 => "btn-default",
                   0 => "btn-darkslategray"
                   );
        $index=1;
        if ( is_array ( $items )) {
        	foreach ($items as $item) {
            	$items_colours[$item->$item_id] = $bootstrap_button_colours[$index];
            	$index++;
        	}
        }
            
        return $items_colours;
    }

	protected function _assign_colours($items,$item_id) {
        $items_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info"    ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger"  ,
                   6 => "btn-sadlebrown" ,
                   7 => "btn-purple" ,
                   8 => "btn-gold" ,
                   9 => "btn-palegreen" ,
                   10 => "btn-lightgray" ,
                   11 => "btn-greenyellow" ,
                   12 => "btn-chocolate",
                   13 => "btn-coral",
                   14 => "btn-olivedrab",
                   15 => "btn-yellowgreen",
                   16 => "btn-mignightblue",
                   17 => "btn-darkred",
                   18 => "btn-crimson",
                   19 => "btn-default",
                   20 => "btn-darkslategray"
                   );
        $index=1;
        if ( is_array ( $items )) {
        	foreach ($items as $item) {
            	$items_colours[$item->$item_id] = $bootstrap_button_colours[$index];
            	$index++;
        	}
        }
            
        return $items_colours;
    }

	public function index() {
		$this->check_attendance();
	}

    public function load_datatables_data() {

        //CSS
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery-ui.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));  
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");                     
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js")); 
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));   
        
        $this->_load_html_header($header_data);
        //$this->_load_html_header($header_data); 
        
        $this->_load_body_header();     

    }	
	
public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}

public function add_field_callback_entryDate(){  
      $data= date('d/m/Y H:i:s', time());
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function edit_field_callback_entryDate($value, $primary_key){  
    //$this->session->flashdata('table_name');
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
    }
    
public function edit_callback_last_update($value, $primary_key){ 
    //$this->session->flashdata('table_name'); 
     return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', time()) .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
    }   

//UPDATE AUTOMATIC FIELDS BEFORE INSERT
function before_insert_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['entryDate'] = $data;
        
        $post_array['creationUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

//UPDATE AUTOMATIC FIELDS BEFORE UPDATE
function before_update_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['last_update'] = $data;
        
        $post_array['lastupdateUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

}
