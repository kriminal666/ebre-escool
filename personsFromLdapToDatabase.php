<?php

/*
PREREQUISITES:
Set basedn to base correct base dn period enrollment. P.e.  
 Uncomment temporarily in first line of file /usr/share/ebre-escool/application/config/auth_ldap.php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 Uncomment the same at file /usr/share/ebre-escool/application/config/database.php
*/

#IMPORTANT: no poseu les paraules de pas a aquest fitxer:
include "/usr/share/ebre-escool/application/config/auth_ldap.php";
include "/usr/share/ebre-escool/application/config/database.php";

//MYSQL CONNECTION
$con=mysqli_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);
	// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/* change character set to utf8 */
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($con));
} else {
    printf("Current character set: %s\n", mysqli_character_set_name($con));
}

//LDAP
$ldapconfig['host'] = $config['hosts'][0];
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = NULL;
//$ldapconfig['basedn'] = $config['basedn'];

$basedn="dc=iesebre,dc=com";

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=$config['proxy_pass'];
$dn=$config['proxy_user'];

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("LDAP Login correct\n");
} else {
  # Error
  echo("LDAP Login ERROR!\n");
}


$filter="(objectClass=inetOrgPerson)";
$sr=ldap_search($ds,$basedn, $filter);   
$totalPersons=ldap_count_entries($ds,$sr); 

echo "Persones potencials a matrícular:".$totalPersons."\n";

$localities= getLocalities();

echo "Poblacions trobades: ". count($localities) ."\n";

$info = ldap_get_entries($ds, $sr); 
echo "Data for ".$info["count"]." items returned:\n"; 

$users_to_skip = array ( "root", "nobody", "alumnenou", "profenou", "admin", "201213alumnenou","prova","201213cooperativa","iewu5fvextrty");

$skipped = 0; 
$skipped_duplicate_id = 0;
$added_persons = 0;

$fist_invented_dni=99999001;

