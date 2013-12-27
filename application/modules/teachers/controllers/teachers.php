<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class teachers extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header.php' ;

  public $body_header_lang_file ='ebre_escool_body_header' ;
	
	function __construct()
    {
        parent::__construct();
        
        //GROCERY CRUD
		    $this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
    		$this->load->library('image_CRUD');  

		    /* Set language */
		    $current_language=$this->session->userdata("current_language");
		    if ($current_language == "") {
		      $current_language= $this->config->item('default_language');
		    }
		    $this->lang->load('teachers', $current_language);	       

        //LANGUAGE HELPER:
        $this->load->helper('language');
	}

	public function teacher() {
		    $table_name="teacher";
        $this->grocery_crud->set_table($table_name);  
		
		    //Establish subject:
        $this->grocery_crud->set_subject(lang('teacher'));

        //RELATIONS
        $this->grocery_crud->set_relation('teacher_person_id','person','{person_sn1} {person_sn2},{person_givenName} ({person_official_id}) - {person_id} '); 
        
        //$this->grocery_crud->unset_dropdowndetails("person_official_id_type");

        
        //$this->grocery_crud->columns('person_id','person_sn1','person_sn2','person_givenName','person_official_id','person_homePostalAddress','person_locality_id','person_email','person_telephoneNumber','person_mobile','person_gender','person_bank_account_id');

        /*$this->grocery_crud->add_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_creationUserId',
        	'person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->edit_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_last_update','person_creationUserId',
        	'person_lastupdateUserId','person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->unset_dropdowndetails("person_official_id_type");
        */

        //$this->grocery_crud->display_as('person_id',lang('person_id'));
       	//$this->grocery_crud->display_as('person_givenName',lang('person_givenName'));       
       	//$this->grocery_crud->display_as('person_sn1',lang('person_sn1'));       
       	
        //$this->grocery_crud->set_default_value($table_name,'person_creationUserId','TODO');
        //$this->grocery_crud->set_default_value($table_name,'person_markedForDeletion','n');


        //$this->grocery_crud->callback_column($this->_unique_field_name('person_bank_account_id'),array($this,'_callback_person_bank_account_id_url'));
        //$this->grocery_crud->callback_column('person_email',array($this,'_callback_person_email_url'));
        
        //validations:
       	//$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');
        //$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');
       	
        $output = $this->grocery_crud->render();
		
		    $this->_load_html_header($this->_get_html_header_data(),$output); 
		    $this->_load_body_header();
        	
		    $this->load->view('teachers',$output); 
                
		    $this->_load_body_footer();	 
	}

	protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

	
	public function index() {
		$this->teacher();
	}

}
