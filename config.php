<?php

namespace ReCalendar;

// update start month if not doing 12 months from jan. 
// self::MONTH => 8, //start month eg Aug

class Config {
	public const DAY_NAMES_SHORT = 'day_names_short';
	public const DAY_ITINERARY_ITEMS = 'day_itinerary_items';
	public const MONTHLY_NOTES = "monthly_notes";
	public const BUCKET_LIST = "bucket_list";
	public const CURRENT_READING = "current_reading";
	public const DAY_ITINERARY_COMMON = 'day_itinerary_common';
	public const DAY_ITINERARY_WEEK_RETRO = 'day_itinerary_week_retro';
	public const DAY_ITINERARY_MONTH_OVERVIEW = 'day_itinerary_month_overview';
	public const FONT_DATA = 'font_array';
	public const FONT_DEFAULT = 'default_font';
	public const FONT_DIR = 'font_directory';
	public const FORMAT = 'format';
	public const HABITS = 'habits';
	public const HABITS_TITLE = 'habits_title';
	public const LOCALE = 'locale';
	public const MONTH = 'month';
	public const MONTH_COUNT = 'month_count';
	public const MONTHS = 'months';
	public const WEEK_NAME = 'week_name';
	public const WEEK_NUMBER = 'week_number';
	public const WEEKLY_RETROSPECTIVE_BOOKMARK = 'weekly_retrospective_bookmark';
	public const WEEKLY_RETROSPECTIVE_TITLE = 'weekly_retrospective_title';
	public const WEEKLY_TODOS = 'weekly_todos';
	public const SPECIAL_DATES = 'special_dates';
	public const STYLE_SHEET = 'style_sheet_filename';
	public const SUBTITLE = 'subtitle';
	public const YEAR = 'year';

	public function get( string $key ) {
		return $this->get_configuration()[ $key ] ?? null;
	}

