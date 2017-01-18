<?php
/**
 * Indludes
 *
 * Loads necessary include files.
 */

$pchc_includes = [
  'lib/listpages.php',     // List pages shortcode
  'lib/config.php',           // Configuration
];

foreach( $pchc_includes as $file ) {
  if( !$filepath = locate_template($file) ) {
    trigger_error( sprintf( __( 'Error locating %s for inclusion', 'g5_helium-child'), $file ), E_USER_ERROR);
  }

  require_once $filepath;
}

unset($file, $filepath);
