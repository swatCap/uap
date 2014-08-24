<?php

echo '<p>Start dump</p>';

$intStartTime = time();


/***************************************************************************************
 *                            enable site down message                                 *
 ***************************************************************************************/
echo '<p> - enable site down message</p>';
//check for existing maintenance.php
if (!file_exists(ABSPATH . 'wp-content' . DIRECTORY_SEPARATOR . 'maintenance.php')) {
	//if not, create a new one
	file_put_contents(ABSPATH . 'wp-content' . DIRECTORY_SEPARATOR . 'maintenance.php', file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'maintenance.inc.php') );
}
file_put_contents(ABSPATH . '.maintenance', '<?php $upgrading = time(); ?>');



/***************************************************************************************
 *                                    delete old stuff                                 *
 ***************************************************************************************/
if(file_exists(WP_DUMP_DATA_DUMP_FS)) unlink(WP_DUMP_DATA_DUMP_FS);
if(file_exists(WP_DUMP_DATA_DUMP_DB)) unlink(WP_DUMP_DATA_DUMP_DB);
if(file_exists(WP_DUMP_DATA_DUMP_ZIP)) unlink(WP_DUMP_DATA_DUMP_ZIP);



/***************************************************************************************
 *                               get path of zip binary                                *
 ***************************************************************************************/
// exit codes of ZIP
$arrZIP = array(
			 '3' => 'WARNING: a generic error in the zipfile format was detected. Processing may have completed successfully anyway',
			 '6' => 'WARNING: entry too large to be processed or entry too large to be split with zipsplit',
			'12' => 'WARNING: zip has nothing to do',
			'18' => 'WARNING: zip could not open a specified file to read');
$strZipBinaryFile = 'zip';
$tmp = shell_exec("whereis zip");
if (preg_match('~[a-zA-Z0-9/]+zip[a-zA-Z0-9/]*~', $tmp, $arrMatches)) {
	$strZipBinaryFile = $arrMatches[0];
}
else {
	$tmp = shell_exec("type zip");
	if (preg_match('~[a-zA-Z0-9/]+zip[a-zA-Z0-9/]*~', $tmp, $arrMatches)) {
	$strZipBinaryFile = $arrMatches[0];
	}
}



/***************************************************************************************
 *                                   set enviroments                                   *
 ***************************************************************************************/
echo '<p> - abolish execution time limit.</p>';
flush();
set_time_limit(0);
$tmp = false;
$intMemory = 2024;
while($tmp === false) {
	$tmp = ini_set('memory_limit', $intMemory.'M');
	$intMemory = round($intMemory / 2);
}



/***************************************************************************************
 *                                    ZIP files                                        *
 ***************************************************************************************/
echo '<p>';
echo " - ZIP wordpress files "; flush();
$intTime = time();
$strCommand = "cd ".ABSPATH." && ".$strZipBinaryFile." -r ".WP_DUMP_DATA_DUMP_FS." . ";
$output = exec($strCommand,$arrOutput,$strSqlDumpvar);
$intDuration = time() - $intTime;
echo " (" . $intDuration . " sec)<br />"; flush();
if ($strSqlDumpvar == 0) {
	#echo 'OK';
}
elseif(array_key_exists($strSqlDumpvar, $arrZIP)) {
	echo '<pre>';
	//iterate the output and search for more details
	foreach($arrOutput as $strLine) {
		$strLine = trim($strLine);
		if (preg_match('~zip warning~', $strLine)) {
			echo '	'.$strLine.PHP_EOL;
		}
	}
	echo '</pre>';
}
else {
	echo 'ERROR: could not zip. <pre>' . PHP_EOL . implode(PHP_EOL, $arrOutput) . '</pre>';
}
echo '</p>';


/***************************************************************************************
 *                                   dump database                                     *
 ***************************************************************************************/
