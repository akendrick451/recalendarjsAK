<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';
require_once __DIR__ . '/calendar-generator.php';

class YearRetrospectiveGenerator extends Generator {
	private $week;
	private $week_number;
	private $calendar_generator;

	public function __construct( \DateTimeImmutable $week, CalendarGenerator $calendar_generator, Config $config ) {
		parent::__construct( $config );
		$this->week = $week;
		$this->week_number = self::get_week_number( $week );
		$this->calendar_generator = $calendar_generator;
	}

	protected function generate_anchor_string() : ?string {
		return self::get_year_retrospective_anchor( $this->week );
	}



	 function convert_month_number_to_name ($monthNumber) : string {

		// Create a timestamp for the first day of the specified month
		$timestamp = mktime(0, 0, 0, $monthNumber, 1, 0);

		// Format the timestamp to get the full month name
		$monthName = date('F', $timestamp);

		return $monthName; // Output: October

	} // end convert_month_n umber


	protected function generate_content() : void {
		$calendar_html = $this->calendar_generator->generate();
		$week_start = strftime( '%d %B', $this->week->modify( 'monday this week' )->getTimestamp() );
		$week_end = strftime( '%d %B', $this->week->modify( 'sunday this week' )->getTimestamp() );
		$year_overview_anchor = self::get_year_overview_anchor( $this->week );
		$previous_week_retrospective_anchor = self::get_year_retrospective_anchor( $this->week->modify( 'previous week' ) );
		$next_week_retrospective_anchor = self::get_year_retrospective_anchor( $this->week->modify( 'next week' ) );
?>
		<table width="100%">
			<tr>
				<td class="week-retrospective__week-name"><?php echo $this->config->get( Config::YEARLY_RETROSPECTIVE_TITLE ); ?></td>
				<td class="week-retrospective__previous-week"><a href="#<?php echo $previous_week_retrospective_anchor; ?>">«</a></td>
				<td class="week-retrospective__day-number"><a href="#<?php echo $year_overview_anchor; ?>"><?php echo $this->week_number; ?></a></td>
				<td class="week-retrospective__next-week"><a href="<?php echo $next_week_retrospective_anchor; ?>">»</a></td>
				<td rowspan="2" class="calendar-box"><?php echo $calendar_html ?></td>
			</tr>
			<tr>
				<td colspan="4" class="header-line week-retrospective__range"><?php echo $week_start; ?> - <?php echo $week_end; ?></td>
			</tr>
		</table>
<?php
		$all_itinerary_items = $this->config->get( Config::DAY_ITINERARY_ITEMS );
		$itinerary_items = $all_itinerary_items[ Config::DAY_ITINERARY_WEEK_RETRO ] ?? $all_itinerary_items[ Config::DAY_ITINERARY_COMMON ];
		//self::generate_content_box( $itinerary_items );
     

        /*			
			$month_notes_in_day = $this->config->get( Config::MONTHLY_NOTES );
			$month_notes_in_day[0] = $month_name. " " . $month_notes_in_day[0]; // add month name to first item in month list
			self::generate_content_box2($month_notes_in_day);
*/
			// AK NEW TEXT DEC 2024. TRYING TO MAKE MONTHLY NOTES SPECIFIC TO MONTH
			$month_notes_all_months = $this->config->get( Config::MONTHLY_NOTES_2 );

                
    		$month_notes_all_months_without_month_number = [];
			$month_notes_common = $this->config->get( Config::MONTHLY_NOTES_COMMON );

			$i =0;
			$yearly_activites_table = "<table id='year-review-table'><tr>";
			ksort($month_notes_all_months);
    		foreach ($month_notes_all_months as $month => $notes_and_activities) {
			
				if ($i > 0 & $i % 3 == 0 & $i<12) {  // if we are  3 or 6 or 9 close tr and create new tr
					$yearly_activites_table = $yearly_activites_table . "</tr><tr>";
				}
				
				$yearly_activites_table = $yearly_activites_table . "<td>";

				$yearly_activites_table = $yearly_activites_table . "<b>". $this->convert_month_number_to_name($month) . "</b><br>";

				foreach ($notes_and_activities as $each_activity ) {
						$yearly_activites_table = $yearly_activites_table . $each_activity . "<br>";

					}

				$yearly_activites_table = $yearly_activites_table . "</td>";

				$month_notes_all_months_without_month_number = array_unique(array_merge($month_notes_all_months_without_month_number, $notes_and_activities));
    			$i = $i + 1;
			}
		

			$yearly_activites_table = $yearly_activites_table .  "</tr></table>";

			$month_notes_combined = array_unique(array_merge($month_notes_common, $month_notes_all_months_without_month_number));
			// ak thinks this prints to html... how to print to terminal??


			$dateNow   = new \DateTime(); //this returns the current date time
			
			$yearly_activites_table = $yearly_activites_table . "<div class='page-break-before'><b>Common Items Across Months:</b></div>";
			


			echo $yearly_activites_table;
			self::generate_content_box2($month_notes_common);
			$yearly_activites_table = "<html><head><link rel='stylesheet' href='../styles.css'></head><body>". $yearly_activites_table;


			file_put_contents("output//recalendarForPDFyear" . $dateNow->format('Y-m-d-H-i-s') . ".html", $yearly_activites_table);
				
		//	self::generate_content_box2( $month_notes_combined ); 
?>
<?php
	}
}
