<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class attendance_reports extends skeleton_main {

    public $body_header_view ='include/ebre_escool_body_header.php' ;

    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;

	
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('attendance_model');
        $this->load->library('ebre_escool_ldap');
        $this->config->load('managment');

        // Load FPDF        
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $this->load->library('pdf'); // Load library
		$this->pdf->fontpath = 'font/'; // Specify font folder

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        

        $this->lang->load('ebre_escool_ldap', $current_language);
        $this->lang->load('attendance',$current_language);        

        
        //LANGUAGE HELPER:
        $this->load->helper('language');
        
	}

    /* ASSISTÈNCIA - INFORMES DE CENTRE */

    function informe_centre_d_h_1() { // Incidències del centre del dia d hora h

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_center_by_d_h_1';

        $this->load_datatables_data($active_menu);

        $data = array();
        $data['title']=lang('reports_educational_center_reports_incidents_by_day_and_hour');
        $data['post'] = $_POST;

        // Hores de classe
        /*
        array( 1 => '8:00-9:00', 2 => '9:00-10:00', 3 => '10:00-11:00', 4 => '11:30-12:30', 
               5 => '12:30-13:30', 6 => '13:30-14:30', 7 => '15:30-16:30', 8 => '16:30-17:30',
               9 => '17:30-18:30', 10 => '19:00-20:00', 11 => '20:00-21:00', 12 => '21:00-22:00');
        */
        $data['time_slots'] = $this->attendance_model->getAllTimeSlots()->result_array();

        // Guardo els tipus de falta que s'han sel·leccionat
        $selected_incident_type = array();
        foreach($_POST as $k=>$v){
            if($k!="data" && $k!="hora"){
                $selected_incident_type[] = $v;    
            }    
        }
        if(count($selected_incident_type)==0){
            $selected_incident_type='';
        }

        $falta ='';

        // Mirar als elements del $_POST si hi ha algun tipus de falta sel·leccionat
        foreach ($_POST as $key=>$val){
            if($key!='data' and $key!='hora'){
                $falta .= $key." ";
            }
        }
        
        // Guardem la data i hora sel·leccionades, si ho hi ha data i hora selecionades per defecte és la data d'avui i el primer timeslot
        $group = new stdClass;
        if(isset($_POST['data'])){
            $selected_date=$_POST['data'];
        } else {
            $selected_date=date("d-m-Y");
        }
        if(isset($_POST['hora'])){
            $selected_hour=$_POST['hora'];            
        } else {
            $selected_hour=1;
        }

        $faltes = $this->attendance_model->getAllIncidentsByDateTime($selected_date,$selected_hour,$selected_incident_type);

        $num_faltes = count($faltes);

        $i=0;
        if($faltes){
        foreach($faltes as $falta){
            $data['incident'][$i]['student'] = "(".$falta->student_id.") ".$falta->student_name." ".$falta->student_sn1." ".$falta->student_sn2;
            $data['incident'][$i]['teacher'] = "(".$falta->teacher_id.") ".$falta->teacher_name." ".$falta->teacher_sn1." ".$falta->teacher_sn2;
            switch($falta->type){
                case 1: $data['incident'][$i]['incident'] = 'F'; break;
                case 2: $data['incident'][$i]['incident'] = 'FJ'; break;
                case 3: $data['incident'][$i]['incident'] =  'R'; break;
                case 4: $data['incident'][$i]['incident'] = 'RJ'; break;
                case 5: $data['incident'][$i]['incident'] =  'E'; break;
                default: $data['incident'][$i]['incident'] =  ''; break;
            }

            //$data['incidencia'][$i]['incidencia'] = $falta->type;
            $data['incident'][$i]['day'] = date("d-m-Y", strtotime($falta->day));
            $data['incident'][$i]['hour'] = $falta->timeslot;

            $data['incident'][$i]['start_time'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_start_time'];
            $data['incident'][$i]['end_time'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_end_time'];

            $data['incident'][$i]['group'] = $falta->group;
            $data['incident'][$i]['study_module'] = $falta->study_module;

            $i++;
            }
        } else {
            $data['incident'] = false;
        }

        //$this->load_header();  
        $this->load->view('attendance_reports/informe_centre_d_h_1.php',$data);     
        $this->load_footer();
    }

    function informe_centre_di_df_1() { // Incidències del centre entre una data inicial i una data final

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_center_by_id_fd_1';

        $this->load_datatables_data($active_menu);

        $data= array();
        $data['title']=lang('reports_educational_center_reports_incidents_by_date');
        $data['post'] = $_POST;

        // Guardo els tipus de falta que s'han sel·leccionat
        $selected_incident_type = array();
        foreach($_POST as $k=>$v){
            if($k!="data_inicial" && $k!="data_final"){
                $selected_incident_type[] = $v;    
            }    
        }
        if(count($selected_incident_type)==0){
            $selected_incident_type='';
        }

        $falta ='';

        $data['time_slots'] = $this->attendance_model->getAllTimeSlots()->result_array();        

        // Mirar als elements del $_POST si hi ha algun tipus de falta sel·leccionat
        foreach ($_POST as $key=>$val){
            if($key!='data_inicial' and $key!='data_final'){
                $falta .= $key." ";
            }
        }
        
        // Guardem la data i hora sel·leccionades, si ho hi ha data i hora selecionades per defecte és la data d'avui i el primer timeslot
        $group = new stdClass;
        if(isset($_POST['data_inicial'])){
            $first_selected_date=$_POST['data_inicial'];
        } else {
            $first_selected_date=date("d-m-Y");
        }
        if(isset($_POST['data_final'])){
            $last_selected_date=$_POST['data_final'];            
        } else {
            $last_selected_date=date("d-m-Y");
        }

        $faltes = $this->attendance_model->getAllIncidentsBetweenDates($first_selected_date,$last_selected_date,$selected_incident_type);

        $num_faltes = count($faltes);

        $i=0;
        if($faltes){
        foreach($faltes as $falta){
            $data['incident'][$i]['student'] = "(".$falta->student_id.") ".$falta->student_name." ".$falta->student_sn1." ".$falta->student_sn2;
            $data['incident'][$i]['teacher'] = "(".$falta->teacher_id.") ".$falta->teacher_name." ".$falta->teacher_sn1." ".$falta->teacher_sn2;
            switch($falta->type){
                case 1: $data['incident'][$i]['incident'] = 'F'; break;
                case 2: $data['incident'][$i]['incident'] = 'FJ'; break;
                case 3: $data['incident'][$i]['incident'] =  'R'; break;
                case 4: $data['incident'][$i]['incident'] = 'RJ'; break;
                case 5: $data['incident'][$i]['incident'] =  'E'; break;
                default: $data['incident'][$i]['incident'] =  ''; break;
            }

            //$data['incidencia'][$i]['incidencia'] = $falta->type;
            $data['incident'][$i]['day'] = date("d-m-Y", strtotime($falta->day));
            $data['incident'][$i]['hour'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_start_time']."-".$data['time_slots'][($falta->timeslot)-1]['time_slot_end_time'];
            $data['incident'][$i]['group'] = $falta->group;
            $data['incident'][$i]['study_module'] = $falta->study_module;

            $i++;
            }
        } else {
            $data['incident'] = false;
        }

        //$this->load_header();  
        $this->load->view('attendance_reports/informe_centre_di_df_1.php',$data);     
        $this->load_footer();


    }

    function informe_centre_ranking_di_df_1() { // Rànquing incidències del centre entre una data inicial i una data final

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_center_ranking_id_fd_1';

        $this->load_datatables_data($active_menu);

        $data= array();
        $data['title']=lang('reports_educational_center_reports_incidents_by_date_ranking');
        $data['post'] = $_POST;

        $top = 10;

        // $top = nº incidències a mostrar
        if(isset($_POST['top']))
        {
            $top = $_POST['top'];
        }
        $data['top'] = $top;

        // Guardo els tipus de falta que s'han sel·leccionat
        $selected_incident_type = array();
        foreach($_POST as $key=>$val){
            if($key!="data_inicial" && $key!="data_final" && $key!='top'){
                $selected_incident_type[] = $val;    
            }    
        }
        if(count($selected_incident_type)==0){
            $selected_incident_type='';
        }

        $data['time_slots'] = $this->attendance_model->getAllTimeSlots()->result_array();        
        
        // Guardem la data i hora sel·leccionades, si ho hi ha data i hora selecionades per defecte és la data d'avui i el primer timeslot
        $group = new stdClass;
        if(isset($_POST['data_inicial'])){
            $first_selected_date=$_POST['data_inicial'];
        } else {
            $first_selected_date=date("d-m-Y");
        }
        if(isset($_POST['data_final'])){
            $last_selected_date=$_POST['data_final'];            
        } else {
            $last_selected_date=date("d-m-Y");
        }

        $faltes = $this->attendance_model->getAllIncidentsBetweenDates($first_selected_date,$last_selected_date,$selected_incident_type,$top);

        $num_faltes = count($faltes);

        $i=0;
        if($faltes){
        foreach($faltes as $falta){
            $data['incident'][$i]['student'] = "(".$falta->student_id.") ".$falta->student_name." ".$falta->student_sn1." ".$falta->student_sn2;
            $data['incident'][$i]['teacher'] = "(".$falta->teacher_id.") ".$falta->teacher_name." ".$falta->teacher_sn1." ".$falta->teacher_sn2;
            switch($falta->type){
                case 1: $data['incident'][$i]['incident'] = 'F'; break;
                case 2: $data['incident'][$i]['incident'] = 'FJ'; break;
                case 3: $data['incident'][$i]['incident'] =  'R'; break;
                case 4: $data['incident'][$i]['incident'] = 'RJ'; break;
                case 5: $data['incident'][$i]['incident'] =  'E'; break;
                default: $data['incident'][$i]['incident'] =  ''; break;
            }

            //$data['incidencia'][$i]['incidencia'] = $falta->type;
            $data['incident'][$i]['day'] = date("d-m-Y", strtotime($falta->day));
            $data['incident'][$i]['hour'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_start_time']."-".$data['time_slots'][($falta->timeslot)-1]['time_slot_end_time'];
            $data['incident'][$i]['group'] = $falta->group;
            $data['incident'][$i]['study_module'] = $falta->study_module;

            $i++;
            }
        } else {
            $data['incident'] = false;
        }

        //$this->load_header();   
        $this->load->view('attendance_reports/informe_centre_ranking_di_df_1.php',$data);     
        $this->load_footer();    
    }

    function Llistat_grup_tutor() { // Tutors de Grup

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_mentor_list';

        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        
        $default_group_code = $this->config->item('default_group_code');
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_teachers") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();

        $all_groups = $this->attendance_model->get_all_classroom_groups();
        $data['group_code']=$group_code;
        $data['all_groups']=$all_groups->result();
        
        if (isset($group_code)) {
            $data['selected_group']= urldecode($group_code);
        }   else {
            $data['selected_group']=$default_group_code;
        }
        
       // $students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
       // $default_group_dn=$students_base_dn;
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
        
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_teachers"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
        
       // $data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
        

        $data['all_teachers']= $this->ebre_escool_ldap->getAllTeachers("ou=Profes,ou=All,dc=iesebre,dc=com");
        $data['all_conserges']= $this->ebre_escool_ldap->getAllTeachers("ou=Consergeria,ou=Personal,ou=All,dc=iesebre,dc=com");
        $data['all_secretaria']= $this->ebre_escool_ldap->getAllTeachers("ou=Secretaria,ou=Personal,ou=All,dc=iesebre,dc=com");
        //Total de professors
        $data['count_teachers'] = count($data['all_teachers']);
        $data['count_conserges'] = count($data['all_conserges']);
        $data['count_secretaria'] = count($data['all_secretaria']);                
        $data['empleat']= $this->ebre_escool_ldap->getEmailAndPhotoData("ou=Profes,ou=All,dc=iesebre,dc=com");
/**/
        //$this->load_header();  
        //$this->load->view('attendance_reports/Llistat_grup_tutor.php',$data);     
        $this->load->view('attendance_reports/Llistat_grup_tutor.php',$data);     
        $this->load_footer();     
    }     

    function mailing_list_report() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#report_mailing_list';

        $this->load_header($active_menu);    

        $data['title']=lang('reports_educational_center_reports_student_emails');
        $this->load->view('attendance_reports/mailing_list_report.php',$data);     
        $this->load_footer();      
    }  

    /* ASSISTÈNCIA - INFORMES DE GRUP */

    function class_list_report() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#report_group';
        $active_menu['submenu2']='#report_class_list';

/*
        $data['grups'] = array( "1AF" => "1AF - *1r Adm.Finan (S) - CF",
                                "1APD" => "1APD - *1r Atenc. Persones Dep.M) - CF",
                                "1ASIX-DAM" => "1ASIX-DAM - *1r Inform. superior (S)L - CF",
                                "1DIE" => "1DIE - 1r Diet - CF",
                                "1EE" => "1EE - *1r Efic. Energ.(S) L - CF",
                                "1EIN" => "1EIN - *1r Educaci - CF",
                                "1ES" => "1ES - *1r Emerg. Sanit.(M)L - CF",
                                "1FAR" => "1FAR - *1r Farm - CF",
                                "1GAD" => "1GAD - *Gesti - CF",
                                "1IEA" => "1IEA - *1r Ins.Elec. Autom(M)L - CF",
                                "1IME" => "1IME - *1r Ins. Mant. Elec.(M) - CF",
                                "1INS A" => "1INS A - *1r Int.Soc.(S)L - CF",
                                "1INS B" => "1INS B - 1r Int. Soc.(S)L - CF",
                                "1LDC" => "1LDC - *1r Lab. Diagnosi C (S). - CF",
                                "1MEC" => "1MEC - *1r Mecanitzaci - CF",
                                "1PM" => "1PM - *1r Prod. Mecanitza(S)L. - CF",
                                "1PRO" => "1PRO - *1r D. A. Projec. C (S) L - CF",
                                "1PRP" => "1PRP - 1r Prev. Riscos Prof.(S) - CF",
                                "1SEA" => "1SEA - i automa (S) - CF",
                                "1SMX A" => "1SMX A - *1r Inform Mitj - CF",
                                "1SMX B" => "1SMX B - *1r Inform. mitj - CF",
                                "1STI" => "1STI - 1r Sis. Teleco. Infor (S) - CF",
                                "2AF" => "2AF - 2n Ad. Finan (S) - CF",
                                "2APD" => "2APD - 2n Atenc. Persones Dep.M) - CF",
                                "2ASIX" => "2ASIX - 2n Adm Sist Inf xarxa(S)L - CF",
                                "2DAM" => "2DAM - 2n Desenv Aplic Mult (S)L - CF",
                                "2DIE" => "2DIE - 2n Diet - CF",
                                "2EE" => "2EE - 2 Efic.Energ.(S) L - CF",
                                "2EIN" => "2EIN - 2n Educaci - CF",
                                "2ES" => "2ES - 2n Emerg. Sanit.(M) - CF",
                                "2FAR" => "2FAR - 2n Farm - CF",
                                "2GAD" => "2GAD - 2n Gest. Adm. (M)L - CF",
                                "2IEA" => "2IEA - *2n Ins.Elec,Autom(M)L - CF",
                                "2IME" => "2IME - 2n Ins. Mant. Elec.(M) - CF",
                                "2INS A" => "2INS A - 2n Integraci - CF",
                                "2INS B" => "2INS B - 2n Integraci - CF",
                                "2LDC" => "2LDC - 2n Lab. Diagnosi C(S) - CF",
                                "2MEC" => "2MEC - 2n Mecanitzaci - CF",
                                "2PM" => "2PM - *2n Prod. Mecanitza.(S) L - CF",
                                "2PRO" => "2PRO - 2n D. A. Projec. C (S) - CF",
                                "2PRP" => "2PRP - 2n Prev. Riscos Prof.(S) - CF",
                                "2SEA" => "2SEA - *2n Sist. Electri i automa (S) - CF",
                                "2SIC" => "2SIC - 2n Soldadura i caldereria (M)  - CF",
                                "2SMX" => "2SMX - 2n Inform. Mitj - CF",
                                "2STI" => "2STI - 2n Sis. teleco. Infor (S) - CF",
                                "CAIA" => "CAIA - *Cures Auxiliar Inf(M) - CF",
                                "CAIB" => "CAIB - *Cures Auxiliar Inf(M) - CF",
                                "CAIC" => "CAIC - Cures Auxiliar Inf(M) - CF",
                                "CAM" => "CAM - *Curs Acc - CF",
                                "CAS A" => "CAS A - *Curs Acc - CF",
                                "CAS B" => "CAS B - *Curs Acc - CF",
                                "CAS C" => "CAS C - Curs Acc - CF",
                                "COM" => "COM - *Comer - CF",
                                "GCM" => "GCM - Ges. Comer. Mar.(S) - CF",
                                "SE" => "SE - Secretariat (S) - CF"
            );
*/
        $data['title']=lang('reports_group_reports_class_list');
        
        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        // Get All groups
        $grups = $this->attendance_model->get_all_groups();
        $data['grups'] = $grups;

        $default_group_code = $this->config->item('default_group_code');
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
        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
            if (isset($_POST['foto'])){
                $data['photo'] = true;
            }
        }   else {
            $data['selected_group']=$default_group_code;
        }
       // echo $data['selected_group'];
       // $students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
       // $default_group_dn=$students_base_dn;
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
        
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
  
        $estudiants_grup = $this->attendance_model->getAllGroupStudentInfo($data['selected_group']);
        $data['all_students_in_group'] = $estudiants_grup;
        //print_r($estudiants_grup);
      /* $data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);*/
        //Total Alumnes
        $data['count_alumnes'] = count($data['all_students_in_group']);
        //$data['empleat']= $this->ebre_escool_ldap->getEmailAndPhotoData("ou=Profes,ou=All,dc=iesebre,dc=com");

//      $this->load_header();  

        if(!$_POST){
            $this->load->view('attendance_reports/class_list_report.php', $data); 
        } else {
            $this->load->view('attendance_reports/class_list_report_pdf.php', $data); 
        } 
        
        $this->load_footer();      
    }

    function class_sheet_report() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#report_group';
        $active_menu['submenu2']='#report_class_sheet';

        $data['title'] = lang('reports_group_reports_student_sheet');

        $data['grups'] = array( "1AF" => "1AF - *1r Adm.Finan (S) - CF",
                                "1APD" => "1APD - *1r Atenc. Persones Dep.M) - CF",
                                "1ASIX-DAM" => "1ASIX-DAM - *1r Inform. superior (S)L - CF",
                                "1DIE" => "1DIE - 1r Diet - CF",
                                "1EE" => "1EE - *1r Efic. Energ.(S) L - CF",
                                "1EIN" => "1EIN - *1r Educaci - CF",
                                "1ES" => "1ES - *1r Emerg. Sanit.(M)L - CF",
                                "1FAR" => "1FAR - *1r Farm - CF",
                                "1GAD" => "1GAD - *Gesti - CF",
                                "1IEA" => "1IEA - *1r Ins.Elec. Autom(M)L - CF",
                                "1IME" => "1IME - *1r Ins. Mant. Elec.(M) - CF",
                                "1INS A" => "1INS A - *1r Int.Soc.(S)L - CF",
                                "1INS B" => "1INS B - 1r Int. Soc.(S)L - CF",
                                "1LDC" => "1LDC - *1r Lab. Diagnosi C (S). - CF",
                                "1MEC" => "1MEC - *1r Mecanitzaci - CF",
                                "1PM" => "1PM - *1r Prod. Mecanitza(S)L. - CF",
                                "1PRO" => "1PRO - *1r D. A. Projec. C (S) L - CF",
                                "1PRP" => "1PRP - 1r Prev. Riscos Prof.(S) - CF",
                                "1SEA" => "1SEA - i automa (S) - CF",
                                "1SMX A" => "1SMX A - *1r Inform Mitj - CF",
                                "1SMX B" => "1SMX B - *1r Inform. mitj - CF",
                                "1STI" => "1STI - 1r Sis. Teleco. Infor (S) - CF",
                                "2AF" => "2AF - 2n Ad. Finan (S) - CF",
                                "2APD" => "2APD - 2n Atenc. Persones Dep.M) - CF",
                                "2ASIX" => "2ASIX - 2n Adm Sist Inf xarxa(S)L - CF",
                                "2DAM" => "2DAM - 2n Desenv Aplic Mult (S)L - CF",
                                "2DIE" => "2DIE - 2n Diet - CF",
                                "2EE" => "2EE - 2 Efic.Energ.(S) L - CF",
                                "2EIN" => "2EIN - 2n Educaci - CF",
                                "2ES" => "2ES - 2n Emerg. Sanit.(M) - CF",
                                "2FAR" => "2FAR - 2n Farm - CF",
                                "2GAD" => "2GAD - 2n Gest. Adm. (M)L - CF",
                                "2IEA" => "2IEA - *2n Ins.Elec,Autom(M)L - CF",
                                "2IME" => "2IME - 2n Ins. Mant. Elec.(M) - CF",
                                "2INS A" => "2INS A - 2n Integraci - CF",
                                "2INS B" => "2INS B - 2n Integraci - CF",
                                "2LDC" => "2LDC - 2n Lab. Diagnosi C(S) - CF",
                                "2MEC" => "2MEC - 2n Mecanitzaci - CF",
                                "2PM" => "2PM - *2n Prod. Mecanitza.(S) L - CF",
                                "2PRO" => "2PRO - 2n D. A. Projec. C (S) - CF",
                                "2PRP" => "2PRP - 2n Prev. Riscos Prof.(S) - CF",
                                "2SEA" => "2SEA - *2n Sist. Electri i automa (S) - CF",
                                "2SIC" => "2SIC - 2n Soldadura i caldereria (M)  - CF",
                                "2SMX" => "2SMX - 2n Inform. Mitj - CF",
                                "2STI" => "2STI - 2n Sis. teleco. Infor (S) - CF",
                                "CAIA" => "CAIA - *Cures Auxiliar Inf(M) - CF",
                                "CAIB" => "CAIB - *Cures Auxiliar Inf(M) - CF",
                                "CAIC" => "CAIC - Cures Auxiliar Inf(M) - CF",
                                "CAM" => "CAM - *Curs Acc - CF",
                                "CAS A" => "CAS A - *Curs Acc - CF",
                                "CAS B" => "CAS B - *Curs Acc - CF",
                                "CAS C" => "CAS C - Curs Acc - CF",
                                "COM" => "COM - *Comer - CF",
                                "GCM" => "GCM - Ges. Comer. Mar.(S) - CF",
                                "SE" => "SE - Secretariat (S) - CF"
            );

/**/
        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        
        $default_group_code = $this->config->item('default_group_code');
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;

        $data['all_groups']=$all_groups->result();

        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
        }   else {
            $data['selected_group']=$default_group_code;
        }

        

       // echo $data['selected_group'];
       // $students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
       // $default_group_dn=$students_base_dn;
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
        
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
        
       $data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
       
        //$data['all_students']= $this->ebre_escool_ldap->getAllGroupStudentsInfo("ou=Alumnes,ou=All,dc=iesebre,dc=com");
        //Total de professors
        $data['count_alumnes'] = count($data['all_students_in_group']);
        //$data['empleat']= $this->ebre_escool_ldap->getEmailAndPhotoData("ou=Profes,ou=All,dc=iesebre,dc=com");