for ($i=0; $i<$info["count"]; $i++  ) { 

	echo "************************************************\n";
	echo "* Iteration begin: " . $i . "\n";
	echo "************************************************\n";
	//Init variables
	$person_givenName = ""; 
	$person_sn1 = "";
	$person_sn2 = "";
	$person_email = "";
	$person_secondary_email = "";
	$person_terciary_email = "";
	$person_official_id = "";
	$person_official_id_type = 999;
	$person_date_of_birth = "0000-00-00";
	$person_gender = "";
	$person_secondary_official_id = "";
	$person_secondary_official_id_type = 999;
	$person_homePostalAddress = "";
	$person_photo = "";
	$person_locality_id = 99999;
	$person_locality_name = "";
	$person_telephoneNumber = "";
	$person_mobile ="";
	$person_bank_account_id = 999999;
	$person_notes = "";
	$person_entryDate = "0000-00-00 00:00:00";
	$person_last_update = "0000-00-00 00:00:00";
	$person_creationUserId = 999999;
	$person_lastupdateUserId = 999999;
	$person_markedForDeletion = "n";
	$person_markedForDeletionDate = "0000-00-00 00:00:00";
	$dn = "";
	$date_of_birth = "0000-00-00";
	$user_type = 999;
	$username = "";	

	$person_uidnumber = 999999;
	$person_homedirectory = "";
	$person_employeenumber = 999999;
	$person_employeetype = "";
	$person_userpassword = "";

	$dn = $info[$i]["dn"];
		
	$uid="";	
	if (array_key_exists ( "uid" , $info[$i] )) {
		$uid= $info[$i]["uid"][0];	
	} else {
		$uid= "";	
		echo "DN: " . $dn . " . No té uid. SKIPPED!!!\n";
		$skipped++; 
		continue;
	}

	//USERS TO SKIP:
	if ( in_array ( $uid , $users_to_skip ) ) {
		echo "uid: " . $uid . " . SKIPPED!!!\n";
		$skipped++; 
		continue;
	}

	$irispersonaluniqueid="";

	if (array_key_exists ( "irispersonaluniqueid" , $info[$i] )) {
		$irispersonaluniqueid=$info[$i]["irispersonaluniqueid"][0];	
		
		echo "uid: " . $uid . " . ID: " . $irispersonaluniqueid .  "\n";
	} else {
		echo "uid: " . $uid . " . ID doest not exists. DN: " . $dn . ". NIF: " . $fist_invented_dni . LetraNIF('$fist_invented_dni') . "." . "ERROR!!!\n";
		$fist_invented_dni++;
	}

	if (array_key_exists ( "givenname" , $info[$i] )) {
		$person_givenName= $info[$i]["givenname"][0];	
	}
	if (array_key_exists ( "sn1" , $info[$i] )) {
		$person_sn1= $info[$i]["sn1"][0];	
	}
	if (array_key_exists ( "sn2" , $info[$i] )) {
		$person_sn2= $info[$i]["sn2"][0];	
	}
	if (array_key_exists ( "email" , $info[$i] )) {
		$person_email= $info[$i]["email"][0];	
	}
	if (array_key_exists ( "highschoolpersonalemail" , $info[$i] )) {
		$person_secondary_email= $info[$i]["highschoolpersonalemail"][0];	 
	}
	
	//THIS DATA DOES NOT EXISTS ON LDAP
	$person_terciary_email="";

	$person_official_id= strtoupper($irispersonaluniqueid);

	if (array_key_exists ( "irispersonaluniqueidtype" , $info[$i] )) {
		$person_official_id_type= $info[$i]["irispersonaluniqueidtype"][0];	
	}
	if (array_key_exists ( "dateofbirth" , $info[$i] )) {
		$person_date_of_birth= $info[$i]["dateofbirth"][0];	
	}
	if (array_key_exists ( "gender" , $info[$i] )) {
		$person_gender= $info[$i]["gender"][0];	
	}
	if (array_key_exists ( "highschooltsi" , $info[$i] )) {
		$person_secondary_official_id= $info[$i]["highschooltsi"][0];	
		$person_secondary_official_id_type= 4;	
	} 
	if (array_key_exists ( "homepostaladdress" , $info[$i] )) {
		$person_homePostalAddress = $info[$i]["homepostaladdress"][0];
	}

	$person_photo = $uid . ".jpg";

	if (array_key_exists ( "l" , $info[$i] )) {
		$person_locality_name= $info[$i]["l"][0];	
	}

	if ($person_locality_name != "") {
		if (array_key_exists ( strtolower($person_locality_name) , $localities) ) {
			$person_locality_id = $localities[strtolower($person_locality_name)];
		}
	}

	if (array_key_exists ( "telephonenumber" , $info[$i] )) {
		$person_telephoneNumber= $info[$i]["telephonenumber"][0];	
	}
	
	if (array_key_exists ( "mobile" , $info[$i] )) {
		$person_mobile= $info[$i]["mobile"][0];	
	}

	//Fields: person_entryDate person_last_update person_creationUserId person_lastupdateUserId
	if (array_key_exists ( "highschoolusercreatedby" , $info[$i] )) {
		//person_creationUserId
		$person_creationUserId = $info[$i]["highschoolusercreatedby"][0];	
	}

	if (array_key_exists ( "highschooluserlastmodifiedby" , $info[$i] )) {
		//person_lastupdateUserId
		$person_lastupdateUserId = $info[$i]["highschooluserlastmodifiedby"][0];	
	}

	if (array_key_exists ( "highschoolusercreatedat" , $info[$i] )) {
		//person_entryDate . "','" . $person->person_last_update
		$person_entryDate = $info[$i]["highschoolusercreatedat"][0];	
	}

	if (array_key_exists ( "highschooluserlastmodifiedat" , $info[$i] )) {
		//person_last_update
		$person_last_update = $info[$i]["highschooluserlastmodifiedat"][0];	
	}




	if (array_key_exists ( "uidnumber" , $info[$i] )) {
		$person_uidnumber = $info[$i]["uidnumber"][0];	
	}
	if (array_key_exists ( "homedirectory " , $info[$i] )) {
		$person_homedirectory = $info[$i]["homedirectory "][0];	
	}
	if (array_key_exists ( "employeenumber" , $info[$i] )) {
		$person_employeenumber = $info[$i]["employeenumber"][0];	
	}
	if (array_key_exists ( "employeetype" , $info[$i] )) {
		$person_employeetype = $info[$i]["employeetype"][0];	
	}
	if (array_key_exists ( "userpassword" , $info[$i] )) {
		$person_userpassword = $info[$i]["userpassword"][0];	
	}

	$person_bank_account_id=9999;
	
	$person_notes ="Imported using script personsFromLdapToDatabase.php";

	//ESCAPE CHARACTER like ' to avoid SQL ERRORS!
	$person_givenName = mysqli_real_escape_string($con, $person_givenName);
	$person_sn1 = mysqli_real_escape_string($con, $person_sn1);
	$person_sn2 = mysqli_real_escape_string($con, $person_sn2);
	$person_email = mysqli_real_escape_string($con, $person_email);
	$person_secondary_email = mysqli_real_escape_string($con, $person_secondary_email);
	$person_terciary_email = mysqli_real_escape_string($con, $person_terciary_email);
	$person_official_id = mysqli_real_escape_string($con, $person_official_id);
	//number then not requires
	//$person_official_id_type = mysqli_real_escape_string($con, $person_official_id_type);
	$person_date_of_birth = mysqli_real_escape_string($con, $person_date_of_birth);
	$person_gender = mysqli_real_escape_string($con, $person_gender);
	$person_secondary_official_id = mysqli_real_escape_string($con, $person_secondary_official_id);
	//number then not requires
	//$person_secondary_official_id_type = mysqli_real_escape_string($con, $person_secondary_official_id_type);
	$person_secondary_official_id_type = mysqli_real_escape_string($con, $person_secondary_official_id_type);
	$person_homePostalAddress = mysqli_real_escape_string($con, $person_homePostalAddress);
	$person_gender = mysqli_real_escape_string($con, $person_gender);
	$person_photo = mysqli_real_escape_string($con, $person_photo);
	$person_locality_id = mysqli_real_escape_string($con, $person_locality_id);
	$person_locality_name = mysqli_real_escape_string($con, $person_locality_name);
	$person_telephoneNumber = mysqli_real_escape_string($con, $person_telephoneNumber);
	$person_mobile = mysqli_real_escape_string($con, $person_mobile);
	$person_notes = mysqli_real_escape_string($con, $person_notes);
	$dn = mysqli_real_escape_string($con, $dn);

	$person_userpassword = mysqli_real_escape_string($con, $person_userpassword);

	$person = new stdClass;

	$person->person_givenName = $person_givenName;
	$person->person_sn1 = $person_sn1;
	$person->person_sn2 = $person_sn2;
	$person->person_email = $person_email;
	$person->person_secondary_email = $person_secondary_email;
	$person->person_terciary_email = $person_terciary_email;
	$person->person_official_id = $person_official_id;
	$person->person_official_id_type = $person_official_id_type;
	$person->person_date_of_birth = $person_date_of_birth;
	$person->person_gender = $person_gender;
	$person->person_secondary_official_id = $person_secondary_official_id;
	$person->person_secondary_official_id_type = $person_secondary_official_id_type;
	$person->person_homePostalAddress = $person_homePostalAddress;
	$person->person_photo = $person_photo;
	$person->person_locality_id = $person_locality_id;
	$person->person_locality_name = $person_locality_name;
	$person->person_telephoneNumber = $person_telephoneNumber;
	$person->person_mobile = $person_mobile;
	$person->person_bank_account_id = $person_bank_account_id;
	$person->person_notes = $person_notes;
	$person->person_entryDate = $person_entryDate;
	$person->person_last_update = $person_last_update;
	$person->person_creationUserId = $person_creationUserId;
	$person->person_lastupdateUserId = $person_lastupdateUserId;
	$person->person_markedForDeletion = $person_markedForDeletion;
	$person->person_markedForDeletionDate = $person_markedForDeletionDate;

	$person->uidnumber = $person_uidnumber;
	$person->homedirectory = $person_homedirectory;
	$person->employeenumber = $person_employeenumber;
	$person->employeetype = $person_employeetype;
	$person->userpassword = $person_userpassword;

	$person->dn = $dn;
	$person->date_of_birth = $person_date_of_birth;
	$person->user_type = getUserType($dn);
	$person->username = $uid;	

	$result = addPersonToDatabase($con,$person);

	if ($result) {
		$added_persons++;
	}

	echo "************************************************\n";
	echo "* Iteration END: " . $i . "\n";
	echo "************************************************\n";

}

