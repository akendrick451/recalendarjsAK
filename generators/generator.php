<?php
declare(strict_types=1);
namespace ReCalendar;

CONST blAKDebug = true;

function AKDebug (string $strMessage) {

	//if (blAKDebug) {
		echo "AKDebug " . $strMessage;
	//}

}

function PadIfSingleDigit(string $stringHour) : string {
	if (strlen($stringHour) == 1) {
		$stringHour = "0".$stringHour;
	}
	return $stringHour;
}

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
protected static function get_hour_table_html() : string  {



	$strHourTableHtml = '<table id="hourtable">';

	for ($hour = 6; $hour < 19; $hour++) {
    	$strHourTableHtml = $strHourTableHtml . "<tr><td align=left>" . PadIfSingleDigit((string)$hour) . "-" . PadIfSingleDigit((string)($hour+1)) . "</td><td>&nbsp;</td></tr>";
	}


	$strHourTableHtml = $strHourTableHtml . '</table>';
						
			

	return $strHourTableHtml;
}




protected static function generate_eisenhower_html($item_name, $total_number_of_rows) {

		$repeat_top = (int)($total_number_of_rows*.75);
		$repeat_bottom = (int)$total_number_of_rows-$repeat_top;
		$strEisenhowerHtml = ' <!-- =======================================open eisenhower tables===========================-->
		<!-- first need to close a table opened in outer function -->

		<tr><td style="padding-left:100px">'. str_replace("eisenhower", "", $item_name). '</td></table>
        <table id="eisenhowermatrix">
            <tr id="row1eisenhower">
                <td class="eisenhowercol1"></td>
                <td class="eisenhowercol2">URGENT</td>
                <td class="eisenhowercol3">NOT URGENT</td>
            </tr>
            <tr id="row2eisenhower">
                    <td class="vertical">I<br>M<br>P<br>O<br>R<br>T<br>A<br>N<br>T</td>
                    <td style="border-right:2px solid #ccc;border-bottom:2px solid #ccc;"> <table class="eisenhowerlines">
                    		<tr><td><span class="boxtext">DO NOW</span></td></tr>
						' . str_repeat('<tr><td></td></tr>', $repeat_top - 10) . '
						<tr><td align=center>
							' . self::get_hour_table_html() . '
						</td></tr>
                        </table></td>
                    <td style="border-bottom:2px solid #ccc;"><table class="eisenhowerlines">
							<tr><td><span class="boxtext">PLAN</span></td></tr> 
          					' . str_repeat('<tr><td></td></tr>', $repeat_top) . '
                        </table></td>
            </tr>
            <tr id="row3eisenhower">
                    <td class="vertical">N<Br>O<br>T<br>&nbsp;<br> I<br>M<br>P<br>O<br>R<br>T<br>A<br>N<br>T</td>
                    <td style="border-right:2px solid #ccc;"><span class="boxtext">DELEGATE</SPAN>
                    <table class="eisenhowerlines">
            			' . str_repeat('<tr><td></td></tr>', $repeat_bottom) . '
                        </table></td>
                    <td><span class="boxtext">DELETE</span>
                          <table class="eisenhowerlines">
                   
            			' . str_repeat('<tr><td></td></tr>', $repeat_bottom) . '

                        </table></td>
            </tr>


         <!-- no need for end table as this is done in outside fucntion generate content box -->
        <!-- =======================================close eisenhower tables===========================-->
		';
		//echo 'printing eisenhower html';
		echo $strEisenhowerHtml;

	}



	protected static function generate_content_box( array $items ) : void { //what is a content box???, list number and then content / text?, list number and then content / text?
		echo '<br><table class="content-box" align="center">';

		foreach ( $items as $item ) {
			$number_of_rows = $item[0];
			if ( $number_of_rows <= 0 ) {
				continue;
			}
			$item_name = $item[1];
			//akdebug ak add if title contains eisenhower, then print in eisenhower style
		
			if (str_contains(strtolower($item_name), 'eisenhower')) {
				self::generate_eisenhower_html($item_name, $number_of_rows);
			} else {
				echo "<tr><td class=\"content-box-line\">$item_name</td></tr>";
				$number_of_rows--;
				echo str_repeat( '<tr><td class="content-box-line"></td></tr>', $number_of_rows );
			} // end if eisenhower
		} // end foreach

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

		protected static function get_year_retrospective_anchor( \DateTimeImmutable $date ) : string {
		return self::get_week_number( $date ) . '-year-retrospective';
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
		$array_returned_values = $special_dates[ $date->format( 'd-m' ) ] ?? [];
		if ( gettype($array_returned_values) != "array") {
			echo "ERROR-Special Items must be in array format, eg even if only one value, put in square brackets ['My Birthday']";
		}
		return $special_dates[ $date->format( 'd-m' ) ] ?? [];
	}

	protected static function get_localized_month_name( \DateTimeImmutable $date, $months ) : string {
		return $months[ (int) $date->format( 'n' ) ] ?? 'Unknown month number';
	}

	protected static function is_weekend( \DateTimeImmutable $day ) : bool {
		return in_array( $day->format( 'N' ), [ '6', '7' ], true );
	}
}
