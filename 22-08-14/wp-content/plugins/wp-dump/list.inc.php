<?php

	$arrFiles = glob( WP_DUMP_DATA_DIR.'*.*' );
	echo '<p>';
	if (count($arrFiles) > 0) {
		foreach($arrFiles as $strFile) {
			echo ' - <a href="'.WP_DUMP_DATA_URL.basename($strFile).'">'.basename($strFile).' ('.wp_dump_nice_filesize($strFile).')</a><br />';
		}
	}	
	echo '</p>';

?>