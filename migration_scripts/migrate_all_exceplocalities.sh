#!/bin/bash

#/usr/bin/php5 /usr/share/ebre-escool/migration_scripts/localities_frompostalcode.php &> /usr/share/ebre-escool/migration/result_localities_frompostalcode.sql
/usr/bin/php5 /usr/share/ebre-escool/migration_scripts/personsFromLdapToDatabase.php &> /usr/share/ebre-escool/migration/result_personsFromLdapToDatabase.txt
/usr/bin/php5 /usr/share/ebre-escool/migration_scripts/enroll.php &> /usr/share/ebre-escool/migration/result_enroll.txt


    