echo '<p>';
echo " - Dump the database "; flush();
$intTime = time();
$host   = DB_HOST;
$user   = DB_USER;
$pass   = DB_PASSWORD;
$name   = DB_NAME;
global $table_prefix;
$prefix = $table_prefix;
$link = mysql_connect($host,$user,$pass);
if ($link === false) throw new Exception('Can not connect to: ' . $host);
$res = mysql_select_db($name,$link);
if ($res === false) throw new Exception('Can not selectDB: ' . $name);
//get all of the tables
$tables = array();
$result = mysql_query('SHOW TABLES');
if ($result === false) throw new Exception('MYSQL-ERROR:' . mysql_error());
while($row = mysql_fetch_row($result)) {
	if (substr($row[0],0,strlen($prefix)) == $prefix) $tables[] = $row[0];
}
$strSqlDump = '-- DUMP of ' . DB_NAME .PHP_EOL.PHP_EOL;
//cycle through
foreach($tables as $table) {
	//TABLE STRUCTURE
	$strSqlDump .= 'DROP TABLE IF EXISTS `'.$table.'`;';
	$res = mysql_query('SHOW CREATE TABLE '.$table);
	if ($res === false) throw new Exception('Can not selectDB: ' . $name);
	$row2 = mysql_fetch_row($res);
	$strSqlDump .= PHP_EOL.PHP_EOL.$row2[1].";".PHP_EOL.PHP_EOL;
	//TABLE DATA
	$result = mysql_query('SELECT * FROM '.$table);
	if ($result === false) throw new Exception('MYSQL-ERROR:' . mysql_error());
	$num_fields = mysql_num_fields($result);
	
	$num_rows = mysql_num_rows($result);
	if ($num_rows > 0) {
		$strSqlDump .= 'INSERT INTO '.$table.' VALUES ' . PHP_EOL;
		$i = 0;
		while($row = mysql_fetch_row($result)) {
			$i++;
			$strSqlDump .= '(';
			for($j=0; $j<$num_fields; $j++) {
				//take care of special characters
				$row[$j] = addslashes($row[$j]);
				$row[$j] = preg_replace("~\n~","\\n",$row[$j]);
				//check for value
				if (isset($row[$j])) { 
					if (is_null($row[$j])) {
						$strSqlDump .= 'NULL';
					}
					else {
						$strSqlDump .= '"'.$row[$j].'"';
					}
				} 
				else {
					$strSqlDump .= '""';
				}
				//append next value
				if ($j<($num_fields-1)) { 
					$strSqlDump .= ','; 
				}
			}
			$strSqlDump .= "),";
			
			//break sql command on every 50 row
			if ($i % 50 == 0) {
				//change last , into ;
				$strSqlDump[strlen($strSqlDump)-1] = ';';
				//check if there are e.g. exact 50 or 100 rows in the table
				if ($num_rows != $i) {
					$strSqlDump .= PHP_EOL . 'INSERT INTO '.$table.' VALUES ' . PHP_EOL;
				}
			}
		}
		//check if there is some rest (e.g. on 67 rows, there will be a rest of 17 rows)
		if ($strSqlDump[strlen($strSqlDump)-1] == ',') {
			$strSqlDump[strlen($strSqlDump)-1] = ';' . PHP_EOL;
		}
	}
	$strSqlDump .= PHP_EOL.PHP_EOL.PHP_EOL;
}
//check for wordpress url change request

if (isset($_POST['wp-dump-replace-url'])) {
	if (empty($_POST['wp-dump-url-old'])) {
		echo " - ERROR: source URL is empty, can not convert urls in sql file<br />".PHP_EOL; flush();
	}
	elseif(empty($_POST['wp-dump-url-new'])) {
		echo " - ERROR: source URL is empty, can not convert urls in sql file<br />".PHP_EOL; flush();
	}
	else {
		$count = 0;
		$strSqlDump = str_replace($_POST['wp-dump-url-old'], $_POST['wp-dump-url-new'], $strSqlDump, $count);
		echo " <i>[changed '".$_POST['wp-dump-url-old']."' to '".$_POST['wp-dump-url-new']."' ".$count." times]</i>".PHP_EOL; flush();
	}
}
$strSqlFile = WP_DUMP_DATA_DIR . 'dump.sql';
$handle = fopen($strSqlFile,'w+');
fwrite($handle,$strSqlDump);
fclose($handle);
//zip the file
$strCommand = "cd ".ABSPATH." && ".$strZipBinaryFile." -rj ".WP_DUMP_DATA_DUMP_DB." ".$strSqlFile;
$output = exec($strCommand,$arrOutput,$strSqlDumpvar);
$intDuration = time() - $intTime;
echo " (" . $intDuration . " sec)<br />"; flush();
if ($strSqlDumpvar == 0) {
	unlink($strSqlFile);
}
else {
	echo 'ERROR: could not zip dump file. <pre>' . PHP_EOL . implode(PHP_EOL, $arrOutput) . '</pre>';
}
echo '</p>';



/***************************************************************************************
 *                              zip all to one dump file                               *
 ***************************************************************************************/
echo '<p> - ZIP all dump files to final dump</p>';
$strCommand = "cd ".ABSPATH." && ".$strZipBinaryFile." -rj ".WP_DUMP_DATA_DUMP_ZIP." ".WP_DUMP_DATA_DUMP_FS." ".WP_DUMP_DATA_DUMP_DB;
$output = exec($strCommand,$arrOutput,$strSqlDumpvar);



/***************************************************************************************
 *                              disable site down message                              *
 ***************************************************************************************/
if (file_exists(ABSPATH . '.maintenance')) {
	echo '<p> - disable site down message</p>';
	unlink(ABSPATH . '.maintenance');
}



/***************************************************************************************
 *                                        finished                                     *
 ***************************************************************************************/
echo '<p>Finished dump (' . (time()-$intStartTime) . ' sec)<br />'; flush();
if ($strSqlDumpvar == 0) {
	#echo 'OK';
}
else {
	echo 'ERROR: could not zip. <pre>' . PHP_EOL . implode(PHP_EOL, $arrOutput) . '</pre>';
}
echo '</p>';

?>