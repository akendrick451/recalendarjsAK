<?php
declare(strict_types=1);

// ATK May 2024 - change date output
// 1. Change date - done
// 2. Can I set my own sections on the day print?
// 3. How do I run this?


namespace ReCalendar;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/generators/calendar-generator.php';
require_once __DIR__ . '/generators/day-entry-generator.php';
require_once __DIR__ . '/generators/month-overview-generator.php';
require_once __DIR__ . '/generators/title-page-generator.php';
//require_once __DIR__ . '/generators/year-overview-generator.php';
require_once __DIR__ . '/generators/year-overview-generator2.php';
require_once __DIR__ . '/generators/week-overview-generator.php';
require_once __DIR__ . '/generators/week-retrospective-generator.php';
require_once __DIR__ . '/generators/year-retrospective-generator.php';
require_once __DIR__ . '/akfunctions.php';

class ReCalendar {
	private $mpdf = null;
	private $config = null;
	private $html = '';
	private $all_html_ak = '';
	private $blDebugPrintedHTMLOnce = false;

	private $month_overview_links = [];

	public function __construct( \Mpdf\Mpdf $mpdf, Config $config ) {
		$this->mpdf = $mpdf;
		$this->config = $config;
	}

	public function generate() {
		$stylesheet_filename = $this->config->get( Config::STYLE_SHEET );
		if ( ! file_exists( $stylesheet_filename ) ) {
			exit( 'The provided stylesheet does not exist: ' . $stylesheet_filename . PHP_EOL );
		}
		$stylesheet = file_get_contents( $stylesheet_filename );

		$this->all_html_ak = "<!DOCTYPE html><html lang='en-US'><head><style>" . $stylesheet . "</style></head><body> ";
		$this->mpdf->WriteHTML( $stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS );
		$this->generate_title_page();

		$month = sprintf( '%02d', (int) $this->config->get( Config::MONTH ) );
		$year = (int) $this->config->get( Config::YEAR );
		$start = new \DateTimeImmutable( "$year-$month-01" );
		$month_count = (int) $this->config->get( Config::MONTH_COUNT );
		$end = $start->modify( "$month_count months" );

		$jan_date = new \DateTimeImmutable( "$year-01-01" );
		$dec_date = new \DateTimeImmutable( "$year-12-31" );
		$year_overview_generator = new YearOverviewGenerator( $jan_date, $dec_date, $this->config );
		//$year_overview_generator2 = new YearOverviewGenerator2( $start, $end, $this->config );
		//$this->add_page();
		//$this->append_html( $year_overview_generator->generate() );
		$this->add_page();
		$this->append_html( $year_overview_generator->generate() );
		
		$start = $start->modify( 'monday this week' );
		$interval = new \DateInterval( 'P1W' );
		$period = new \DatePeriod( $start, $interval, $end );

		foreach( $period as $week ) {
			$this->generate_week( $week, $end );

			$this->write_html();
		}
		$this->generate_year_retrospective( $week );
		$this->write_html();


		$page_count = $this->mpdf->page;
		echo "page count2 is " . $page_count;
		//ak change filename to include date and time
		$dateNow   = new \DateTime(); //this returns the current date time
        $dateNowString = $dateNow->format('Y-m-d-H-i-s');
		$reCalendarOutputFilename = 'ReCalendar' . $dateNowString . '.pdf';

		$expected_page_count = 545 ; // page count for 2025 for 6 months
		if (($page_count > 400 & $page_count < 600) & $page_count <> $expected_page_count) {
			
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			echo "                        2025 - expected page count of " . $expected_page_count. " but got " . $page_count;
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			echo "PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT,PAGE COUNT ALERT, PAGE COUNT ALERT\n";
			error_beep();
		}
			// ==============================================================================================================================
		// ==============================================================================================================================
		echo '.... AK trying to save html for debugging......';
		file_put_contents("output//recalendarForPDF" . $dateNow->format('Y-m-d-H-i-s') . ".html",  $this->$all_html_ak);
		
		$this->mpdf->Output( __DIR__ . '//output//' . $reCalendarOutputFilename , \Mpdf\Output\Destination::FILE );
		$page_count = $this -> page;	
		echo "page count3 is " . $page_count;
		// ==============================================================================================================================
		// ==============================================================================================================================
		echo '.... AK trying to save html for debugging......';
		
		//file_put_contents("output//recalendarForPDF2" . $dateNow->format('Y-m-d-H-i-s') . ".html",  $this->$html);
	
		$reCalendarOutputFilename = escapeshellarg("\\output\\".$reCalendarOutputFilename);
		echo "\n";
		$strCurrentPath = __DIR__;
		echo $strCurrentPath;
		
	   echo "\nOpen the pdf - ". __DIR__ . $reCalendarOutputFilename;
		// Use 'start' command to open with default PDF viewer (Edge, Acrobat, etc.)
		$command = 'start "" ' . __DIR__ . $reCalendarOutputFilename;


		exec($command);

	}


