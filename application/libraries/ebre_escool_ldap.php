<?php
/**
 * Attendance Module Ldap Model
 *
 *
 * @package    	Attendance Module Ldap Model
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */

class ebre_escool_ldap  {
	
	function __construct()
    {
        $this->ci =& get_instance();
        
        // Load the language file
        $this->ci->lang->load('ebre_escool_ldap','catalan');
        $this->ci->load->helper('language');
        
        log_message('debug', lang('ebre_escool_model_ldap_initialization'));

        // Load the configuration
        $this->ci->load->config('auth_ldap');
        
        $this->_init();
    }
    
    /**
	* @param array $entries
	* @param array $attribs
	* @desc Sort LDAP result entries by multiple attributes.
	*/
	function ldap_multi_sort(&$entries, $attribs){
		for ($i=1; $i<$entries['count']; $i++){
			$index = $entries[$i];
			$j=$i;
			do {
				//create comparison variables from attributes:
				$a = $b = null;
				foreach($attribs as $attrib){
					$a .= $entries[$j-1][$attrib][0];
					$b .= $index[$attrib][0];
				}
				// do the comparison
				if ($a > $b){
					$is_greater = true;
					$entries[$j] = $entries[$j-1];
					$j = $j-1;
				}else{
					$is_greater = false;
				}
			} while ($j>0 && $is_greater);
			
			$entries[$j] = $index;
		}
    return $entries;
	}
    
     /**
     * @access private
     * @return void
     */
    private function _init() {

        // Verify that the LDAP extension has been loaded/built-in
        // No sense continuing if we can't
        if (! function_exists('ldap_connect')) {
            show_error(lang('php_ldap_notpresent'));
            log_message('error', lang('php_ldap_notpresent_log'));
        }

        $this->hosts = $this->ci->config->item('hosts');
        $this->ports = $this->ci->config->item('ports');
        $this->basedn = $this->ci->config->item('basedn');
        $this->account_ou = $this->ci->config->item('account_ou');
        $this->login_attribute  = $this->ci->config->item('login_attribute');
        $this->use_ad = $this->ci->config->item('use_ad');
        $this->ad_domain = $this->ci->config->item('ad_domain');
        $this->proxy_user = $this->ci->config->item('proxy_user');
        $this->proxy_pass = $this->ci->config->item('proxy_pass');
        $this->roles = $this->ci->config->item('roles');
        $this->auditlog = $this->ci->config->item('auditlog');
        $this->member_attribute = $this->ci->config->item('member_attribute');
    }
       
