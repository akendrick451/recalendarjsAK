<?php
declare(strict_types=1);

namespace ReCalendar;

abstract class Generator {
	protected $config;

	public function __construct( Config $config ) {
		$this->config = $config;
	}

	public function generate() : string {

		
		ob_start();
		$this->generate_anchor();
		$this->generate_content();
		$time_end = microtime(true);
		
		return ob_get_clean();
	}

	private function generate_anchor() : void {
		$anchor_string = $this->generate_anchor_string();
		if ( empty ( $anchor_string ) ) {
			return;
		}

		echo "<a name=\"$anchor_string\"></a>";
	}

	abstract protected function generate_content() : void;
	abstract protected function generate_anchor_string() : ?string;

	protected static function generate_content_box( array $items ) : void { //what is a content box???
		echo '<br><table class="content-box" align="center">';

		foreach ( $items as $item ) {
			$number_of_rows = $item[0];
			if ( $number_of_rows <= 0 ) {
				continue;
			}
			$item_name = $item[1];

			echo "<tr><td class=\"content-box-line\">$item_name</td></tr>";
			$number_of_rows--;
			echo str_repeat( '<tr><td class="content-box-line"></td></tr>', $number_of_rows );
		}

		echo '</table>';
	}

	protected static function generate_content_box2( array $items ) : void { 
		echo '<br><table class="content-box" align="center">';
		$item_count = 0;
		foreach ( $items as $item ) {					
			if ($item_count == 0) {
				echo "<tr><td class=\"content-box-line-ak-strong\"> $item </td></tr>";	
			} else {
				echo "<tr><td class=\"content-box-line-ak\"> $item </td></tr>";
			}
			$item_count = $item_count + 1;
		}

		echo '</table>';
	}

	protected static function generate_content_box_justified( array $items ) : void { 
		// AK I acdtually removed the justified css from here!!! very badly named NOW!!!! bad code
		echo '<br><table class="content-box" align="center">';
		$item_count = 0;
		foreach ( $items as $item ) {					
			if ($item_count == 0) {
				echo "<tr><td class=\"content-box-line-ak-strong\"> $item </td></tr>";	
			} else {
				echo "<tr><td class=\"content-box-line-ak\"> $item </td></tr>";
			}
			$item_count = $item_count + 1;
		}

		echo '</table>';
	}

	protected static function get_day_entry_anchor( \DateTimeImmutable $date ) : string {
		return $date->format( 'dmY' ) . '-entry';
	}

	protected static function get_month_overview_anchor( \DateTimeImmutable $date ) : string {
		return $date->format( 'dmY' ) . '-month-overview';
	}

	protected static function get_week_overview_anchor( \DateTimeImmutable $date ) : string {
		return self::get_week_number( $date ) . '-week-overview';
	}

	protected static function get_week_retrospective_anchor( \DateTimeImmutable $date ) : string {
		return self::get_week_number( $date ) . '-week-retrospective';
	}

	protected static function get_year_overview_anchor() : string {
		return 'year-overview';
	}

	protected static function get_week_number( \DateTimeImmutable $week ) : int {
		return (int) $week->modify( 'thursday this week' )->format( 'W' );
	}

	protected static function get_days_in_month( \DateTimeImmutable $date ) : int {
		return (int) $date->format( 'd');
	}

	protected static function get_matching_special_items( \DateTimeImmutable $date, array $special_dates ) : array {
		return $special_dates[ $date->format( 'd-m' ) ] ?? [];
	}

	protected static function get_localized_month_name( \DateTimeImmutable $date, $months ) : string {
		return $months[ (int) $date->format( 'n' ) ] ?? 'Unknown month number';
	}

	protected static function is_weekend( \DateTimeImmutable $day ) : bool {
		return in_array( $day->format( 'N' ), [ '6', '7' ], true );
	}
}
