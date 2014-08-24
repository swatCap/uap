<?php
/*
Plugin Name: WordPress Dump
Description: dump your WordPress installation.
Author: Oliver Joo&szlig;
Version: 1.0

Copyright 2013  oliver Joo&szlig;

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly.');
}

if ( ! defined('DIRECTORY_SEPARATOR') ) {
	define('DIRECTORY_SEPARATOR', '/');
}



/* some plugin defines */
define('WP_DUMP_URL',           plugin_dir_url(__FILE__));
define('WP_DUMP_DATA_URL',      WP_DUMP_URL.'/data/');
define('WP_DUMP_DATA_DIR',      dirname(__FILE__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR);
define('WP_DUMP_DATA_DUMP_FS',  WP_DUMP_DATA_DIR . 'wp-dump-files.zip');
define('WP_DUMP_DATA_DUMP_DB',  WP_DUMP_DATA_DIR . 'wp-dump-database.sql.zip');
define('WP_DUMP_DATA_DUMP_ZIP', WP_DUMP_DATA_DIR . 'wp-dump-bundle.zip');



/**
 * get filesize and return as human readable String
 * @param $filename
 * @return String
 */
function wp_dump_nice_filesize($filename) {
	$a_bytes = filesize($filename);
	if ($a_bytes < 1024) {
		return $a_bytes .' B';
	} elseif ($a_bytes < 1048576) {
		return round($a_bytes / 1024, 2) .' KB';
	} elseif ($a_bytes < 1073741824) {
		return round($a_bytes / 1048576, 2) . ' MB';
	} else {
		return round($a_bytes / 1073741824, 2) . ' GB';
	}
}



/* What to do when the plugin is activated? */
register_activation_hook(__FILE__,'wp_dump_install');

/* What to do when the plugin is deactivated? */
register_deactivation_hook( __FILE__, 'wp_dump_remove' );

function wp_dump_install() {
	// create directory for dump files
	mkdir( dirname(__FILE__).DIRECTORY_SEPARATOR.'data' );
}

function wp_dump_remove() {
	// delete dump files
	$arrFiles = glob( WP_DUMP_DATA_DIR.'*.*' );
	foreach($arrFiles as $strFile) {
		unlink($strFile);
	}
}

function wp_dump_admin_menu() {
	add_menu_page('WP-dump', 'WP-dump', 'manage_options','wp-dump', 'wp_dump_page', WP_DUMP_URL.'wp-dump_16.png');
}
add_action('admin_menu', 'wp_dump_admin_menu');


function wp_dump_page() {

	echo '<div class="wrap">'.PHP_EOL;
	echo '	<h2><img src="'.WP_DUMP_URL.'wp-dump_32.png" align="left" />&nbsp;&nbsp;WP-dump</h2>'.PHP_EOL;
	if (isset($_POST['wp-dump'])) {
		require_once 'dump.inc.php';
	}
	require_once 'list.inc.php';
	echo '<p>&nbsp;</p>';
	echo '	<p>'.PHP_EOL;
	echo '		<form method="post">'.PHP_EOL;
	//some hints for usage
	echo '          Notice: wordpress stores url content in the database.<br />'.PHP_EOL;
    echo '          In case of dumping your online installation to use it in a XAMP enviroment, you have to change the URLs in the sql dump.<br />'.PHP_EOL;
    echo '          <input type="checkbox" name="wp-dump-replace-url" value="1" /> Change URL in dump from <input type="text" name="wp-dump-url-old" value="http://'.$_SERVER["SERVER_NAME"].'" /> to <input type="text"  name="wp-dump-url-new" value="http://'.$_SERVER["SERVER_NAME"].'" /><br />'.PHP_EOL;
	echo '			<input type="submit" name="wp-dump" value="Dump now" />'.PHP_EOL;
	echo '		</form>'.PHP_EOL;
	echo '	</p>'.PHP_EOL;
	echo '</div>'.PHP_EOL;

}
?>