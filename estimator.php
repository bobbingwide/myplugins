<?php

/**
 * Estimates the total downloads on the start of each month
 *
 * php estimator.php component [start_year] [end_year]
 *
 * Given the file myplugins-asc.csv generate estimates for the first of each month
 * if they're not already there.
 * then produce a report for the selected component for the chosen date range.
 */

require_once 'class_myplugins_asc_csv.php';
require_once 'class_myplugins.php';

$myplugins_asc_csv = new myplugins_asc_csv();
$myplugins_asc_csv->read();
$myplugins_asc_csv->write();






/**
 * Given a .csv file of real figures estimate the values for a particular date
 *
 * oikwp estimator.php year
 * where year defaults to current year
 *
 */

function estimate(  $required_date_cymd, $required_value, $first_date_cymd, $first_value, $second_date_cymd, $second_value ) {

	$days_diff = days_diff( $first_date_cymd, $second_date_cymd );
	$value_diff = value_diff( $first_value, $second_value);

	$daily_delta = daily_delta( $value_diff, $days_diff );
	$days_adjust = days_diff( $first_date_cymd, $required_date_cymd );

	$estimated_value = $first_value + ( $days_adjust * $daily_delta );
	$estimated_value = round( $estimated_value, 0 );

	echo "Estimate:";
	echo $estimated_value;
	echo PHP_EOL;
	return $estimated_value;
}

function value_diff( $first_value, $second_value ) {
	if ( is_numeric( $first_value )) {


		$value_diff=$second_value - $first_value;
		echo $value_diff;
		echo PHP_EOL;
	} else {
		echo "Not numeric:". $first_value."!";
		gob();
	}
	return $value_diff;
}

function daily_delta( $value_diff, $days_diff) {
	if ( $days_diff ) {
		$daily_delta=$value_diff / $days_diff;
	} else {
		$daily_delta=0;
	}
	return $daily_delta;
}



function days_diff( $d1_cymd, $d2_cymd ) {

	$d1 = strtotime( $d1_cymd );
	$d2 = strtotime( $d2_cymd );
	$days_diff = $d2 - $d1;
	$days_diff /= 86400;
	echo "Days diff:";
	echo $days_diff;
	echo PHP_EOL;
	return $days_diff;

}
