<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';
require_once __DIR__ . '/calendar-generator.php';

class YearOverviewGenerator extends Generator {
	private $year_start;
	private $year_end;
	//I need to set year end to Dec of this year

	public function __construct( \DateTimeImmutable $year_start, \DateTimeImmutable $year_end, Config $config ) {
		parent::__construct( $config );
		$this->year_start = $year_start;
		$this->year_end = $year_end;
	}

	protected function generate_anchor_string() : ?string {
		return self::get_year_overview_anchor();
	}

	public function generate_actual_big_calendar() : ?string {
		$interval = new \DateInterval( 'P1M' );
		$period = new \DatePeriod( $this->year_start, $interval, $this->year_end );

		$strReturn =  '<table class="year-overview__calendars">';
		$strReturn .= '<tr>';
		$strReturn .=  '<td class="year-overview__calendar">' ;
	    $strReturn .=  '   <table class="akyearlyplan" style-"border=1px solid #eee">';
		foreach ( $period as $index => $month ) {
			$is_new_row = 0 === ( $index % 3 );
			if ( $is_new_row ) {
				if ( $index > 0 ) {
					$strReturn .=  '</tr>';
				}
				$strReturn .=  '<tr>';
			}
			$calendar_generator = new CalendarGenerator( $month, CalendarGenerator::HIGHLIGHT_NONE, $this->config, true );
			
			$strReturn .=  "<td styl='bs'>" . $calendar_generator->get_month_link() . '</td>';
		}
		$strReturn .=  '</tr></table>';
		$strReturn .=  '</td></tr></table>';
		return $strReturn ;
	}
	protected function generate_content() : void {
		
		$title = (int) $this->year_start->format( 'Y' );
		echo "<h1 class=\"year-overview__title\"><a name='" . $this->generate_anchor_string() . "'></a>$title Planner ATKPlanner</h1>";
		echo "&nbsp;&nbsp;<u>Insert link here to weekly plan and review and monthly planner document</u>";
		echo "<Br>&nbsp;&nbsp;";
		echo "<Br>&nbsp;&nbsp;<u>Insert link here to Work todo document</u>";
		echo "<Br>&nbsp;&nbsp;";
		echo "<Br>&nbsp;&nbsp;Use the highlight function in boox to link";
		echo "<Br>&nbsp;&nbsp;";
		 echo $this->generate_actual_big_calendar();

		
			

    }

	/*
OLDER FILE
<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';
require_once __DIR__ . '/calendar-generator.php';

class YearOverviewGenerator extends Generator {
	private $year_start;
	private $year_end;

	public function __construct( \DateTimeImmutable $year_start, \DateTimeImmutable $year_end, Config $config ) {
		parent::__construct( $config );
		$this->year_start = $year_start;
		$this->year_end = $year_end;
	}

	protected function generate_anchor_string() : ?string {
		return self::get_year_overview_anchor();
	}

	protected function generate_content() : void {
		$interval = new \DateInterval( 'P1M' );
		$period = new \DatePeriod( $this->year_start, $interval, $this->year_end );

		$title = (int) $this->year_start->format( 'Y' );
		echo "<h1 class=\"year-overview__title\">$title</h1>";
		echo '<table class="year-overview__calendars">';
		foreach ( $period as $index => $month ) {
			$is_new_row = 0 === ( $index % 3 );
			if ( $is_new_row ) {
				if ( $index > 0 ) {
					echo '</tr>';
				}
				echo '<tr class="year-overview__row">';
			}
			$calendar_generator = new CalendarGenerator( $month, CalendarGenerator::HIGHLIGHT_NONE, $this->config, true );
			echo '<td class="year-overview__calendar">' . $calendar_generator->generate() . '</td>';
		}
		echo '</tr></table>';
	}
}


new code
echo '<tr>';
			echo '<td class="year-overview__calendar">' 
                .'   <table class="akyearlyplan" style-"border=1px solid #eee">
                    <tr><td><a href="#01012025-month-overview">Jan</a></td><td><a href="#01022025-month-overview">Feb</a></td><td><a href="#01032025-month-overview">Mar</a></td></tr>
                    <tr><td><a href="#01042025-month-overview">Apr</a></td><td><a href="#01052025-month-overview">May</a></td><td><a href="#01062025-month-overview">Jun</a></td></tr>
                    <tr><td><a href="#01072025-month-overview">Jul</a></td><td><a href="#01008025-month-overview">Aug</a></td><td><a href="#01092025-month-overview">Sept</a></td></tr>
                    <tr><td><a href="#01102025-month-overview">Oct</a></td><td><a href="#01112025-month-overview">Nov</a></td><td><a href="#01122025-month-overview">Dec</a></td></tr>
            </tr></table>' .
             '</td>';
*/

} // end class
