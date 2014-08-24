<?php
if ( ! isset( $_GET['tmnf-shortcodes-nonce'] ) || ( $_GET['tmnf-shortcodes-nonce'] == '' ) ) die( 'Security check' );

// Get the path to the root.
$full_path = __FILE__;

$path_bits = explode( 'wp-content', $full_path );

$url = $path_bits[0];

// Require WordPress bootstrap.
require_once( $url . '/wp-load.php' );

// Nonce security check.    
$nonce = $_GET['tmnf-shortcodes-nonce'];
if ( ! wp_verify_nonce( $nonce, 'framework-shortcode-generator' ) ) die( 'Security check' );

$tmnf_framework_version = '3.9';

$MIN_VERSION = '2.9';

$meetsMinVersion = version_compare($tmnf_framework_version, $MIN_VERSION) >= 0;

$tmnf_framework_path = dirname(__FILE__) .  '/../../';

$tmnf_framework_url = get_template_directory_uri() . '/functions/';

$tmnf_shortcode_css = $tmnf_framework_path . 'css/shortcodes.css';
                                  
$isThemnificTheme = file_exists($tmnf_shortcode_css);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div id="tmnf-dialog">

<?php if ( $meetsMinVersion && $isThemnificTheme ) { ?>
<div id="tmnf-options-buttons" class="clear">
	<div class="alignleft">
	
	    <input type="button" id="tmnf-btn-cancel" class="button" name="cancel" value="Cancel" accesskey="C" />
	    
	</div>
	<div class="alignright">
	    <input type="button" id="tmnf-btn-insert" class="button-primary" name="insert" value="Insert" accesskey="I" />  
	</div>
	<div class="clear"></div><!--/.clear-->
</div><!--/#tmnf-options-buttons .clear-->

<div id="tmnf-options" class="alignleft">
    <h3><?php echo __( 'Customize the Shortcode', 'Themnific' ); ?></h3>
    
	<table id="tmnf-options-table">
	</table>

</div>
<div class="clear"></div>


<script type="text/javascript" src="<?php echo esc_url( $tmnf_framework_url . 'js/shortcode-generator/js/column-control.js' ); ?>"></script>
<script type="text/javascript" src="<?php echo esc_url( $tmnf_framework_url . 'js/shortcode-generator/js/tab-control.js' ); ?>"></script>
<?php  }  else { ?>

<div id="tmnf-options-error">

    <h3><?php echo __( 'Shorcode Fail', 'themnific' ); ?></h3>
    
    <?php if ( $isThemnificTheme && ( ! $meetsMinVersion ) ) { ?>
    <p><?php echo sprinf ( __( 'Your version of the framework (%s) does not yet support shortcodes. Shortcodes were introduced with version %s of the framework.', 'themnific' ), $tmnf_framework_version, $MIN_VERSION ); ?></p>
    


<?php } else { ?>



<?php } ?>

<div style="float: right"><input type="button" id="tmnf-btn-cancel"
	class="button" name="cancel" value="Cancel" accesskey="C" /></div>
</div>

<?php  } ?>

<script type="text/javascript" src="<?php echo esc_url( $tmnf_framework_url . 'js/shortcode-generator/js/dialog-js.php' ); ?>"></script>
</div>
</body>
</html>