    public function getGroupTotals($groupdn) {
		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';
			$search = ldap_search($this->ldapconn, $groupdn, $filter);
        	$allStudents = ldap_get_entries($this->ldapconn, $search);
        	return $allStudents["count"];
		}
	}
    
       
    public function getAllTeachers($basedn = null) {
		$teachernames=array();
		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$filter = '(employeeNumber=*)';
			
			$search = ldap_search($this->ldapconn, $basedn, $filter,array("employeeNumber","cn"));
        	$allteachernames = ldap_get_entries($this->ldapconn, $search);
        	foreach ($allteachernames as $teacher_key => $teacher){
				$teacher_code = $teacher['employeenumber'][0];
				$teacher_name = $teacher['cn'][0];
				$teachernames[$teacher_code] = $teacher_name;
			}	
		}
		return $teachernames;
	}
	
	public function getEmailAndPhotoData ($user_dn) {
		$enrollment_data="";
		
		$required_attributes=array('highSchoolPersonalEmail','jpegPhoto');
		
		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';		
			$search = ldap_search($this->ldapconn, $user_dn, $filter,$required_attributes);
        	$enrollment_data = ldap_get_entries($this->ldapconn, $search);
        	
        	if ($enrollment_data["count"] != 0) {		
				return $enrollment_data['0'];
			}
		}
		return $enrollment_data;
	}
		
	public function getEnrollmentData ($user_dn) {
		$enrollment_data="";
		
		$required_attributes=array('givenname','highSchoolUserId','employeeNumber','irisPersonalUniqueID','highSchoolPersonalEmail','email','uid','sn1','sn2');
		
		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';		
			$search = ldap_search($this->ldapconn, $user_dn, $filter,$required_attributes);
        	$enrollment_data = ldap_get_entries($this->ldapconn, $search);
        	
        	if ($enrollment_data["count"] != 0) {		
				return $enrollment_data['0'];
			}
		}
		return $enrollment_data;
	}
	
	protected function generate_md5_hash($pwd)	{
		return  "{MD5}".base64_encode( pack('H*', md5($pwd)));
	}
	
	/*! \brief Generate samba hashes
	*
	* Given a certain password this constructs an array like
	* array['sambaLMPassword'] etc.
	*
	* \param string 'password'
	* \return array contains several keys for lmPassword, ntPassword, pwdLastSet, etc. depending
	* on the samba version
	*/
	protected function generate_smb_nt_hash($password)	{
	
		$password = addcslashes($password, '$'); // <- Escape $ twice for transport from PHP to console-process.
		$password = addcslashes($password, '$'); 
		$password = addcslashes($password, '$'); // <- And again once, to be able to use it as parameter for the perl script.
		
		$command='perl -MCrypt::SmbHash -e "print join(q[:], ntlmgen %password), $/;"';
		$tmp = $command ;
		$tmp = preg_replace("/%userPassword/", escapeshellarg($password), $tmp);
		$tmp = preg_replace("/%password/", escapeshellarg($password), $tmp);
		
		exec($tmp, $ar);
		reset($ar);
		$hash= current($ar);
	
		if ($hash == "") {
			show_error("Configuration error: " . sprintf("Generating SAMBA hash by running %s failed: check %s!", $command, "sambaHashHook"));
			return(array());
		}
		
		list($lm,$nt)= explode(":", trim($hash));
		
		$attrs['sambaLMPassword']= $lm;
		$attrs['sambaNTPassword']= $nt;
		$attrs['sambaPwdLastSet']= date('U');
		$attrs['sambaBadPasswordCount']= "0";
		$attrs['sambaBadPasswordTime']= "0";
		return($attrs);
	}
	
	public function propose_password() {
		$command='/usr/bin/apg -MCLN -m 8 -n1';
		exec($command, $ar);
		//flush();
		reset($ar);
		return current($ar);
	}
	
	public function propose_passwords($number_of_passwords) {
		$command='/usr/bin/apg -MCLN -m 8 -n'.$number_of_passwords . "| xargs";
		exec($command, $ar);
		//flush();
		reset($ar);
		$result=current($ar);
		return explode(" ",$result);
	}
	
	public function changeLdapPassword($user_dn,$attrs) {
		if ($this->_bind()) {
			if (ldap_modify($this->ldapconn,$user_dn,$attrs) === false){
				$error = ldap_error($this->ldapconn);
				$errno = ldap_errno($this->ldapconn);
				show_error("Ldap error changing password: " . $errno . " - " . $error);
				return false;
			} else {
				return true;
			}
		}
		return false;
	}
		
	public function userHaveShadowAccount($dn) {
		return true;
	}
	
	
	
	public function change_password ($dn, $password )	{
		
		$newpass= "";
		// Not sure, why this is here, but maybe some encryption methods require it.
		mt_srand((double) microtime()*1000000);
		
		//GET_CURRENT_VALUES: "shadowLastChange", "userPassword","sambaNTPassword","sambaLMPassword", "uid", "objectClass"
		// Using dn
		$shadowAccountBool=true;
		
		$shadowAccountBool=$this->userHaveShadowAccount($dn);
		
		//Generate HASH NEW PASS for posixAccount
		$newpass= $this->generate_md5_hash($password);
		
		$attrs= array();
		
		$attrs= $this->generate_smb_nt_hash($password);
		if(!count($attrs) || !is_array($attrs)){
			show_error("Error: cannot generate SAMBA hash! ");
			return(FALSE);    
		}
		
		$attrs['userPassword']= $newpass;

        // For posixUsers - Set the last changed value.
        if($shadowAccountBool){
            $attrs['shadowLastChange'] = (int)(date("U") / 86400);
        }
        
        // Perform ldap operations
        return $this->changeLdapPassword($dn,$attrs);
	}
	
	protected function generate_sha1_hash($password)  {
		if (function_exists('sha1')) {
			$hash = "{SHA}" . base64_encode(pack("H*",sha1($password)));
		}elseif (function_exists('mhash')) {
			$hash = "{SHA}" . base64_encode(mHash(MHASH_SHA1, $password));
		}else{
			show_error("Configuration error generating sha1 password");
			return false;
		}
		return $hash; 
	}
	
	public function change_password_gosa ($dn, $password, $mode=FALSE, $hash= "", $old_password = "", &$message = "")	{
		
		global $config;
		$newpass= "";

		// Not sure, why this is here, but maybe some encryption methods require it.
		mt_srand((double) microtime()*1000000);

		// Get a list of all available password encryption methods.
		$methods = new passwordMethod(session::get('config'),$dn);
		$available = $methods->get_available_methods();

		// Fetch the current object data, to be able to detect the current hashing method
		//  and to be able to rollback changes once has an error occured.
		$ldap = $config->get_ldap_link();
		$ldap->cat ($dn, array("shadowLastChange", "userPassword","sambaNTPassword","sambaLMPassword", "uid", "objectClass"));
		$attrs = $ldap->fetch ();
		$initialAttrs = $attrs;

		// If no hashing method is enforced, then detect what method we've to use.
		$hash = strtolower($hash);
		if(empty($hash)){

			// Do we need clear-text password for this object?
			if(isset($attrs['userPassword'][0]) && !preg_match ("/^{([^}]+)}(.+)/", $attrs['userPassword'][0])){
				$hash = "clear";
				$test = new $available[$hash]($config,$dn);
				$test->set_hash($hash);
			}

			// If we've still no valid hashing method detected, then try to extract if from the userPassword attribute.
			elseif(isset($attrs['userPassword'][0]) && preg_match ("/^{([^}]+)}(.+)/", $attrs['userPassword'][0], $matches)){
				$test = passwordMethod::get_method($attrs['userPassword'][0],$dn);
				if($test){
					$hash = $test->get_hash_name();
				}
			}

			// No current password was found and no hash is enforced, so we've to use the config default here.
			$hash = $config->get_cfg_value('core','passwordDefaultHash');
			$test = new $available[$hash]($config,$dn);
			$test->set_hash($hash);
		}else{
			$test = new $available[$hash]($config,$dn);
			$test->set_hash($hash);
		}	

    // We've now a valid password-method-handle and can create the new password hash or don't we?
    if(!$test instanceOf passwordMethod){
        $message = _("Cannot detect password hash!");
    }else{

        // Feed password backends with object information. 
        $test->dn = $dn;
        $test->attrs = $attrs;
        $newpass= $test->generate_hash($password);

        // Do we have to append samba attributes too?
        // - sambaNTPassword / sambaLMPassword
        $tmp = $config->get_cfg_value('core','sambaHashHook');
        $attrs= array();
        if (!$mode && !empty($tmp)){
            $attrs= generate_smb_nt_hash($password);
            if(!count($attrs) || !is_array($attrs)){
                msg_dialog::display(_("Error"),_("Cannot generate SAMBA hash!"),ERROR_DIALOG);
                return(FALSE);    
            }
        }

        // Write back the new password hash 
        $ldap->cd($dn);
        $attrs['userPassword']= $newpass;

        // For posixUsers - Set the last changed value.
        if(in_array_strict("shadowAccount", $initialAttrs['objectClass'])){
            $attrs['shadowLastChange'] = (int)(date("U") / 86400);
        }

        // Prepare a special attribute list, which will be used for event hook calls
        $attrsEvent = array();
        foreach($initialAttrs as $name => $value){
            if(!is_numeric($name))
                $attrsEvent[$name] = escapeshellarg($value[0]);
        }
        $attrsEvent['dn'] = escapeshellarg($initialAttrs['dn']);
        foreach($attrs as $name => $value){
            $attrsEvent[$name] = escapeshellarg($value);
        }
        $attrsEvent['current_password'] = escapeshellarg($old_password);
        $attrsEvent['new_password'] = escapeshellarg($password);

        // Call the premodify hook now
        $passwordPlugin = new password($config,$dn);
        plugin::callHook($passwordPlugin, 'PREMODIFY', $attrsEvent, $output,$retCode,$error, $directlyPrintError = FALSE);
        if($retCode === 0 && count($output)){
            $message = sprintf(_("Pre-event hook reported a problem: %s. Password change canceled!"),implode($output));
            return(FALSE);
        }

        // Perform ldap operations
        $ldap->modify($attrs);

        // Check if the object was locked before, if it was, lock it again!
        $deactivated = $test->is_locked($config,$dn);
        if($deactivated){
            $test->lock_account($config,$dn);
        }

        // Check if everything went fine and then call the post event hooks.
        // If an error occures, then try to rollback the complete actions done.
        $preRollback = FALSE;
        $ldapRollback = FALSE;
        $success = TRUE;
        if (!$ldap->success()) {
            new log("modify","users/passwordMethod",$dn,array(),"Password change - ldap modifications! - FAILED");
            $success =FALSE;
            $message = msgPool::ldaperror($ldap->get_error(), $dn, LDAP_MOD);
            $preRollback  =TRUE;
        } else {

            // Now call the passwordMethod change mechanism.
            if(!$test->set_password($password)){
                $ldapRollback = TRUE;
                $preRollback  =TRUE;
                $success = FALSE;
                new log("modify","users/passwordMethod",$dn,array(),"Password change - set_password! - FAILED");
                $message = _("Password change failed!");
            }else{
        
                // Execute the password hook
                plugin::callHook($passwordPlugin, 'POSTMODIFY', $attrsEvent, $output,$retCode,$error, $directlyPrintError = FALSE);
                if($retCode === 0){
                    if(count($output)){
                        new log("modify","users/passwordMethod",$dn,array(),"Password change - Post modify hook reported! - FAILED!");
                        $message = sprintf(_("Post-event hook reported a problem: %s. Password change canceled!"),implode($output));
                        $ldapRollback = TRUE;
                        $preRollback = TRUE;
                        $success = FALSE;
                    }else{
                        #new log("modify","users/passwordMethod",$dn,array(),"Password change - successfull!");
                    }
                }else{
                    $ldapRollback = TRUE;
                    $preRollback = TRUE;
                    $success = FALSE;
                    new log("modify","users/passwordMethod",$dn,array(),"Password change - postmodify hook execution! - FAILED");
                    new log("modify","users/passwordMethod",$dn,array(),$error);

                    // Call password method again and send in old password to 
                    //  keep the database consistency
                    $test->set_password($old_password);
                }
            }
        }

        // Setting the password in the ldap database or further operation failed, we should now execute 
        //  the plugins pre-event hook, using switched passwords, new/old password.
        // This ensures that passwords which were set outside of GOsa, will be reset to its 
        //  starting value.
        if($preRollback){
            new log("modify","users/passwordMethod",$dn,array(),"Rolling back premodify hook!");
            $oldpass= $test->generate_hash($old_password);
            $attrsEvent['current_password'] = escapeshellarg($password);
            $attrsEvent['new_password'] = escapeshellarg($old_password);
            foreach(array("userPassword","sambaNTPassword","sambaLMPassword") as $attr){
                if(isset($initialAttrs[$attr][0])) $attrsEvent[$attr] = $initialAttrs[$attr][0];
            }
            
            plugin::callHook($passwordPlugin, 'PREMODIFY', $attrsEvent, $output,$retCode,$error, $directlyPrintError = FALSE);
            if($retCode === 0 && count($output)){
                $message = sprintf(_("Pre-event hook reported a problem: %s. Password change canceled!"),implode($output));
                new log("modify","users/passwordMethod",$dn,array(),"Rolling back premodify hook! - FAILED!");
            }
        }
        
        // We've written the password to the ldap database, but executing the postmodify hook failed.
        // Now, we've to rollback all password related ldap operations.
        if($ldapRollback){
            new log("modify","users/passwordMethod",$dn,array(),"Rolling back ldap modifications!");
            $attrs = array();
            foreach(array("userPassword","sambaNTPassword","sambaLMPassword") as $attr){
                if(isset($initialAttrs[$attr][0])) $attrs[$attr] = $initialAttrs[$attr][0];
            }
            $ldap->cd($dn);
            $ldap->modify($attrs);
            if(!$ldap->success()){
                $message = msgPool::ldaperror($ldap->get_error(), $dn, LDAP_MOD);
                new log("modify","users/passwordMethod",$dn,array(),"Rolling back ldap modifications! - FAILED");
            }
        }

        // Log action.
        if($success){
            stats::log('global', 'global', array('users'),  $action = 'change_password', $amount = 1, 0, $test->get_hash());
            new log("modify","users/passwordMethod",$dn,array(),"Password change - successfull!");
        }else{
            new log("modify","users/passwordMethod",$dn,array(),"Password change - FAILED!");
        }

        return($success);
    }
}
	
	public function getAllGroupStudentsDNs($groupdn) {
		$allGroupStudentsDNs=array();

		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';		
			$search = ldap_search($this->ldapconn, $groupdn, $filter);
        	$allGroupStudentsDNsentries = ldap_get_entries($this->ldapconn, $search);
      		$this->ldap_multi_sort($allGroupStudentsDNsentries, array("sn","givenname"));

			foreach ($allGroupStudentsDNsentries as $student){		
				$studentdn = $student['dn'];
				if ($studentdn != "")
					array_push($allGroupStudentsDNs,$studentdn);
			}
		}
		return $allGroupStudentsDNs;
	}
	
	
	public function getAllGroupStudentsInfo($groupdn) {
		$allGroupStudentsInfo=array();

		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';		
			$required_attributes= array("irisPersonalUniqueID","irisPersonalUniqueIDType","highSchoolTSI","highSchoolUserId","employeeNumber","sn","sn1","sn2",
										"givenName","gender","homePostalAddress","l","postalCode","st","mobile","homePhone","dateOfBirth","uid","highSchoolPersonalEmail",
										"jpegPhoto");
			$search = @ldap_search($this->ldapconn, $groupdn, $filter,$required_attributes);
        	$allGroupStudentsDNsentries = @ldap_get_entries($this->ldapconn, $search);
      		$this->ldap_multi_sort($allGroupStudentsDNsentries, array("sn","givenname"));
			
			$students = array();
			$i=0;
			if (count($allGroupStudentsDNsentries) != 0) {
				foreach ($allGroupStudentsDNsentries as $studententry){		
					if ($i == 0) {
						$i++;
						continue;
					}
					$student = new stdClass;
						
					$student->irisPersonalUniqueID = (isset($studententry['irispersonaluniqueid'])) ? $studententry['irispersonaluniqueid'][0] : "";	
					$student->irisPersonalUniqueIDType = (isset($studententry['irispersonaluniqueidtype'])) ? $studententry['irispersonaluniqueidtype'][0] : "";
					$student->highSchoolTSI = (isset($studententry['highschooltsi'])) ? $studententry['highschooltsi'][0] : "";
					$student->highSchoolUserId = (isset($studententry['highschooluserid'])) ? $studententry['highschooluserid'][0] : "";
					$student->employeeNumber = (isset($studententry['employeenumber'])) ? $studententry['employeenumber'][0] : "";
					$student->sn = (isset($studententry['sn'])) ? $studententry['sn'][0] : "";
					$student->sn1 = (isset($studententry['sn1'])) ? $studententry['sn1'][0] : "";
					$student->sn2 = (isset($studententry['sn2'])) ? $studententry['sn2'][0] : "";
					$student->givenName = (isset($studententry['givenname'])) ? $studententry['givenname'][0] : "";
					$student->gender = (isset($studententry['gender'])) ? $studententry['gender'][0] : "";
					$student->homePostalAddress = (isset($studententry['homepostaladdress'])) ? $studententry['homepostaladdress'][0] : "";
					$student->location = (isset($studententry['l'])) ? $studententry['l'][0] : "";
					$student->postalCode = (isset($studententry['postalcode'])) ? $studententry['postalcode'][0] : "";
					$student->st = (isset($studententry['st'])) ? $studententry['st'][0] : "";
					$student->mobile = (isset($studententry['mobile'])) ? $studententry['mobile'][0] : "";
					$student->homePhone = (isset($studententry['homephone'])) ? $studententry['homephone'][0] : "";
					$student->dateOfBirth = (isset($studententry['dateofbirth'])) ? $studententry['dateofbirth'][0] : "";
					$student->uid = (isset($studententry['uid'])) ? $studententry['uid'][0] : "";
					$student->highSchoolPersonalEmail = (isset($studententry['highschoolpersonalemail'])) ? $studententry['highschoolpersonalemail'][0] : "";
					$student->jpegPhoto = (isset($studententry['jpegphoto'])) ? $studententry['jpegphoto'][0] : "";
		
					array_push($allGroupStudentsInfo,$student);
				}
			}
		}
		return $allGroupStudentsInfo;
	}
    
    public function getAllGroupsDNs($basedn = null) {
		$groupdns=array();
		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$filter = '(physicalDeliveryOfficeName=*)';
			$search = ldap_search($this->ldapconn, $basedn, $filter,array("physicalDeliveryOfficeName"));
        	$allgroupdns = ldap_get_entries($this->ldapconn, $search);
        	        	
        	foreach ($allgroupdns as $group){
				$groupdn = $group['dn'];
				$group_code = $group['physicaldeliveryofficename'][0];
				$groupdns[$group_code] = $groupdn;
			}
		}
		return $groupdns;
	}
	
	public function getGroupDNByGroupCode($groupCode,$basedn = null) {
		$groupdn="";
		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$filter = '(physicalDeliveryOfficeName='.$groupCode.')';
			
			$search = ldap_search($this->ldapconn, $basedn, $filter);
        
			$entries = ldap_get_entries($this->ldapconn, $search);
			
			if($entries['count'] != 0) {
				$groupdn = $entries[0]['dn'];
			} else {
				$this->_audit("ERROR!");
				return FALSE;
			}
		}
		return $groupdn;
	}
    
    public function getTeacherNameByEmployeeNumber ($employeeNumber) {
		$basedn="ou=Profes,ou=All,dc=iesebre,dc=com";
		return $this->getPersonNamebyEmployeeNumber($employeeNumber,$basedn);
	}
	
	protected function _close() {
		ldap_close($this->ldapconn);
	}
	
	protected function _bind() {        
        //Connect
        foreach($this->hosts as $host) {
            $this->ldapconn = ldap_connect($host);
            if($this->ldapconn) {
               break;
            }else {
                log_message('info', lang('error_connecting_to'). ' ' .$uri);
            }
        }
        
        // At this point, $this->ldapconn should be set.  If not... DOOM!
        if(! $this->ldapconn) {
            log_message('error', lang('could_not_connect_to_ldap'));
            show_error(lang('error_connecting_to_ldap'));
        }

       
        // These to ldap_set_options are needed for binding to AD properly
        // They should also work with any modern LDAP service.
        ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        
        // Find the DN of the user we are binding as
        // If proxy_user and proxy_pass are set, use those, else bind anonymously
        if($this->proxy_user) {
            $bind = @ldap_bind($this->ldapconn, $this->proxy_user, $this->proxy_pass);
        }else {
            $bind = @ldap_bind($this->ldapconn);
        }

        if(!$bind){
            log_message('error', lang('unable_anonymous'));
            show_error(lang('unable_bind'));
            return false;
        }   
        return true;
	}

    /**
     *
     */
    public function getPersonNamebyEmployeeNumber ($employeeNumber,$basedn=null) {
        if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$needed_attrs = array('cn');
			$filter = '(employeeNumber='.$employeeNumber.')';
			$search = ldap_search($this->ldapconn, $basedn, $filter, 
                $needed_attrs);
        
			$entries = ldap_get_entries($this->ldapconn, $search);
	
			if($entries['count'] != 0) {
				$cn = $entries[0]['cn'][0];
				return $cn;
			} else {
				$this->_audit("ERROR!");
				return FALSE;
			}
		}
    }
    
    /**
     * @access private
     * @param string $msg
     * @return bool
     */
    private function _audit($msg){
        $date = date('Y/m/d H:i:s');
        if( ! file_put_contents($this->auditlog, $date.": ".$msg."\n",FILE_APPEND)) {
            log_message('info', lang('error_opening_audit_log'). ' '.$this->auditlog);
            return FALSE;
        }
        return TRUE;
    }
}
