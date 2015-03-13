<?php

// connect to database
putenv('ORACLE_HOME=/oraclient');

$dbh = oci_connect('a0125368', 'crse1420', ' (DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
)
(CONNECT_DATA =
(SERVICE_NAME = sid3.comp.nus.edu.sg)
)
)');

// carry out sql command
$sql = "SELECT * FROM admin";

$stid = oci_parse($dbh, $sql);

// without OCI_DEFAULT any changes to the database will be instantly viewable by all other connecgtions
oci_execute($stid, OCI_DEFAULT);  

echo "<b>SQL: </b>".$sql."<br><br>";

while($row = oci_fetch_array($stid)) 
{
	echo "$row[0]"."<br>";
}

// to free up the resources
oci_free_statement($stid);
?>
