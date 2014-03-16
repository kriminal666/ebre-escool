<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";

class skeleton extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

  	public $body_header_lang_file ='ebre_escool_body_header' ;

  	public $html_header_view ='include/ebre_escool_html_header' ;

	public $body_footer_view ='include/ebre_escool_body_footer' ;

    public $error_page_404 = "include/404.php"; 

    public $users_view = "include/users_view.php";

	public $header_data;

	function __construct()
    {
		parent::__construct();
	}
	
	public function index() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		redirect('dashboard','refresh');
		
	}

    public function error404() {
        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        parent::error404();
    }

    protected function _get_html_header_data() {

        $header_data = parent::_get_html_header_data();
        $header_data = $this->load_ace_files($header_data); 

        return $header_data;
    }

	public function groups() {

		$this->header_data = $this->load_ace_files();  

		parent::groups();
	}

	function load_ace_files($init_header_data){

		$header_data= $this->add_css_to_html_header_data(
            $init_header_data,
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
                      
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  


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

        return $header_data;
}

}

