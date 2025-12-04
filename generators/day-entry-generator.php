<?php
declare(strict_types=1);

namespace ReCalendar;

//ATK Modified a fair bit to add my own page in months - 29/05/2024 see comment re table "open atk table"

require_once __DIR__ . '/generator.php';
require_once __DIR__ . '/calendar-generator.php';

class DayEntryGenerator extends Generator {
	private $day;
	private $calendar_generator;

	public function __construct( \DateTimeImmutable $day, CalendarGenerator $calendar_generator, Config $config ) {
		parent::__construct( $config );
		$this->day = $day;
		$this->calendar_generator = $calendar_generator;
	}

	protected function generate_anchor_string() : ?string {
		return self::get_day_entry_anchor( $this->day );
	}



	protected function get_random_quote() : ?string {
		// AK 7/6/2024 ------------===========================================================>
		// AK 7/6/2024 ------------===========================================================>
	
		$strQuotesArr = array("Men fall in love with their eyes and women fall in love with their ears");
		$strQuotesArr[] = "Do you want to be a slave to your whims? Jordan Peterson. Compare this with an idea of freedom which means to do whatever we feel. Different to whatever we choose. Implying choice might not be always what we feel like. It struck me at the time Dec 7, 2023";
		$strQuotesArr[] = "Not all those who wander are lost. JRR Tolkien";
		$strQuotesArr[] = "The slower you go, the further you get (re counselling session). Nigel Polak";
		$strQuotesArr[] = "There is no try";
		$strQuotesArr[] = "The unexamined life is not worth living. Aurelius";
		$strQuotesArr[] = "'The secret of getting ahead is getting started' – Mark Twain";
		$strQuotesArr[] = "Go confidently in the direction of your dreams. Live the life you have imagined – Henry David Thoreau";
		$strQuotesArr[] = "Take action. An inch of movement will bring you closer to your goals than a mile of intention” – Steve Maraboli";
		$strQuotesArr[] = "We generate fears while we sit. We overcome them by action” – Dr. Henry Link";
		$strQuotesArr[] = "Imagine your life is perfect in every respect; what would it look like?” – Brian Tracy";
		$strQuotesArr[] = "Decide upon your major definite purpose in life and then organize all your activities around it.” – Brain Tracy";
		$strQuotesArr[] = "It is not the critic who counts; not the man who points out how the strong man stumbles, or where the doer of deeds could have done them better. The credit belongs to the man who is actually in the arena... Theodore Roosevelt";
		$strQuotesArr[] = "'Stay away from those people who try to disparage your ambitions. Small minds will always do that, but great minds will give you a feeling that you can become great too.' — Mark Twain";
		$strQuotesArr[] = "'It is only when we take chances, when our lives improve. The initial and the most difficult risk that we need to take is to become honest. —Walter Anderson";
		$strQuotesArr[] = "Success is not final; failure is not fatal: It is the courage to continue that counts. — Winston S. Churchill";
		$strQuotesArr[] = "'Develop success from failures. Discouragement and failure are two of the surest stepping stones to success.' —Dale Carnegie";
		$strQuotesArr[] = "'Don’t let yesterday take up too much of today.' — Will Rogers";
		$strQuotesArr[] = "Tomorrow is a new day with no mistakes in it yet - Anne Shirley";
		$strQuotesArr[] = "'Concentrate all your thoughts upon the work in hand. The sun's rays do not burn until brought to a focus. ' — Alexander Graham Bell";
		$strQuotesArr[] = "'Either you run the day or the day runs you.' — Jim Rohn";
		$strQuotesArr[] = "'I’m a greater believer in luck, and I find the harder I work the more I have of it.' — Thomas Jefferson";
		$strQuotesArr[] = "'When we strive to become better than we are, everything around us becomes better too.' — Paulo Coelho";
		$strQuotesArr[] = "'Opportunity is missed by most people because it is dressed in overalls and looks like work.' — Thomas Edison";
		$strQuotesArr[] = "'Do you want to be right or happy?' — Fr Emmerich Vogt re the Twelve Steps";
		$strQuotesArr[] = "'Get off the cross, we need the wood' — Fr Emmerich Vogt re the Twelve Steps";


		$intRandomNumber = rand(0,count($strQuotesArr)-1);
        return $strQuotesArr[$intRandomNumber];

	} //get_random_quote
    
	protected function get_random_affirmation() : ?string {

		$all_affirmations = $this->config->get( Config::AFFIRMATIONS );
		$intRandomNumber = rand(0,count($all_affirmations)-1);

		return $all_affirmations[$intRandomNumber];

	} // get random function




	protected function get_random_bible_verse() : ?string {

		$all_bible_verses = $this->config->get( Config::BIBLE_VERSES );
		$intRandomNumber = rand(0,count($all_bible_verses)-1);

		return $all_bible_verses[$intRandomNumber];

	} // get random get_random_bible_verse
	
