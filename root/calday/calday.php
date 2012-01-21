<?php
// Server in the this format: <computer>\<instance name> or 
// <server>,<port> when using a non default port number
//$server = 'sql-qnon02.ist.berkeley.edu';
$server = 'sql-pnon02.ist.berkeley.edu';

// Connect to MSSQL
$link = mssql_connect($server, 'saral', 'Laras_$RO21932');

if (!$link || !mssql_select_db('Eventplanning', $link)) {
    die('Unable to connect or select database!');
}

// Get all the tables
/*
$all = MSSQL_Query("select TABLE_NAME, COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS order by TABLE_NAME, ORDINAL_POSITION");

$tables = array();
$columns = array();

while($fet_tbl = MSSQL_Fetch_Assoc($all)) { // PUSH ALL TABLES AND COLUMNS INTO THE ARRAY

  $tables[] = $fet_tbl[TABLE_NAME];
  $columns[] = $fet_tbl[COLUMN_NAME];

}

$sltml = array_count_values($tables); // HOW MANY COLUMNS ARE IN THE TABLE

foreach($sltml as $table_name => $id) {
 
 echo "<h2>". $table_name ." (". $id .")</h2><ol>";
 
	for($i = 0; $i <= $id-1; $i++) {
   
	echo "<li>". $columns[$i] ."</li>";
   
	}
   
  echo"</ol>";
 
}
*/

$sql ="select * from CampusLocations";
$data = mssql_query( $sql, $link);       
$result = array();   

do {
    while ($row = mssql_fetch_object($data)){
        $result[] = $row;   
    }
}while ( mssql_next_result($data) );

mssql_close($link);  

print "CampusLocations";
print "<pre>";
print_r($result);
print "</pre>";

?>

