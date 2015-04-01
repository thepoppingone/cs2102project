<?php
// connect to database
putenv('ORACLE_HOME=/oraclient');

$dbh = oci_connect('a0098969', 'crse1420', ' (DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
)
(CONNECT_DATA =
(SERVICE_NAME = sid3.comp.nus.edu.sg)
)
)');
?>