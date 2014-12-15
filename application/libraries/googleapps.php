<?php
/**
 * googleapps library
 *
 * Common functions
 *
 * @package    	googleapps library
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */

set_include_path(get_include_path() . PATH_SEPARATOR . 'application/third_party/google-api-php-client/src');

require_once "Google/Client.php";
require_once "Google/Service/Directory.php";
//require_once "Google/Service/PlusDomains.php";

class googleapps  {
	
    private $client_id = null;
    private $service_account_email = null;
    private $key_file = null;
    private $domain_admin_email = null;
    private $domain = null;
	
	function __construct()
    {
        $this->ci =& get_instance();
        
        // Load the language file. Example
        //$this->ci->lang->load('ebre_escool_ldap','catalan');
        //$this->ci->load->helper('language');
        
        // Load the configuration
        $this->ci->load->config('googleapps');
        
        $this->_init();
    }

    /**
     * @access private
     * @return void
     */
    private function _init() {

        $this->client_id = $this->ci->config->item('client_id');
        $this->service_account_email = $this->ci->config->item('service_account_email');
        $this->key_file = $this->ci->config->item('key_file');
        $this->domain_admin_email = $this->ci->config->item('domain_admin_email');
        $this->domain = $this->ci->config->item('domain');
        
    }

    public function get_all_users() {

        return array();
    }
    
    
}