echo "************************************************\n";
echo "* END. STATISTICS: \n";
echo "* Added persons: " . $added_persons . " \n";
echo "* Skipped: " . $skipped . " \n";
echo "* Iterations: " . $i . " \n";
echo "* TotalPersons: " . $totalPersons . " \n";
echo "************************************************\n";


function getUserType($dn) {

	if (strstr($dn, "Alumnes")) {
   		return 1;
	} elseif (strstr($dn, "Profes")) {
   		return 2;
	} elseif (strstr($dn, "Personal")) {
		return 3;
	} else {
		return 9999;
	}

	return 9999;
} 

function getLocalities($con) {

	//SELECT
	$result = mysqli_query($con,"SELECT * FROM  locality");
	$localities = array();
	while($row = mysqli_fetch_array($result)) {
		$locality = new stdClass;
		$locality->id = $row['locality_id'];

		$persons[strtolower($row['locality_name'])] = $locality;
	}
	return $localities;
}

/*OBSOLET
function getIdForLocality($con,$person_locality_name) {

	//SELECT
	$result = mysqli_query($con,"SELECT * FROM  locality");
	$localities = array();
$persons_dni = array();
while($row = mysqli_fetch_array($result)) {
	$person = new stdClass;
	$person->id = $row['person_id'];

	$persons[$row['username']] = $person;
	$persons_dni[$row['person_official_id']] = $person;
}


	//FOUND?
		//RETURN ID
	//NOT FOUND?
		//Add locality
	return 9999;
}*/

