<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$config['base_url']	= 'http://localhost/ebre-escool';

//**********************************
//* Enrollment PDF configuration   *
//**********************************
		
$config['rules_url']	= 'http://moodle.iesebre.com/normesTIC';
$config['services_url']	= 'http://moodle.iesebre.com/serveisTIC';
		

$config['rules_url']	= 'http://moodle.iesebre.com/normesTIC';
$config['services_url']	= 'http://moodle.iesebre.com/serveisTIC';
$config['rules_url']	= 'http://moodle.iesebre.com/normesTIC';
$config['services_url']	= 'http://moodle.iesebre.com/serveisTIC';


		
		$HIGHSCHOOLSNAME="Institut de l'Ebre";
		$HIGHSCHOOLSUFFIXEMAIL="iesebre.com"; 

		/////////////////// DO NOT TOUCH WHEN CONFIGURING 
		//PDF DOCUMENT
		// DOCUMENT NAME= externalID_internalID_documentNameSufix
		$documentNameSufix="_matriculaTIC.pdf";

		//WINDOWS HEADER AT PDF DOCUMENT
		// TITLE USER FULL NAME
		$windowheadertitle="Matrícula TIC de l'alumne";
		
		//IMAGES PATHS
		$logo_image="/usr/share/gosa/html/pdfreports/images/logo1.jpeg";
		$signature_image="/usr/share/gosa/html/pdfreports/images/signature.jpeg";

		//STRINGS
		$STR_TITLE=_("MATRÍCULA TIC");
		$STR_User=_("Usuari");
		$STR_Password=_("Paraula de pas");
		$STR_InternalID=_("Identificador del centre");
		$STR_PersonalEmail=_("Correu electrònic personal");
		$STR_Email=_("Correu electrònic del centre");
		$STR_UserSignature=_("Signatura de l'interessat/interessada");
		$STR_SchoolSignature=_("Signatura i segell del centre");
		$STR_UserPageType=_("Exemplar per a la persona interessada");
		$STR_SchoolPageType=_("Exemplar per a l'escola");
		$STR_TutorPageType=_("Exemplar per al tutor");

		$IMPORTANT_NOTE=_("IMPORTANT: La paraula de pas ha de ser PERSONAL i INTRANSFERIBLE, s'ha d'utilitzar en cura i no es pot deixar-la o prestar-la a altres usuaris. És la vostra responsabilitat no facilitar el vostre usuari o paraula de pas a NINGÚ. Queda expressament prohibit assumir la identitat d'altres usuaris.");
		
		/////////////////// DO NOT TOUCH WHEN CONFIGURING 