	protected function get_random_ak_information() : ?string {
		$all_ak_information = $this->config->get( Config::AK_INFORMATION );
		$intRandomNumber = rand(0,count($all_ak_information)-1);

		return $all_ak_information[$intRandomNumber];

	} // end get random ak information
	
	// called from parent class generate()
	protected function generate_content() : void {
		$day_number = $this->day->format( 'd' );
		$month_name = self::get_localized_month_name( $this->day, $this->config->get( Config::MONTHS ) );
		$month_overview_anchor = self::get_month_overview_anchor( $this->day );
		$calendar_html = $this->calendar_generator->generate();
		$special_items = self::get_matching_special_items( $this->day, $this->config->get( Config::SPECIAL_DATES ) );
		$previous_day_anchor = self::get_day_entry_anchor( $this->day->modify( 'yesterday' ) );
		$next_day_anchor = self::get_day_entry_anchor( $this->day->modify( 'tomorrow' ) );
		$random_quote = self::get_random_quote();
		$random_affirmation = self::get_random_affirmation();
		$random_bible_verse = self::get_random_bible_verse();
		$random_ak_information = self::get_random_ak_information();
?>
		<table width="95%" align="center">
		<tr>
				<td class="day-entry__month-name"><a href="#<?php echo $month_overview_anchor; ?>"><?php echo $month_name; ?></a></td>
				<td class="day-entry__previous-day"><a href="#<?php echo $previous_day_anchor; ?>">«</a></td>
				<td class="day-entry__day-number"><?php echo $day_number; ?></td>
				<td class="day-entry__next-day"><a href="#<?php echo $next_day_anchor; ?>">»</a></td>
				<td rowspan="2" class="calendar-box"><?php echo $calendar_html ?></td>
			</tr>
			<tr>
				<td colspan="4" style="border-bottom: 1px solid black; padding: 0; margin: 0;">
					<table width="100%">
						<tbody>
							<tr>
								<td class="day-entry__special-items">
<?php
									foreach ( $special_items as $index => $special_item ) {
										echo "<span class=\"day-entry__special-item\">» $special_item</span>";
										if ( $index < ( count( $special_items ) - 1 ) ) {
											echo 'akdebug my special item<br />';
										}
									}
?>
								</td>
								<td class="header-line day-entry__day-of-week"><?php echo strftime( '%A', $this->day->getTimestamp() ); ?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</table> 
			<table width="95%" align="center">
			<!-- ============================ open ATK table ============================ -->
			 <!-- bible verse first --> 
			<tr><td colspan="5"><i><?php echo $random_bible_verse?></i></b></td></tr>
				<tr><td colspan="5"><br><b>What I'm grateful for:</b></td></tr>
				<tr><td colspan="1"  width="25%" class="content-box-height">&nbsp;&nbsp;&nbsp; generally? </td><td colspan="4" width="75%" style="border-bottom:1px solid #AAA">&nbsp;
				</td></tr>
				<tr><td colspan="1" class="content-box-height">&nbsp;&nbsp;&nbsp; who? </td><td colspan="4" style="border-bottom:1px solid #AAA"></td></tr>
				<tr><td colspan="1" class="content-box-height">&nbsp;&nbsp;&nbsp; about myself?</td><td colspan="4" style="border-bottom:1px solid #AAA"></td></tr>
				<tr><td colspan="5" class="smallerTextLight">Negativity bias leads us to focus on negative experiences, which can skew our perception of reality & affect wellbeing. To counteract this, practice mindfulness, focus on positive experiences & consciously cultivate gratitude to shift attention. Regularly engaging in these steps can enhance positivity & improve overall mental health.</td></tr>
				<tr><td colspan="1" class="content-box-height">Current Emotions?</td><td colspan="4" style="border-bottom:1px solid #AAA"></td></tr>
				<tr><td colspan="2" class="content-box-height">What I'm doing for others this week?</td><td colspan="3" style="border-bottom:1px solid #AAA"></td></tr>
				<tr><td colspan="1" class="content-box-height">Future vision</td><td colspan="4" style="border-bottom:1px solid #AAA"></td></tr>
				<tr><td colspan="5" class="smallerTextLight">eg Nice house in lots of trees - Building my future, and my adhd non-verbal imagination one line at a time.</td></tr>
				<tr><td colspan="1" class="content-box-height">Recent Successes</td><td colspan="4" style="border-bottom:1px solid #AAA"></td></tr>
				<tr><td colspan="1" class="content-box-height">Next Sucess</td><td colspan="4" style="border-bottom:1px solid #AAA"></td></tr>
				<?php			
							echo str_repeat( '<tr><td colspan="5" class="content-box-line"></td></tr>', 1 );
							
				?>
				<tr><td colspan="5"><br></td></tr>
				<!-- <tr><td colspan="4"><br>View/Plan Work Tasks Document</td><td>&#9744;</td></tr>
				<tr><td colspan="4"><br>View/Pan Long Term Work Tasks Document</td><td>&#10063;</td></tr> -->
				<tr><td colspan="5"><br><table width="99%" border=1><tr><td align="center" style="font-style:italic;font-size:smaller">
					<br><?php echo $random_quote ?><br>&nbsp;<br></td></tr></table>
					<br><table width="99%" border=1><tr><td align="center" style="font-style:italic;font-size:smaller">
					<br><?php echo $random_affirmation ?><br>&nbsp;<br></td></tr></table>
				</td></tr>

								</table><!--  ============================ close ATK table ============================ -->

								<pagebreak />					<!--	//atk added 29/05/2024				-->


		
	

		 <table width="100%"><!-- start of table for day plan and july things and bucket list -->
		
			<Tr><Td width="70%" rowspan="4">
<?php
				/*ITINERARY ITEMS ARE STORED AS NUMBER OF ROWS REQUIRED, TITLE OF SECTION 
				AK WILL CHANGE THIS TO CHECK IF THE WORD EISENHOWER OCCURS IN THE TEXT*/
				$all_itinerary_items = $this->config->get( Config::DAY_ITINERARY_ITEMS );
				$itinerary_items = $all_itinerary_items[ (int) $this->day->format( 'N' ) ] ?? $all_itinerary_items[ Config::DAY_ITINERARY_COMMON ];
			    
				// add actual date to itinerary items second entry
				$itinerary_items[0][1] = $itinerary_items[0][1]." - " . $this->day->format( 'D, d M Y' ) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#year-overview'>Links</a>"; 
				//echo "Itinerary dayplan name= ". $itinerary_items[0][1];
											// ?? It returns its first operand if it exists and is not NULL; otherwise it returns its second operand.
				self::generate_content_box( $itinerary_items ); // prints all the rows - $itinerary_items an array of somethings



		   // echo $itinerary_items[0][1]." - " . $this->day->format( 'D, d M Y' );

		//	echo '<table class="ruledLines">';
		//	echo str_repeat( '<tr><td class="content-box-line" style="border-bottom:1px solid #ccc">&nbsp;</td></tr>', 22 );
		//	echo '    	</table></td>';
						
			

			echo '<table><tr><td align="center">' . $random_ak_information .'</td></tr></table>';
			echo '</td>';
			echo '<Td width="30%" valign=top>';
			/*			
			$month_notes_in_day = $this->config->get( Config::MONTHLY_NOTES );
			$month_notes_in_day[0] = $month_name. " " . $month_notes_in_day[0]; // add month name to first item in month list
			self::generate_content_box2($month_notes_in_day);
*/
			// AK NEW TEXT DEC 2024. TRYING TO MAKE MONTHLY NOTES SPECIFIC TO MONTH
			$month_notes_in_day_all = $this->config->get( Config::MONTHLY_NOTES_2 );
			$month_notes_in_day = $month_notes_in_day_all[ (int) $this->day->format( 'n' ) ] ?? $this->config->get( Config::MONTHLY_NOTES_COMMON ); // lowecase n for month number
			$month_notes_in_day[0] = $month_name. " " . $month_notes_in_day[0]; // add month name to first item in month list
			$month_notes_in_day_common = $this->config->get( Config::MONTHLY_NOTES_COMMON );
		
			$month_notes_combined = array_unique(array_merge($month_notes_in_day_common, $month_notes_in_day));
			// ak thinks this prints to html... how to print to terminal??

				if (count($month_notes_combined)>18) {
				AKDebug ( "WARNING: MONTLY NOTES Combined GREATER THAN 18 items (ie " .count($month_notes_combined). "items ) - MAY GO OVER PAGE");
			}
			self::generate_content_box2( $month_notes_combined ); 

		echo "</td></tr>";
		echo "<tr><td>";
		echo '<tr><td valign=middle>';

		$current_reading_all = $this->config->get( Config::CURRENT_READING );
		$current_reading = $current_reading_all[ (int) $this->day->format( 'n' ) ] ?? $this->config->get( Config::CURRENT_READING_COMMON ); 
		self::generate_content_box_justified($current_reading);



		echo "</td></tr>";
		echo '<tr><td valign=bottom>';
		$bucket_list = $this->config->get( Config::BUCKET_LIST );
			self::generate_content_box2($bucket_list);
		echo '</td></tr>';
		echo '</table><!-- end of table for day plan and july things and bucket list -->';

?>
<?php
	}
}