	protected function get_configuration() : array {
		$configuration = [
			// Used in the small calendar in the upper right corner of most pages
			// Please try to use a 2 character abbreviations to save space on the page
			self::DAY_NAMES_SHORT => [
				'Mo',
				'Tu',
				'We',
				'Th',
				'Fr',
				'Sa',
				'Su',
			],
			self::MONTHLY_NOTES => [
				'Monthly Notes',
				'Big Shoulders',
				'Pistol Squat',
				'Measure Weight',
				'Buy wardrobe',	
			        'Gottman Quiz - Do', 
			        'PBSP - 20%',
			],
			self::BUCKET_LIST => [
				'Bucket List',
				'Dance class',
				'Sing in choir',
				'Another cooking class',
				'Try Amsterdam',
				'Try England',				
				'Love?',				
			],
			self::CURRENT_READING => [
				'Current Reading',
				'Models - Attract Woment Through Honesty, 100%',
				'Why zebras dont get ulcerss, 10%',
				'The explosive child, 20%',	
				'Dare to Connect, 20%',
				'The Mindful Emotions Workbook, 20%',
				"The Inflamed Mind, 1%",
				"The Well of Ascension, 100%",		
			],
			// Items for each page type
			// The format is: [ NUMBER OF LINES, NAME (optional) ]
			// You might need to adjust the number of lines depending on your config (locale, font size, etc.)
			self::DAY_ITINERARY_ITEMS => [
				// Common itinerary used if nothing more specific was defined
				self::DAY_ITINERARY_COMMON => [
					[ 27, 'Day Plan', ], //ak changed from 23 on 29/05/2024 8:30pm // number of rows to print - changed to 28
				],
				// Itinerary for the weekly retrospective
				self::DAY_ITINERARY_WEEK_RETRO => [
					[ 6, 'Week Review Notes' ],
				],
				// Itinerary for the month's overview
				self::DAY_ITINERARY_MONTH_OVERVIEW => [
					[ 20, 'Coming Month Goals' ],
				],
			],
			// A list of habits that triggers generating a table on the month's overview
			// to help tracking those habits
			self::HABITS => [ 'Pistol Squat in May, June, July, Aug',
			 'Celebrate others'
			],
			// Title for the habits table on month overview
			self::HABITS_TITLE => 'Habits',
			// Font information array.
			self::FONT_DATA => [
				'lato' => [
					'R' => 'Lato/Lato-Regular.ttf',
					'I' => 'Lato/Lato-Italic.ttf',
					'B' => 'Lato/Lato-Bold.ttf',
					'BI' => 'Lato/Lato-BoldItalic.ttf',
				],
			],
			// The font to use. Match the name used in FONT_DATA.
			self::FONT_DEFAULT => 'lato',
			// Directory the font is located in.
			self::FONT_DIR => '/fonts/',
			// This is the exact size (in mm) of the ReMarkable 2 screen
			// You might want to adjust it to your device's size
			// See https://mpdf.github.io/reference/mpdf-functions/construct.html for possible values
			self::FORMAT => [ 157, 209 ],
			// Locale to generate the calendar in
			// To check which locale your PHP version supports run:
			// `locale -a` in your terminal (at least on Linux and MacOS)
			// Note that you will still need to override some configuration variables, like `WEEK_NAME`, etc.
			self::LOCALE => 'en_US.UTF-8',
			// The month from which to start the "year"
			// Useful if you want to track your college year, for example.
			// You could then set this to 10 (October) and the calendar
			// would then be generated for 12 months starting from October.
			self::MONTH => 8, //start month
			// The number of months you want this calendar to be for.
			// Useful if you want a calendar for the quarter (3) or a 15 month calendar.
			self::MONTH_COUNT => 5,
			// Title of the Week overview page
			self::WEEK_NAME => 'Week',
			// A short version of "Week Number" used in the header of the small calendar in upper right corner of the page
			self::WEEK_NUMBER => 'W#',
			// Used for the bookmark of the weekly retrospective pages
			self::WEEKLY_RETROSPECTIVE_BOOKMARK => 'Week Review',
			// Used for the title of the weekly retrospective pages
			self::WEEKLY_RETROSPECTIVE_TITLE => 'Weekly Review',
			// A list of items you'd like to be listed in the notes of the weekly overview
			self::WEEKLY_TODOS => [
			],
			// A list of special dates (anniversaries, birthdays, holidays) that will be highlighted throughout the calendar:
			// in the small calendar, on weekly overviews and daily entries.
			self::SPECIAL_DATES => [			
				 //'01-01' => 'New Year!',
				 //'01-04' => 'April Fools Day',
				 //'06-06' => 'AKs Bday!',
			],
			// Stylesheet filename
			self::STYLE_SHEET => 'style.css',
			// Used on the title page of the calendar
			self::SUBTITLE => 'ReCalendar',
			// The year for which to generate this calendar.
			// Defaults to the current year.
			self::YEAR => (int) date( 'Y' ),
		];

		// Get the names of the months in the set locale.
		// This might useful for non-English locales (like Polish), that apparently
		// have their names decilned in the locale provided by the system, while
		// you'd probably want a non-declined version.
		// Example: 'stycznia' instead of 'Styczeń' for January in Polish.
		$configuration[ self::MONTHS ] = $this->generate_month_names( $configuration[ self::LOCALE ] );

		return $configuration;
	}

	private function generate_month_names( string $locale ) : array {
		$old_locale = setlocale( LC_TIME, 0 );
		setlocale( LC_TIME, $locale );

		$start = new \DateTimeImmutable( 'first day of january' );
		$interval = new \DateInterval( 'P1M' );
		$end = new \DateTimeImmutable( 'last day of december' );
		$period = new \DatePeriod( $start, $interval, $end );
		$month_names = [];
		foreach ( $period as $index => $month ) {
			$month_names[ $index + 1 ] = strftime( '%B', $month->getTimestamp() );
		}

		setlocale( LC_TIME, $old_locale );
		return $month_names;
	}
}