/**/


        //$this->load_header();
        if(!$_POST){
            $this->load->view('attendance_reports/class_sheet_report.php', $data); 
        } else {
            $this->load->view('attendance_reports/class_sheet_report_pdf.php', $data); 
        }
        $this->load_footer();       
    }

    function informe_resum_grup_di_df_1() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#report_group';
        $active_menu['submenu2']='#report_group_incidents_by_id_fd_1';

        $data['title'] = lang('reports_group_reports_incidents_by_date');

        $data['grups'] = array( "1AF" => "1AF",
                                "1APD" => "1APD",
                                "1ASIX-DAM" => "1ASIX-DAM",
                                "1DIE" => "1DIE",
                                "1EE" => "1EE",
                                "1EIN" => "1EIN",
                                "1ES" => "1ES",
                                "1FAR" => "1FAR",
                                "1GAD" => "1GAD",
                                "1IEA" => "1IEA",
                                "1IME" => "1IME",
                                "1INS A" => "1INS A",
                                "1INS B" => "1INS B",
                                "1LDC" => "1LDC",
                                "1MEC" => "1MEC",
                                "1PM" => "1PM",
                                "1PRO" => "1PRO",
                                "1PRP" => "1PRP",
                                "1SEA" => "1SEA",
                                "1SMX A" => "1SMX A",
                                "1SMX B" => "1SMX B",
                                "1STI" => "1STI",
                                "2AF" => "2AF",
                                "2APD" => "2APD",
                                "2ASIX" => "2ASIX",
                                "2DAM" => "2DAM",
                                "2DIE" => "2DIE",
                                "2EE" => "2EE",
                                "2EIN" => "2EIN",
                                "2ES" => "2ES",
                                "2FAR" => "2FAR",
                                "2GAD" => "2GAD",
                                "2IEA" => "2IEA",
                                "2IME" => "2IME",
                                "2INS A" => "2INS A",
                                "2INS B" => "2INS B",
                                "2LDC" => "2LDC",
                                "2MEC" => "2MEC",
                                "2PM" => "2PM",
                                "2PRO" => "2PRO",
                                "2PRP" => "2PRP",
                                "2SEA" => "2SEA",
                                "2SIC" => "2SIC",
                                "2SMX" => "2SMX",
                                "2STI" => "2STI",
                                "CAIA" => "CAIA",
                                "CAIB" => "CAIB",
                                "CAIC" => "CAICF",
                                "CAM" => "CAM",
                                "CAS A" => "CAS A",
                                "CAS B" => "CAS B",
                                "CAS C" => "CAS C",
                                "COM" => "COM",
                                "GCM" => "GCM",
                                "SE" => "SE"
            );

        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        
        $default_group_code = $this->config->item('default_group_code');
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;
        $data['all_groups']=$all_groups->result();
        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
        } else {
            $data['selected_group']=$default_group_code;
        }

        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);

        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
        
        $data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
        $data['count_alumnes'] = count($data['all_students_in_group']);


