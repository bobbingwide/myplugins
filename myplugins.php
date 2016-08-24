<?php // (C) Copyright Bobbing Wide 2015, 2016

/**
 * Syntax: oikwp myplugins.php [pluginlist]
 * 
 * Count the downloads of my plugins from wordpress.org for the given plugins
 * 
 * Run this daily! 
 * 
 * {@link https://dd32.id.au/projects/wordpressorg-plugin-information-api-docs}
 * {@link http://code.tutsplus.com/tutorials/communicating-with-the-wordpress-org-plugin-api--wp-33069}
 *
 * Test output created during the coding of this routine are called wahay(n) where n starts from 2
 * 
 */

require_once( ABSPATH . "wp-admin/includes/plugin-install.php" );
oik_require( "libs/bobbfunc.php" );
oik_require( "includes/oik-remote.inc" );

oik_require( "class-wp-org-downloads.php", "play" );
//oik_require( "class-object-sorter.php", "play" );
//oik_require( "class-object.php", "play" );
//oik_require( "class-object-grouper.php", "play" );

$wpod = new WP_org_downloads();

$plugins_array = query_my_plugin_list(); 																		 
query_my_plugins( $wpod, $plugins_array );


/**
 * List my plugins
 * 
 * Obtain the list of plugins from the command line parameters. 
 * Default to @bobbingwide's plugins if none specified.
 * 
 * @return array array of plugin slugs 
 */
function query_my_plugin_list() {
	$plugins = oik_batch_query_value_from_argv( 1, null ); 
	if ( !$plugins ) {
		$plugins = "oik,oik-nivo-slider,oik-privacy-policy,cookie-cat,bbboing,uk-tides,oik-css,oik-batchmove,oik-read-more,oik-weightcountry-shipping,oik-bwtrace,allow-reinstalls,oik-weight-zone-shipping";
	}
	$plugins_array = bw_as_array( $plugins );
	return( $plugins_array );
}

/** 
 * Query the counts for selected plugins
 * 
 * @param object $wpod Instance of WP_org_downloads class
 * @param array $plugins array of plugins
 */
function query_my_plugins( $wpod, $plugins ) {
	echo "There are: " . count( $plugins ) . PHP_EOL;
	foreach ( $plugins as $plugin ) {
		$wpod->get_download( $plugin ); 
		$count = $wpod->get_download_count();
		$version = $wpod->response->version ; // get_version();
		$tested = $wpod->response->tested; // get_tested();
		$requires = $wpod->response->requires; // _get_requires();
		echo "$plugin,$count,$version,$tested,$requires" . PHP_EOL;
	}
}
