<?php

/**
 * Maintain the myplugins-asc.csv file
 *
 * Class myplugins_asc_csv
 *
 */

class myplugins_asc_csv {
	public $filename = 'myplugins-asc.csv';

	public $csv_lines;
	public $csv_dates;

	/**
	 *
	 */
	public $csv_dates_with_new_estimates = [];


	function __construct() {
		$this->csv_lines = [];
	}

	function read() {
		$this->csv_lines=file( $this->filename );
		echo count( $this->csv_lines);
		$this->populate_dates();
		$this->estimate_first_of_each_month();
	}

	function populate_dates() {
		$this->csv_dates = [];

		foreach (  $this->csv_lines as $csv_line ) {
			$myplugins = new myplugins( $csv_line );
			$date = $myplugins->get_date();
			$this->csv_dates[ $date ] = $myplugins;
			//echo $date;
			//echo PHP_EOL;
		}
	}

	/**
	 *
	 */

	function estimate_first_of_each_month() {
		$this->csv_dates_with_new_esimates = [];
		reset( $this->csv_dates );
		next( $this->csv_dates );
		$prev_date = key( $this->csv_dates );
		echo $prev_date;
		$next_month = $this->next_month( $prev_date );
		echo $next_month;
		$previous_myplugins = current( $this->csv_dates );

		foreach ( $this->csv_dates as $csv_date => $myplugins ) {
			echo $csv_date;
			if ( $csv_date !== 'Date' ) {
				if ( $csv_date === $next_month ) {
					$next_month = $this->next_month( $next_month );
				}
				while ( $csv_date > $next_month ) {
					echo "Estimating for $next_month, CSV date: $csv_date" . PHP_EOL;
					$this->csv_dates_with_new_estimates[ $next_month ]=$this->estimate( $next_month, $previous_myplugins, $myplugins );
					$next_month                                       =$this->next_month( $next_month );

					echo $csv_date;
					echo $next_month;
					if ( $csv_date > $next_month ) {
						echo "carry on";
					} else {
						echo "end loop";

					}

				}
			}
			
			$this->csv_dates_with_new_estimates[ $csv_date ] = $myplugins;
			if ( $myplugins->real === 'real' ) {
				$previous_myplugins = $myplugins;
			}

		}

	}

	/**
	 * Returns the first of the month of the next month
	 * Even if the current date is the first of the month?
	 * @param string $date in format ccyy-mm-dd
	 * @return string next month ccyy-mm-01
	 */

	function next_month( $date ) {
		list( $ccyy, $mm, $dd ) = explode( '-', $date );
		if ( $mm == 12 ) {
			$ccyy++;
			$mm = '01';
		} else {
			$mm++;
		}
		$next_month = $ccyy;
		$next_month .= '-';
		$next_month .= sprintf( '%02d', $mm);
		$next_month .= '-01';
		echo $next_month;
		echo PHP_EOL;

		return $next_month;

	}

	/**
	 * Writes the csv_dates_with_new_estimates to myplugins-est.csv
	 */
	function write() {
		echo count( $this->csv_dates_with_new_estimates);
		$this->filename = 'myplugins-est.csv';
		echo "Writing output to:" .  $this->filename;
		echo PHP_EOL;
		$output = null;
		foreach ( $this->csv_dates_with_new_estimates as $date => $myplugins ) {
			$output .= 	$myplugins->as_csv();
			$output .= PHP_EOL;
		}
		file_put_contents( $this->filename, $output);
	}



	function estimate( $required_date, $previous_myplugins, $next_myplugins ) {
		echo "Estimating for $required_date";
		$estimate_myplugin = [];
		$estimate_myplugin[] = $required_date;
		$estimate_myplugin[] = estimate( $required_date, null,
			$previous_myplugins->date, $previous_myplugins->total, $next_myplugins->date, $next_myplugins->total );
		$estimate_myplugin[] = 'est.';

		print_r( $previous_myplugins->components);
		print_r( $next_myplugins->components);
		reset( $next_myplugins->components );
		foreach ( $previous_myplugins->components as $key => $previous_value ) {
			$next_value = $next_myplugins->components[ $key ];
			if ( '' !== $previous_value && '' !== $next_value ) {
				$estimate_myplugin[]=estimate( $required_date, null,
					$previous_myplugins->date, $previous_value, $next_myplugins->date, $next_value );
			} else {
				$estimate_myplugin[] = null;
			}
		}
		$csv_line = implode( ',', $estimate_myplugin );
		echo $csv_line;
		echo PHP_EOL;
		return new myplugins( $csv_line );
	}



}