	private function generate_title_page() : void {
		$title_page_generator = new TitlePageGenerator( $this->config );
		$this->append_html( $title_page_generator->generate() );
	}

	private function generate_week( \DateTimeImmutable $week, \DateTimeImmutable $year_end ) : void {
		$this->generate_week_overview( $week );

		$this->generate_days_per_week( $week, $year_end );

		$this->generate_week_retrospective( $week );
	}

	private function generate_month_overview( \DateTimeImmutable $month ) : void {
		$localized_month_name = $this->config->get( Config::MONTHS )[ (int) $month->format( 'n' ) ];

		$this->add_page();
		$this->bookmark( $localized_month_name, 1 );

		$calendar_generator = new CalendarGenerator( $month, CalendarGenerator::HIGHLIGHT_NONE, $this->config );
		$month_overview_generator = new MonthOverviewGenerator( $month, $calendar_generator, $this->config );

		$this->append_html( $month_overview_generator->generate() );
	}

	private function generate_week_overview( \DateTimeImmutable $week ) : void {
		$this->add_page();
		$week_number = $this->get_week_number( $week );
		$this->bookmark( $this->config->get( Config::WEEK_NAME ) . ' ' . $week_number, 0 );

		$calendar_generator = new CalendarGenerator( $week, CalendarGenerator::HIGHLIGHT_WEEK, $this->config );
		$week_overview_generator = new WeekOverviewGenerator( $week, $calendar_generator, $this->config );
		$this->append_html( $week_overview_generator->generate() );
	}

	private function generate_days_per_week( \DateTimeImmutable $week, \DateTimeImmutable $year_end ) : void {
		$next_week = $week->modify( 'next week' );
		$week_period = new \DatePeriod( $week, new \DateInterval( 'P1D' ), $next_week );
		foreach( $week_period as $week_day ) {
			if ( (int) $week_day->format( 'j' ) === 1 && $week_day < $year_end ) {
				$this->generate_month_overview( $week_day );
			}

			$this->generate_day_entry( $week_day );
		}
	}

	private function generate_day_entry( \DateTimeImmutable $day ) : void {
		$this->add_page();

		$calendar_generator = new CalendarGenerator( $day, CalendarGenerator::HIGHLIGHT_DAY, $this->config );
		$day_entry_generator = new DayEntryGenerator( $day, $calendar_generator, $this->config );
		$this->append_html( $day_entry_generator->generate() );
	}

	private function generate_week_retrospective( \DateTimeImmutable $week ) : void {
		$this->add_page();
		$this->bookmark( $this->config->get( Config::WEEKLY_RETROSPECTIVE_BOOKMARK ), 1 );

		$calendar_generator = new CalendarGenerator( $week, CalendarGenerator::HIGHLIGHT_WEEK, $this->config );
		$week_retrospective_generator = new WeekRetrospectiveGenerator( $week, $calendar_generator, $this->config );
		$this->append_html( $week_retrospective_generator->generate() );
	}

	private function generate_year_retrospective( \DateTimeImmutable $week ) : void {
		$this->add_page();
		$this->bookmark( $this->config->get( Config::YEARLY_RETROSPECTIVE_BOOKMARK ), 1 );

		$calendar_generator = new CalendarGenerator( $week, CalendarGenerator::HIGHLIGHT_WEEK, $this->config );
		$year_retrospective_generator = new YearRetrospectiveGenerator( $week, $calendar_generator, $this->config );
		$this->append_html( $year_retrospective_generator->generate() );
	}

	private static function get_week_number( \DateTimeImmutable $week ) : int {
		return (int) $week->modify( 'thursday this week' )->format( 'W' );
	}

	private function add_page() : void {
		$this->html .= '<pagebreak />';
	}

	private function append_html( string $new_html ) : void {
		$this->html .= $new_html;
	}

	private function bookmark( string $bookmark, int $level ) : void {
		$this->html .= "<bookmark content=\"$bookmark\" level=\"$level\" />";
	}

	private function write_html() : void {
		if ( empty( $this->html ) ) {
			return;
		}
		$dateNow   = new \DateTime(); //this returns the current date time
		
		if ( $this->blDebugPrintedHTMLOnce == false ) {
			$this->all_html_ak  = $this->all_html_ak . " " . $this->html;
			echo " debugPrint printhtmlonce.... $this->blDebugPrintedHTMLOnce is [" . $this->blDebugPrintedHTMLOnce . "]";
			
		}
		$this->mpdf->WriteHTML( $this->html );
		
		//echo $this->html;
		// only do this for a small size		
		if ((strlen($this->all_html_ak) > 4137) && $this->blDebugPrintedHTMLOnce == false) {
			// print it once and no more. 
			$this->blDebugPrintedHTMLOnce = true;
			echo " debugPrint2 HTML Is.... $this->blDebugPrintedHTMLOnce is [" . $this->blDebugPrintedHTMLOnce . "] SHOULD BE TRUE NOW";
			file_put_contents("output//recalendarForPDF" . $dateNow->format('Y-m-d-H-i-s') . ".html", $this->all_html_ak);

		}

		$this->html = '';
	}
}

