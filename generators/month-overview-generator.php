<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';
require_once __DIR__ . '/calendar-generator.php';

class MonthOverviewGenerator extends Generator {
	private $month;
	private $calendar_generator;

	public function __construct( \DateTimeImmutable $date, CalendarGenerator $calendar_generator, Config $config ) {
		parent::__construct( $config );
		$this->month = $date->modify( 'first day of this month' );
		$this->calendar_generator = $calendar_generator;
	}

	protected function generate_anchor_string() : ?string {
		return self::get_month_overview_anchor( $this->month );
	}

	protected function generate_content() : void {
		$month_name = self::get_localized_month_name( $this->month, $this->config->get( Config::MONTHS ) );
		$calendar_html = $this->calendar_generator->generate();
?>

<table width="95%">
			<tr>
				<td style="border-bottom: 1px solid black;" class="header-line month-overview__month-name">Month Review </td>
				<td class="calendar-box"><?php echo $calendar_html ?></td>
			</tr>
		</table>

		</table>
		<br>
		<table width="95%" border="1"><!-- ====================== 2 June 2024 atk close table for month plan by day ================================== -->
					<tr><td width="10%">Notes for Review of Month</td><td width="90%">&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br>
					&nbsp;<br></td></tr>
		</table> <!-- ====================== close table for june plan day ============================================ -->
		<pagebreak />
		<table width="100%">
			<tr>
				<td style="border-bottom: 1px solid black;" class="header-line month-overview__month-name"><?php echo $month_name; ?> Plan </td>
				<td class="calendar-box"><?php echo $calendar_html ?></td>
			</tr>
		</table>
		

<?php
		$habits_all = $this->config->get( Config::HABITS );
		$habits = $habits_all[ (int) $this->month->format( 'n' ) ] ?? $this->config->get( Config::HABITS_COMMON ); 
		if ( ! empty( $habits ) ) {
			self::generate_habits_table( $habits );
		}

		// itinerary items seems to be how may lines to show on day view
		
		$all_itinerary_items = $this->config->get( Config::DAY_ITINERARY_ITEMS );
		$itinerary_items = $all_itinerary_items[ Config::DAY_ITINERARY_MONTH_OVERVIEW ] ?? $all_itinerary_items[ Config::DAY_ITINERARY_COMMON ];
		self::generate_content_box( $itinerary_items );
?>
<?php
	}

	private function generate_habits_table( array $habits ) : void {
		$habits_title = $this->config->get( Config::HABITS_TITLE );
		
?>
		<table class="content-box">
			<thead>
				<tr>
					<th rowspan="2"><?php echo $habits_title; ?></th>
<?php
					$end_of_month = $this->month->modify( 'first day of next month' );
					$month_period = new \DatePeriod( $this->month, new \DateInterval( 'P1D' ), $end_of_month );
					$i = 1;
					foreach ( $month_period as $day ) {
						$day_number = $day->format( 'j' );
						$day_entry_anchor = self::get_day_entry_anchor( $day );
						echo "<th class=\"month-overview__habit-header\"><a href=\"$day_entry_anchor\">$day_number</a></th>";
						$i++;
					}
					for ( ; $i <= 31; $i++ ) {
						echo '<th class="month-overview__habit-header disabled">&nbsp;</th>';
					}

					echo '</tr><tr>';

					$i = 1;
					foreach ( $month_period as $day ) {
						$day_name = strftime( '%a', $day->getTimestamp() );
						$day_entry_anchor = self::get_day_entry_anchor( $day );
						$css_classes = 'month-overview__habit-header name';
						if ( self::is_weekend( $day ) ) {
							$css_classes .= ' weekend';
						}
						echo 
						"<th class=\"$css_classes\"><a href=\"$day_entry_anchor\">$day_name</a></th>";
						$i++;
					}
					for ( ; $i <= 31; $i++ ) {
						echo '<th class="month-overview__habit-header disabled">&nbsp;</th>';
					}
?>
				</tr>
			</thead>
			<tbody>
<?php
					foreach ( $habits as $habit ) {
						$this->generate_habit_row( $habit );
					}
?>
			</tbody>
		</table>
		<br>
		<table class="monthplan" width="95%"><!-- ====================== 2 June 2024 atk table month plan by day ================================== -->
			<tr><th>Date</th><th>Day</th><th>Details</th></tr>

<?php		
			$end_of_month = $this->month->modify( 'first day of next month' );
			$month_period = new \DatePeriod( $this->month, new \DateInterval( 'P1D' ), $end_of_month );
			$i = 1;
			foreach ( $month_period as $day ) {
				$day_number = $day->format( 'j' );
				$day_name = strftime( '%a', $day->getTimestamp() );
				$day_entry_anchor = self::get_day_entry_anchor( $day );
				$css_classes = 'month-overview__habit-header name';
						if ( self::is_weekend( $day ) ) {
							$css_classes .= ' weekend';
						}

				echo "<tr class=\"monthplan\">
				    <td width=\"100\" class=\"$css_classes\">$day_number</td>
					<td width=\"100\" class=\"$css_classes\">$day_name</td>
					<td width=\"300\" class=\"$css_classes\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;</td></tr>";
				$i++;
			}
			
			
?>					
		</table> <!-- ====================== close table for june plan day ============================================ -->
		<pagebreak />
	<?php
	}

	private function generate_habit_row( string $habit_name ) : void {
		echo "<tr><td class=\"month-overview__habit-name\">$habit_name</td>";

		$end_of_month = $this->month->modify( 'first day of next month' );
		$month_period = new \DatePeriod( $this->month, new \DateInterval( 'P1D' ), $end_of_month );
		$i = 1;
		foreach ( $month_period as $day ) {
			$css_classes = 'month-overview__habit-box';
			if ( self::is_weekend( $day ) ) {
				$css_classes .= ' weekend';
			}
			echo "<td class=\"$css_classes\"></td>";

			$i++;
		}
		for ( ; $i <= 31; $i++ ) {
			echo '<td class="month-overview__habit-box disabled"></td>';
		}
		echo "</tr>";
	}
}