function addPersonToDatabase($con, $person) {

	//INSERT TO DATABASE
	/*$query="INSERT INTO person (person_givenName,person_sn1,person_sn2,person_email,person_secondary_email,person_terciary_email,
								 person_official_id,person_official_id_type,person_date_of_birth,person_gender,person_secondary_official_id,person_secondary_official_id_type,person_homePostalAddress,person_photo,person_locality_id,person_locality_name,person_telephoneNumber,person_mobile,person_bank_account_id,person_notes,person_entryDate,person_last_update,person_creationUserId,person_lastupdateUserId,person_markedForDeletion,person_markedForDeletionDate,dn,date_of_birth,user_type,username) 
		        VALUES ('" . $person->person_givenName . "','" . $person->person_sn1 . "','" . $person->person_sn2 . "','" .
						$person->person_email . "','" . $person->person_secondary_email . "','" . $person->person_terciary_email . "','" . $person->person_official_id . "'," . $person->person_official_id_type . ",'" . $person->person_date_of_birth . "','" . $person->person_gender . "','" . $person->person_secondary_official_id . "'," . $person->person_secondary_official_id_type . ",'" . $person->person_homePostalAddress . "','" . $person->person_photo . "','" . $person->person_locality_id . "','" . $person->person_locality_name . "','" . $person->person_telephoneNumber . "','" . $person->person_mobile . "','". $person->person_bank_account_id . "','" . $person->person_notes . "','" . $person->person_entryDate . "','" . $person->person_last_update . "','" . $person->person_creationUserId . "','" . $person->person_lastupdateUserId . "','" . $person->person_markedForDeletion . "','" . $person->person_markedForDeletionDate . "','" . $person->dn . "','" . $person->date_of_birth . "','" . $person->user_type . "','"
   						    . $person->username 
		        	        .  "')";*/

	$query="INSERT INTO person (person_givenName,person_sn1,person_sn2,person_email,person_secondary_email,person_terciary_email,
								 person_official_id,person_official_id_type,person_date_of_birth,person_gender,person_secondary_official_id,person_secondary_official_id_type,person_homePostalAddress,person_photo,person_locality_id,person_locality_name,person_telephoneNumber,person_mobile,person_bank_account_id,person_notes,person_entryDate,person_last_update,createbydn,modifiedbydn,person_markedForDeletion,person_markedForDeletionDate,dn,date_of_birth,user_type,uidnumber,homedirectory,employeenumber,employeetype,userpassword,username) 
		        VALUES ('" . $person->person_givenName . "','" . $person->person_sn1 . "','" . $person->person_sn2 . "','" .
						$person->person_email . "','" . $person->person_secondary_email . "','" . $person->person_terciary_email . "','" . $person->person_official_id . "'," . $person->person_official_id_type . ",'" . $person->person_date_of_birth . "','" . $person->person_gender . "','" . $person->person_secondary_official_id . "'," . $person->person_secondary_official_id_type . ",'" . $person->person_homePostalAddress . "','" . $person->person_photo . "','" . $person->person_locality_id . "','" . $person->person_locality_name . "','" . $person->person_telephoneNumber . "','" . $person->person_mobile . "','". $person->person_bank_account_id . "','" . $person->person_notes . "','" . $person->person_entryDate . "','" . $person->person_last_update . "','" . $person->person_creationUserId . "','" . $person->person_lastupdateUserId . "','" . $person->person_markedForDeletion . "','" . $person->person_markedForDeletionDate . "','" . $person->dn . "','" . $person->date_of_birth . "','" . $person->user_type . "','" . $person->uidnumber . "','" . $person->homedirectory . "','" . $person->employeenumber . "','" . $person->employeetype . "','" . $person->userpassword . "','" . $person->username .  "')";

	echo $query;
	if (!mysqli_query($con, $query )) 
		{
			$error_number= mysqli_errno($con);
			echo " ERROR! Number: ". $error_number . " Message: " . mysqli_error($con) . "\n";
			if ($error_number == 1062) {
				echo "SKIP DUPLICATED ID!";
				$skipped++;
				$skipped_duplicate_id++;
			} else {
				die('Error: ' . mysqli_error($con));	
			}			
		} else {
			echo " ADDED OK!\n";
		}

	return true;
}


# http://www.lawebdelprogramador.com # 
function LetraNIF ($dni) { 
	/* Obtiene letra del NIF a partir del DNI */ 
	$valor= (int) ($dni / 23); 
	$valor *= 23; 
	$valor= $dni - $valor; 
	$letras= "TRWAGMYFPDXBNJZSQVHLCKEO"; 
	$letraNif= substr ($letras, $valor, 1); 
	return $letraNif; 
}

?>