//        $this->load_header(); 
        $this->load->view('attendance_reports/informe_resum_grup_di_df_1.php',$data);     
        $this->load_footer();    
    }

    function informe_resum_grup_faltes_mes_1() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#report_group';
        $active_menu['submenu2']='#report_group_monthly';

        $data['title'] = lang('reports_group_reports_monthly_report');

        $data['grups'] = array( "1AF" => "1AF - *1r Adm.Finan (S) - CF",
                                "1APD" => "1APD - *1r Atenc. Persones Dep.M) - CF",
                                "1ASIX-DAM" => "1ASIX-DAM - *1r Inform. superior (S)L - CF",
                                "1DIE" => "1DIE - 1r Diet - CF",
                                "1EE" => "1EE - *1r Efic. Energ.(S) L - CF",
                                "1EIN" => "1EIN - *1r Educaci - CF",
                                "1ES" => "1ES - *1r Emerg. Sanit.(M)L - CF",
                                "1FAR" => "1FAR - *1r Farm - CF",
                                "1GAD" => "1GAD - *Gesti - CF",
                                "1IEA" => "1IEA - *1r Ins.Elec. Autom(M)L - CF",
                                "1IME" => "1IME - *1r Ins. Mant. Elec.(M) - CF",
                                "1INS A" => "1INS A - *1r Int.Soc.(S)L - CF",
                                "1INS B" => "1INS B - 1r Int. Soc.(S)L - CF",
                                "1LDC" => "1LDC - *1r Lab. Diagnosi C (S). - CF",
                                "1MEC" => "1MEC - *1r Mecanitzaci - CF",
                                "1PM" => "1PM - *1r Prod. Mecanitza(S)L. - CF",
                                "1PRO" => "1PRO - *1r D. A. Projec. C (S) L - CF",
                                "1PRP" => "1PRP - 1r Prev. Riscos Prof.(S) - CF",
                                "1SEA" => "1SEA - i automa (S) - CF",
                                "1SMX A" => "1SMX A - *1r Inform Mitj - CF",
                                "1SMX B" => "1SMX B - *1r Inform. mitj - CF",
                                "1STI" => "1STI - 1r Sis. Teleco. Infor (S) - CF",
                                "2AF" => "2AF - 2n Ad. Finan (S) - CF",
                                "2APD" => "2APD - 2n Atenc. Persones Dep.M) - CF",
                                "2ASIX" => "2ASIX - 2n Adm Sist Inf xarxa(S)L - CF",
                                "2DAM" => "2DAM - 2n Desenv Aplic Mult (S)L - CF",
                                "2DIE" => "2DIE - 2n Diet - CF",
                                "2EE" => "2EE - 2 Efic.Energ.(S) L - CF",
                                "2EIN" => "2EIN - 2n Educaci - CF",
                                "2ES" => "2ES - 2n Emerg. Sanit.(M) - CF",
                                "2FAR" => "2FAR - 2n Farm - CF",
                                "2GAD" => "2GAD - 2n Gest. Adm. (M)L - CF",
                                "2IEA" => "2IEA - *2n Ins.Elec,Autom(M)L - CF",
                                "2IME" => "2IME - 2n Ins. Mant. Elec.(M) - CF",
                                "2INS A" => "2INS A - 2n Integraci - CF",
                                "2INS B" => "2INS B - 2n Integraci - CF",
                                "2LDC" => "2LDC - 2n Lab. Diagnosi C(S) - CF",
                                "2MEC" => "2MEC - 2n Mecanitzaci - CF",
                                "2PM" => "2PM - *2n Prod. Mecanitza.(S) L - CF",
                                "2PRO" => "2PRO - 2n D. A. Projec. C (S) - CF",
                                "2PRP" => "2PRP - 2n Prev. Riscos Prof.(S) - CF",
                                "2SEA" => "2SEA - *2n Sist. Electri i automa (S) - CF",
                                "2SIC" => "2SIC - 2n Soldadura i caldereria (M)  - CF",
                                "2SMX" => "2SMX - 2n Inform. Mitj - CF",
                                "2STI" => "2STI - 2n Sis. teleco. Infor (S) - CF",
                                "CAIA" => "CAIA - *Cures Auxiliar Inf(M) - CF",
                                "CAIB" => "CAIB - *Cures Auxiliar Inf(M) - CF",
                                "CAIC" => "CAIC - Cures Auxiliar Inf(M) - CF",
                                "CAM" => "CAM - *Curs Acc - CF",
                                "CAS A" => "CAS A - *Curs Acc - CF",
                                "CAS B" => "CAS B - *Curs Acc - CF",
                                "CAS C" => "CAS C - Curs Acc - CF",
                                "COM" => "COM - *Comer - CF",
                                "GCM" => "GCM - Ges. Comer. Mar.(S) - CF",
                                "SE" => "SE - Secretariat (S) - CF"
            );

            $data['mes'] = array( "1" => "Gener",
                                  "2" => "Febrer",
                                  "3" => "Març",
                                  "4" => "Abril",
                                  "5" => "Maig",
                                  "6" => "Juny",
                                  "7" => "Juliol",
                                  "8" => "Agost",
                                  "9" => "Setembre",
                                  "10" => "Octubre",
                                  "11" => "Novembre",
                                  "12" => "Desembre"
            );

            $data['any'] = array( "2013" => "2013",
                                  "2012" => "2012",
                                  "2011" => "2011",
                                  "2010" => "2010",
                                  "2009" => "2009",
                                  "2008" => "2008"
            );

        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        
        $default_group_code = $this->config->item('default_group_code');
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;
        $data['all_groups']=$all_groups->result();
        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
        } else {
            $data['selected_group']=$default_group_code;
        }

        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);

        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
        
        $data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
        $data['count_alumnes'] = count($data['all_students_in_group']);


//        $this->load_header(); 
        $this->load->view('attendance_reports/informe_resum_grup_faltes_mes_1.php',$data);     
        $this->load_footer();    
    }

    function load_header($active_menu) {

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
                base_url('assets/css/select2.css'));
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
/*
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));          
*/
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");   
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/select2.min.js'));

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

        $this->_load_html_header($header_data); 
        $this->_load_body_header();
    }

    function load_footer() {

        $this->_load_body_footer();    

    }

    public function load_datatables_data($active_menu) {

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
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/select2.css'));

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
/*
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));          
*/
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
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/select2.min.js'));        
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

        $this->_load_html_header($header_data);
        //$this->_load_html_header($header_data); 
        
        $this->_load_body_header();     

    }
/*
    public function load_active_menu($active_menu){
        $header_data['menu']= $active_menu;
        $this->_load_html_header($header_data);
        $this->_load_body_header();

    }
*/
    public function informeGuifi() {

        $this->load_header();   
        $this->load->view('attendance_reports/informe_guifi.php');     
        $this->load_footer();

    }

 }   
