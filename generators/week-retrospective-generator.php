<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';
require_once __DIR__ . '/calendar-generator.php';

class WeekRetrospectiveGenerator extends Generator {
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
		return self::get_week_retrospective_anchor( $this->week );
	}

	protected function generate_content() : void {
		$calendar_html = $this->calendar_generator->generate();
		$week_start = date( 'd F', $this->week->modify( 'monday this week' )->getTimestamp() );
		$week_end = date( 'd F', $this->week->modify( 'sunday this week' )->getTimestamp() );
		$week_overview_anchor = self::get_week_overview_anchor( $this->week );
		$previous_week_retrospective_anchor = self::get_week_retrospective_anchor( $this->week->modify( 'previous week' ) );
		$next_week_retrospective_anchor = self::get_week_retrospective_anchor( $this->week->modify( 'next week' ) );
?>
		<table width="100%">
			<tr>
				<td class="week-retrospective__week-name"><?php echo $this->config->get( Config::WEEKLY_RETROSPECTIVE_TITLE ); ?></td>
				<td class="week-retrospective__previous-week"><a href="#<?php echo $previous_week_retrospective_anchor; ?>">«</a></td>
				<td class="week-retrospective__day-number"><a href="#<?php echo $week_overview_anchor; ?>"><?php echo $this->week_number; ?></a></td>
				<td class="week-retrospective__next-week"><a href="<?php echo $next_week_retrospective_anchor; ?>">»</a></td>
				<td rowspan="2" class="calendar-box"><?php echo $calendar_html ?></td>
			</tr>
			<tr>
				<td colspan="4" class="header-line week-retrospective__range"><?php echo $week_start; ?> - <?php echo $week_end; ?></td>
			</tr>
		</table>
		<table width="100%"><tr><td width="70%"><!-- outer table with weekly review days, successes and notes below both --> 
			<?php $this->generate_week_overview(true);?>
			 <!-- close table for weekly days -->
</td>		<td rowspan="2" width="30%" valign=top><table width="98%"> <!-- success table on right side of weekly days review-->
			<tr><td class="content-box-height">Recent Successes</td></tr>
				<?php			
							echo str_repeat( '<tr><td class="content-box-line-smaller"></td></tr>',  6);
							
				?>
				<tr><td class="content-box-height">Next Sucess/Dreams</td></tr>
				<?php			
							echo str_repeat( '<tr><td class="content-box-line-smaller"></td></tr>',  6);
							
				?>
				<tr><td class="content-box-height">Grateful/Best thing this week</td></tr>
				<?php			
							echo str_repeat( '<tr><td class="content-box-line-smaller"></td></tr>',  6);
							
				?>
				<tr><td class="content-box-height">What I learnt this week?</td></tr>
				<?php			
							echo str_repeat( '<tr><td class="content-box-line-smaller"></td></tr>',  6);
							
				?>
			</table> <!-- /success table -->
	
				</td></tr><!-- outside table close row -->
				<tr><td>
					<table class="content-box" align="center">
						<tr><td colspan="2" class="ruledLinesTDSmaller"><b>Notes on Week</b></td></tr>
							<?php echo str_repeat('<tr><td  colspan="2" class="ruledLinesTDSmaller">&nbsp;</td></tr>', 10); ?>
				</table>
				</td><Td></td></tr>
				</table><!-- /close outer table with weekly review days, successes and notes below both --> 
<?php
	} // end function


