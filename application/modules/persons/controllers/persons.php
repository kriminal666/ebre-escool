<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class persons extends skeleton_main {
	
	public $body_header_view ='include/intranet_body_header' ;
	
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
		$this->lang->load('persons', $current_language);	       

		
        //LANGUAGE HELPER:
        $this->load->helper('language');
	}

	public function person_official_id_type() {
		$table_name="person_official_id_type";
        $this->grocery_crud->set_table($table_name);  
		
		//Establish subject:
        $this->grocery_crud->set_subject("Tipus identificador personal");
        
        /*
        $this->grocery_crud->display_as('person_id',lang('person_id'));
       	$this->grocery_crud->display_as('person_givenName',lang('person_givenName'));       
       	*/

        $output = $this->grocery_crud->render();
		
		$this->_load_html_header($this->_get_html_header_data(),$output); 
		$this->_load_body_header();
	
		$this->load->view('person_official_id_type',$output); 
                
		$this->_load_body_footer();	 

	}

	

	public function valida_nif_cif_nie($cif,$type) {
		//Copyright ©2005-2011 David Vidal Serra. Bajo licencia GNU GPL.
		//Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
		//puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt(1)
		//Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
		//con la condicion de que el autor jamas sera responsable de su uso.
		//Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad

		 $cif = strtoupper($cif);
         for ($i = 0; $i < 9; $i ++)
         {
                  $num[$i] = substr($cif, $i, 1);
         }
		//si no tiene un formato valido devuelve error
         if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif))
         {
         		  $this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct1'));
                  return false;
         }
		//comprobacion de NIFs estandar
         if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif))
         {
                  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
                  {
                           if ($type==1)
                           		return true;
                           else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct3'));
                           		return false;        	
                           }
                  }
                  else
                  {
                  		   $this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct2'));
                           return false;
                  }
         }
			//algoritmo para comprobacion de codigos tipo CIF
         $suma = $num[2] + $num[4] + $num[6];
         for ($i = 1; $i < 8; $i += 2)
         {
                  $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]), 1, 1);
         }
         $n = 10 - substr($suma, strlen($suma) - 1, 1);
		//comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
         if (preg_match('/^[KLM]{1}/', $cif))
         {
                  if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
                  {
                  		if ($type==1)
                           		return true;
                        else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct3'));
                           		return false;        	
                        }
                  }
                  else
                  {
                           return false;
                  }
         }
		//comprobacion de CIFs
         if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif))
         {
                  if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
                  {
                        if ($type==1)
                           		return true;
                        else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct3'));
                           		return false;        	
                        }
                  }
                  else
                  {
                           return false;
                  }
         }
		//comprobacion de NIEs
         if (preg_match('/^[XYZ]{1}/', $cif))
         {
                  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
                  {
                           if ($type==2)
                           		return true;
                        	else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct5'));
                           		return false;        	
                        	}
                  }
                  else
                  {
                  		   $this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct4'));
                           return false;
                  }
         }
		//si todavia no se ha verificado devuelve error
         return false;
	}


	public function _callback_person_bank_account_id_url($value, $row)	{
		if (isset($row->person_bank_account_id))
			return "<a href='". base_url('/index.php/banks/bank_account/edit/') . "/" . $row->person_bank_account_id ."'>". $value . "</a>";
		else
			return $value;
	}

	public function _callback_person_locality_id_url($value, $row)	{
		if (isset($row->person_locality_id))
			return "<a href='". base_url('/index.php/persons/localities/edit/') . "/" . $row->person_locality_id ."'>". $value . "</a>";
		else
			return $value;
	}

	

	public function _callback_person_email_url($value, $row)	{
		if (isset($row->person_email))
			return "<a href='mailto:". $value . "'>" . $value . "</a>";
		 	else
			return $value;
	}

	public function _callback_person_secondary_email_url($value, $row)	{
		if (isset($row->person_secondary_email))
			return "<a href='mailto:". $value . "'>" . $value . "</a>";
		 	else
			return $value;
	}

	public function person() {
		$table_name="person";
        $this->grocery_crud->set_table($table_name);  
		
		//Establish subject:
        $this->grocery_crud->set_subject("persona");

        //RELATIONS
        $this->grocery_crud->set_relation('person_official_id_type','person_official_id_type','{person_official_id_type_shortname} - {person_official_id_type_id}',null,null,"persons");
        //$this->grocery_crud->unset_dropdowndetails("person_official_id_type");

        $this->grocery_crud->set_relation('person_locality_id','locality','{locality_name}');
        $this->grocery_crud->set_relation('person_bank_account_id','bank_account','{bank_account_entity_code}-{bank_account_office_code}-{bank_account_control_digit_code}-{bank_account_number}');
        
        $this->grocery_crud->columns('person_id','person_sn1','person_sn2','person_givenName','person_official_id','person_homePostalAddress','person_locality_id','person_email','person_telephoneNumber','person_mobile','person_gender','person_bank_account_id');

        $this->grocery_crud->add_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_creationUserId',
        	'person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->edit_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_last_update','person_creationUserId',
        	'person_lastupdateUserId','person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->unset_dropdowndetails("person_official_id_type");


        $this->grocery_crud->display_as('person_id',lang('person_id'));
       	$this->grocery_crud->display_as('person_givenName',lang('person_givenName'));       
       	$this->grocery_crud->display_as('person_sn1',lang('person_sn1'));       
       	$this->grocery_crud->display_as('person_sn2',lang('person_sn2'));
       	$this->grocery_crud->display_as('person_email',lang('person_email'));
       	$this->grocery_crud->display_as('person_secondary_email',lang('person_secondary_email'));
       	$this->grocery_crud->display_as('person_official_id',lang('person_official_id'));
       	$this->grocery_crud->display_as('person_official_id_type',lang('person_official_id_type'));
       	$this->grocery_crud->display_as('person_date_of_birth',lang('person_date_of_birth'));
       	$this->grocery_crud->display_as('person_gender',lang('person_gender'));
       	$this->grocery_crud->display_as('person_secondary_official_id',lang('person_secondary_official_id'));
       	$this->grocery_crud->display_as('person_secondary_official_id_type',lang('person_secondary_official_id_type'));
       	$this->grocery_crud->display_as('person_homePostalAddress',lang('person_homePostalAddress'));
       	$this->grocery_crud->display_as('person_photo',lang('person_photo'));
       	$this->grocery_crud->display_as('person_locality_id',lang('person_locality_id'));
       	$this->grocery_crud->display_as('person_telephoneNumber',lang('person_telephone_number'));
       	$this->grocery_crud->display_as('person_bank_account_id',lang('person_bank_account_id'));
       	$this->grocery_crud->display_as('person_notes',lang('person_notes'));
       	$this->grocery_crud->display_as('person_mobile',lang('person_mobile'));
       	$this->grocery_crud->display_as('person_entryDate',lang('person_entryDate'));
       	$this->grocery_crud->display_as('person_last_update',lang('person_last_update'));
       	$this->grocery_crud->display_as('person_creationUserId',lang('person_creationUserId'));
       	$this->grocery_crud->display_as('person_lastupdateUserId',lang('person_lastupdateUserId'));
       	$this->grocery_crud->display_as('person_markedForDeletion',lang('person_markedForDeletion'));
       	$this->grocery_crud->display_as('person_markedForDeletionDate',lang('person_markedForDeletionDate'));

 		    $this->grocery_crud->set_default_value($table_name,'person_official_id_type',1);

        //$this->grocery_crud->set_default_value($table_name,'person_creationUserId','TODO');
        $this->grocery_crud->set_default_value($table_name,'person_markedForDeletion','n');


        $this->grocery_crud->callback_column($this->_unique_field_name('person_bank_account_id'),array($this,'_callback_person_bank_account_id_url'));
        $this->grocery_crud->callback_column('person_email',array($this,'_callback_person_email_url'));
        $this->grocery_crud->callback_column('person_secondary_email',array($this,'_callback_person_secondary_email_url'));
		    $this->grocery_crud->callback_column($this->_unique_field_name('person_locality_id'),array($this,'_callback_person_locality_id_url'));
        

       	//validations:
       	$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');

       	$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');
       	$this->grocery_crud->set_rules('person_secondary_email',lang('person_secondary_email'),'valid_email');

        $this->grocery_crud->allow_save_without_validation();

        $output = $this->grocery_crud->render();
		
		$this->_load_html_header($this->_get_html_header_data(),$output); 
		$this->_load_body_header();
	
		$this->load->view('persons',$output); 
                
		$this->_load_body_footer();	 
	}

	protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

	
	public function index() {
		$this->person();
	}
	
	public function localities() {
		
		$table_name="locality";
        $this->grocery_crud->set_table($table_name);  
		
		//Establish subject:
        $this->grocery_crud->set_subject("població");
        
        //RELATIONS
        $this->grocery_crud->set_relation('locality_parent_locality_id','locality','{locality_name}');
        $this->grocery_crud->set_relation('locality_state_id','state','{state_name}');
        
        $output = $this->grocery_crud->render();
        
		$this->_load_html_header($this->_get_html_header_data(),$output); 
		$this->_load_body_header();
	
		$this->load->view('persons',$output); 
                
		$this->_load_body_footer();	 
		
	}
	
	public function states() {
		
		$table_name="state";
        $this->grocery_crud->set_table($table_name);  
		
		//Establish subject:
        $this->grocery_crud->set_subject("província");
        
        $output = $this->grocery_crud->render();
		
		$this->_load_html_header($this->_get_html_header_data(),$output); 
		$this->_load_body_header();
	
		$this->load->view('persons',$output); 
                
		$this->_load_body_footer();	 
		
	}

}
