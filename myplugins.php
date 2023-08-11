<?php // (C) Copyright Bobbing Wide 2015, 2016, 2019, 2020, 2021, 2023

/**
 * Syntax: oikwp myplugins.php [pluginlist]
 * 
 * Count the downloads of my plugins from wordpress.org for the given plugins
 * and keep the history in summary .csv files.
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

oik_require( "libs/class-wp-org-downloads.php", "wp-top12" );

$wpod = new WP_org_downloads();

$plugins_array = query_my_plugin_list(); 																		 
$count_array = query_my_plugins( $wpod, $plugins_array );
//print_r( $count_array );
echo "Total:" . array_sum( $count_array ), PHP_EOL;

$line = count_array_to_csv( $count_array );
//prepend_csv( 'myplugins.csv', $line);
$heading = get_heading();
echo $heading;
append_csv( 'myplugins-asc.csv', $heading );
append_csv( 'myplugins-asc.csv', $line );




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
		$plugins = "oik,oik-nivo-slider,oik-privacy-policy,cookie-cat,bbboing,uk-tides,oik-css,";
		$plugins .= "oik-batchmove,oik-read-more,oik-weightcountry-shipping,oik-bwtrace,allow-reinstalls,oik-weight-zone-shipping,sb-children-block,sb-chart-block";
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
	$count_array = [];
	echo "There are: " . count( $plugins ) . PHP_EOL;
	foreach ( $plugins as $plugin ) {
		if ( $wpod->get_download( $plugin ) ) {
			$count = $wpod->get_download_count();
			$version  = $wpod->response->meta->version; // get_version();
			$tested   = $wpod->response->meta->tested; // get_tested();
			$requires = $wpod->response->meta->requires; // _get_requires();
			$active   = $wpod->response->meta->active_installs;
			echo "$plugin,$count,$version,$tested,$requires,$active" . PHP_EOL;
		} else {
			echo "$plugin,0,not found" . PHP_EOL;
		}
		$count_array[ $plugin] = $count;
	}
	return $count_array;
}

function count_array_to_csv( $count_array, $real=true ) {
	$sum = array_sum( $count_array );
	//echo $sum;
	$real_or_est = $real ? "real" : "est.";
	array_unshift( $count_array, bw_format_date(), $sum, $real_or_est );
	$line = implode( ',', $count_array );
	$line .= PHP_EOL;
	return $line;
}


function dummy_query_my_plugins() {
	$count_array=[];
	$count_array[ 'oik' ]=166065;
	$count_array[ 'oik-nivo-slider' ]=91246;
	$count_array[ 'oik-privacy-policy' ]=60314;
	$count_array[ 'cookie-cat' ]=26647;
	$count_array[ 'bbboing' ]=1482;
	$count_array[ 'uk-tides' ]=3713;
	$count_array[ 'oik-css' ]=1778;
	$count_array[ 'oik-batchmove' ]=3718;
	$count_array[ 'oik-read-more' ]=3604;
	$count_array[ 'oik-weightcountry-shipping' ]=46291;
	$count_array[ 'oik-bwtrace' ]=1630;
	$count_array[ 'allow-reinstalls' ]=1579;
	$count_array[ 'oik-weight-zone-shipping' ]=9976;
	$count_array[ 'sb-children-block' ]=107;
	$count_array[ 'sb-chart-block' ]=11;
	return $count_array;
}

/**
 * Prepends the line to the top of the CSV file, after the heading line.
 *
 * @param $file
 * @param $line
 */
function prepend_csv( $file, $line ) {
	echo "Prepending to: $file";
	echo PHP_EOL;
	echo $line;
	echo PHP_EOL;
	gob( 'to be completed');

}

function append_csv( $file, $line ) {
	if ( line_not_already_present( $file, $line ) ) {
		file_put_contents( $file, $line, FILE_APPEND );
	} else {
		echo "Not appending to $file";
		echo PHP_EOL;
	}
}

/**
 * Determines if the line is not already present in the file.
 *
 * @param $file
 * @param $line
 *
 * @return bool
 */
function line_not_already_present( $file, $line ) {
	$not_already_present = !file_exists( $file );
	if ( !$not_already_present ) {
		$contents = file( $file );
		$already_present = array_search( $line, $contents);
		if ( false === $already_present ) {
			echo "Not already present";
			$not_already_present = true;

		} else {
			echo "Already present at " . $already_present;
			$not_already_present = false;
		}
	}

	return $not_already_present;
}

function get_heading() {
	$heading_array = array_keys( dummy_query_my_plugins() );
	//print_r( $heading_array );
	array_unshift( $heading_array, 'Date', 'Total', 'Real?');
	$line = implode( ',', $heading_array );
	$line .= PHP_EOL;
	return $line;
}