public function generate_week_overview(bool $blRetrospective = false) : void {

		?>
		<table class="content-box" align="center">
				<tr><td class="content-box-height">What I'm doing for others this week?</td></tr>
				<tr><td style="border-bottom:1px solid #AAA">&nbsp;</td></tr>
				<tr><td style="border-bottom:1px solid #AAA">&nbsp;</td></tr>
		

<?php 
					
		$month_start_week_number = self::get_week_number( $this->week->modify( 'first day of this month' )->modify( 'monday this week' ) );
		$month_end_week_number = self::get_week_number( $this->week->modify( 'last day of this month' )->modify( 'monday this week' ) );
		$day_entry_height = self::get_day_entry_height( $month_start_week_number, $month_end_week_number );
		$next_week = $this->week->modify( 'next week' );
		$week_period = new \DatePeriod( $this->week, new \DateInterval( 'P1D' ), $next_week );
		$week_days = [];
		foreach ( $week_period as $week_day ) {
			$week_days[] = $week_day;
		}
?>
				<?php  $this->generate_day_entry( $week_days[0], $day_entry_height,  $this->config, $blRetrospective ); ?> 
				<?php  $this->generate_day_entry( $week_days[1], $day_entry_height ,  $this->config, $blRetrospective ); ?>
				<?php   $this->generate_day_entry( $week_days[2], $day_entry_height ,  $this->config, $blRetrospective ); ?>
				<?php   $this->generate_day_entry( $week_days[3], $day_entry_height ,  $this->config, $blRetrospective ); ?>
				<?php  $this->generate_day_entry( $week_days[4], $day_entry_height ,  $this->config, $blRetrospective ); ?>
				<?php  $this->generate_day_entry( $week_days[5], $day_entry_height ,  $this->config, $blRetrospective ); ?>
				<?php  $this->generate_day_entry( $week_days[6], $day_entry_height ,  $this->config, $blRetrospective ); ?>
				<tr><td colspan="2" class="week-overview__notes">
<?php 
					$weekly_todos = $this->config->get( Config::WEEKLY_TODOS );
					foreach ( $weekly_todos as $weekly_todo ) {
						$strReturnText= $strReturnText .  "<span>$weekly_todo</span><br />";
					}
					?>

			</td></tr></table>
<?php	
	}

	public function old_generate_week_overview(bool $blRetrospective = false) : void {
		?>
		<table class="content-box" align="center">
				<?php
					//$all_itinerary_items = $this->config->get( Config::DAY_ITINERARY_ITEMS );
					//$itinerary_items = $all_itinerary_items[ Config::DAY_ITINERARY_WEEK_RETRO ] ?? $all_itinerary_items[ Config::DAY_ITINERARY_COMMON ];
					//self::generate_content_box( $itinerary_items );
					$next_week = $this->week->modify('next week');
					$this_week = $this->week->modify('this week');
					//echo "next_week is" . $next_week->format('Y-m-d H:i:s');
					//echo "this_week is" . $this_week->format('Y-m-d H:i:s');
					$week_period = new \DatePeriod( $this->week, new \DateInterval( 'P1D' ), $next_week );
					$week_days = [];
					$month_start_week_number = self::get_week_number( $this->week->modify( 'first day of this month' )->modify( 'monday this week' ) );
					$month_end_week_number = self::get_week_number( $this->week->modify( 'last day of this month' )->modify( 'monday this week' ) );
					$day_entry_height = self::get_day_entry_height( $month_start_week_number, $month_end_week_number );
					foreach ( $week_period as $week_day ) {
						$week_days[] = $week_day;
					}
					$blRetrospective = true;

			?>

							<?php $this->generate_day_entry( $week_days[0], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<?php $this->generate_day_entry( $week_days[1], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<?php $this->generate_day_entry( $week_days[2], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<?php $this->generate_day_entry( $week_days[3], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<?php $this->generate_day_entry( $week_days[4], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<?php $this->generate_day_entry( $week_days[5], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<?php $this->generate_day_entry( $week_days[6], $day_entry_height ,  $this->config, $blRetrospective ); ?>
							<tr><td colspan="2" class="week-overview__notes">
<?php
					$weekly_todos = $this->config->get( Config::WEEKLY_TODOS );
					foreach ( $weekly_todos as $weekly_todo ) {
						echo "<span>$weekly_todo</span><br />";
					}
?></td></tr></table>
<?php
	} // end function 

} // end class
