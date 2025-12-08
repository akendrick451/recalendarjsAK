<?php

namespace ReCalendar;

// update start month if not doing 12 months from jan. 
// self::MONTH => 8, //start month eg Aug
// also can update self::YEAR

class Config {
	public const DAY_NAMES_SHORT = 'day_names_short';
	public const AFFIRMATIONS = "affirmations";
	public const AK_INFORMATION = "ak_information";
	public const BIBLE_VERSES = "bible_verses";
	public const DAY_ITINERARY_ITEMS = 'day_itinerary_items';
	//public const MONTHLY_NOTES = "monthly_notes";
	public const MONTHLY_NOTES_2 = "monthly_notes_2";
	public const MONTHLY_NOTES_COMMON = "monthly_notes_common";
	public const CURRENT_READING_COMMON = "current_reading_common";
	public const BUCKET_LIST = "bucket_list";
	public const CURRENT_READING = "current_reading";
	public const DAY_ITINERARY_COMMON = 'day_itinerary_common';
	public const DAY_ITINERARY_WEEK_RETRO = 'day_itinerary_week_retro';
	public const DAY_ITINERARY_MONTH_OVERVIEW = 'day_itinerary_month_overview';
	public const MONTH_REVIEW = "month_review";
	public const FONT_DATA = 'font_array';
	public const FONT_DEFAULT = 'default_font';
	public const FONT_DIR = 'font_directory';
	public const FORMAT = 'format';
	public const HABITS = 'habits';
	public const HABITS_COMMON = 'habits_common'; 
	public const HABITS_TITLE = 'habits_title';
	public const LOCALE = 'locale';
	public const MONTH = 'month';
	public const MONTH_COUNT = 'month_count';
	public const MONTHS = 'months';
	public const WEEK_NAME = 'week_name';
	public const WEEK_NUMBER = 'week_number';
	public const WEEKLY_RETROSPECTIVE_BOOKMARK = 'weekly_retrospective_bookmark';
	public const WEEKLY_RETROSPECTIVE_TITLE = 'weekly_retrospective_title';
		public const YEARLY_RETROSPECTIVE_TITLE = 'yearly_retrospective_title';
		public const YEARLY_RETROSPECTIVE_BOOKMARK = 'yearly_retrospective_bookmark';

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
			// The month from which to start the "year"
			// Useful if you want to track your college year, for example.
			// You could then set this to 10 (October) and the calendar
			// would then be generated for 12 months starting from October.
			self::MONTH => 7, //start month
			// The number of months you want this calendar to be for.
			// Useful if you want a calendar for the quarter (3) or a 15 month calendar.
			self::MONTH_COUNT => 6,
			// The year for which to generate this calendar.
			// Defaults to the current year.
			self::YEAR => 2025,
			//self::YEAR => (int) date( 'Y' ),
			self::AFFIRMATIONS => [
				"I can do all things through Him who gives me strength",
				"I am capable of succeeding",
				"I am proud of my efforts",
				"I am capable of achieving my goals with effort and perseverance",
				"I am deserving of happiness",
				"Losing a chess game is a growth opportunity and evidence that I've tried",
				"I can be happy in losing a chess game that I'm learning",
				"Negative feedback is a growth opportunity and an opportunity to see what is important to others and an opportunity for conversation and to show that I care what others think and want",
				"I'm allowed to have fun",
				"I'm allowed to relax",
				"I'm allowed to be moody",
				"I'm allowed to be loud",
				"I can do 20 minutes of breathing exercises a day, it is helpful to me to do 20 min breathing a day",
				"I can stretch each day",
				"Stretching is helpful for me",
				"People like me for who I am",
				"I matter",
				"I deserve good things",
				"I am allowed to rest",
				"I do rest",
				"Resting is a great and necessary activity",
				"I can ask for help when needed",
				"It's good to ask for help when needed.",
				"I can be a good friend",
				"I can have fun with other people",
				"I can be relaxed in the presence of others",
				"My ideas are important and worthy of attention and respect",
				"I can speak my ideas loud enough with emphasis and force",
				"I can and do represent others at times, when I feel the need",
				"I choose where to spend my energy",
				"I can relax and let go and cry if necessary at times",
				"I am safe",
				"I am fierce",
				"I am a force",
				"I am lovable",
				"I am worthy of love and respect",
				"Some women are very attracted to me",
				"A woman I'm attracted to might also be attracted to me",
				"Women want to find happiness and love and appreciate being treated with respect and ",
				"Women sometimes want for me to go up to them and say hello, especially if they are at a singles event",
				"I can get my work done today",
				"My resources are enough to handle today's tasks",
				"If necessary I will rest when needed",
				"I am a person", 
				"I can love", 
				"I can be an older brother", 
				"I am an older brother", 
				"I can love my brother", 
				"I can feel love for my brother", 
				"I can have close relationships / I do have close relationships", 
				"I can have feelings / I do have feelings", 
				"I can heal so much / I am healing so much", 
				"I can be the adult / I am an adult", 
				"I can have adult relationships / I do have adult relationships (adult to adult, not inner child to adult)", 
				"I have permission to be me", 
				"I can be proud of something I have done / I am proud of things that I have done", 
				"It's OK for me to be proud of something that I've done", 
				"I can stand up for myself / I do stand up for myself", 
				"I stand up for others", 
				"I speak up", 
				"I can dream / I dream", 
				"I can plan / I do plan eg life plans, 10 years from now plans", 
			],
			// information that is useful for me that I put as reminders in my calendar
			// I think I'll add it as random notes to my calendar near the quotes etc
			// maybe on the second page ... the eisenhower page
			// if cindluding information, please add source. 
			self::AK_INFORMATION => [
				'Omega 3 fatty acids 1mg of EPA a day is great for depression, ADHD - doi:10.1016/j.bbi.2024.02.029, additudemag.',
				'Creatine is pretty great for cognitive and mood - https://www.uclahealth.org/', 
				'Your brain generally tries to find answers, so trick it nicely eg, what wins have you had lately ',
				'Be careful with speech, it confirms and leads you, eg better is I am healing, not the opposite.', 

			], 
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
			//ak changed on 07/12/2024 11:30am 
			// see also monthly notes common. 13 rows - total of this and that list
			self::MONTHLY_NOTES_2 => [ // bit like a todo list
				 12 => [ 'Reverse sensor', 'Book Holidays x2!','Book Music and Theatre', 'Masters 100%', 'Sell personal diary service $10', 'Queens Pawn 20%', 'Save Money', 'Cholesterol'] , 
				 11 => [   'Reverse sensor', 'Book Holidays x2!','Book Music and Theatre',  'Masters 100%', 'Queens Pawn 20%', 'Watch weight', 'Cholesterol' 	] ,
				 1 => ['Holiday', 'Go away!', 'Rest for year', 'Buy wardrobe'] , 
				 2 => [  'Hard work on cardinal v', 'Compassion re teaching', '2x clients', 'Get chest of drawers'	], 
				 3 => [ 'Be More social', '2x Climbing', 'Book Jan Holiday'] , 
				 4 => [ 'Chess Beginnings 80%', 'Queens Pawn 1%', 'Pacing ME 30%', 'Masters Degree 80%', 'Couns Business 10%', 'Get Healthy 15%' , 'House Deposit 15%' ], 
				 5 =>[ 'Chess Beginnings 80%', 'Queens Pawn 1%', 'Pacing ME 35%', 'Masters Degree 80%', 'Couns Business 10%', 'Get Healthy 15%' , 'House Deposit 15%' ], 
				 6 =>[ 'Chess Beginnings 80%', 'Queens Pawn 1%', 'Pacing ME 40%', 'Masters Degree 80%', 'Couns Business 10%', 'Get Healthy 15%' , 'House Deposit 15%' ], 
				 7 =>[ 'Sleep couns', 'Queens Pawn 1%', 'Pacing ME 50%', 'Masters Degree 90%', 'Couns Business 20%', 'Get Healthy 25%' , 'House Deposit 16%' ], 
				 8 =>[ 'Chess Beginnings 80%', 'Queens Pawn 1%', 'Pacing ME 50%', 'Masters Degree 90%', 'Couns Business 20%', 'Get Healthy 25%'  ], 
				 9 =>[  'Queens Pawn 10%', 'Pacing ME 50%', 'Masters Degree 95%', 'Couns Business 20%', 'Watch weight' , 'Big shoulders' ], 
				 10 =>[  'Reverse sensor', 'Queens Pawn 20%', 'Late December Holiday', 'Book Music and Theatre', 'Cholesterol', 'Breathless Eml Course' ], //shoulders, business, pauses due to health / stress issues


				 
			],
			self::MONTHLY_NOTES_COMMON => [ //is this included in all notes, or only if specified month is blank- included in ALL MONTHS
				'Monthly Notes','<b>Longer</b>', 'Get Healthy 45%', 'Affirmation thpy Fr', 'Masters Degree 96%', 
				'<b>Exciting</b>', '..Build info screen wall'
			],
			/*self::MONTHLY_NOTES => [
				'Monthly Notes',
				'Big Shoulders',
				'Pistol Squat',
				'Measure Weight',
				'Buy wardrobe',	
			        'Gottman Quiz - Do', 
			        'PBSP - 20%',
			
				'Raise Bed',
				'Build Inner Wall',				
			],*/
			self::BUCKET_LIST => [
				'Bucket List',				
				'Dance Class,Sing in choir',
				'Another cooking class',
				'Try Amsterdam, England',					
				'Love?',				
			],

			self::CURRENT_READING_COMMON => [
				'Current Reading','The Edge thriller - 30%', 
				'Watership Down',				
			],

			self::CURRENT_READING => [
				7 => ['Current Reading', 'The Edge Thriller - 30%', 'Don\'t let them - 30%', ],
				9 => ['Current Reading',  'Why zebras dont get ulcerss, 10%', 
				'The explosive child, 20%',	'Dare to Connect, 20%', 'The Mindful Emotions Workbook, 20%', 	
				"The Inflamed Mind, 1%", "The Well of Ascension, 10%",	],
				10 => ['Current Reading',  'Why zebras dont get ulcerss, 10%', 
				'The explosive child, 20%',	'Dare to Connect, 20%', 'The Mindful Emotions Workbook, 20%', 	
				"The Inflamed Mind, 1%", "The Healing Power of Vagus, 0%",	],
				11 => ['Current Reading',  'Why zebras dont get ulcerss, 10%', 
				'The explosive child, 20%',	'Dare to Connect, 20%', 'The Mindful Emotions Workbook, 20%', 	
				"The Inflamed Mind, 1%", "The Well of Ascension, 100%",	],
				12 => ['Current Reading', 'No Bad Parts, Schwarz', 'Why zebras dont get ulcerss, 10%', 
				'The explosive child, 20%',	'Dare to Connect, 20%', 'The Mindful Emotions Workbook, 20%', 	
				"The Inflamed Mind, 1%", "Alloy of Law, 10%",	],
				1 => ['Current Reading', 'No Bad Parts, Schwarz', 'Why zebras dont get ulcerss, 10%', 
				'The explosive child, 20%',	'Dare to Connect, 20%', 'The Mindful Emotions Workbook, 20%', 	
				"The Inflamed Mind, 1%", "Alloy of Law, 10%",	],
			],
			// Items for each page type
			// The format is: [ NUMBER OF LINES, NAME (optional) ], maybe num of lines could be day number????
			// You might need to adjust the number of lines depending on your config (locale, font size, etc.)
			self::DAY_ITINERARY_ITEMS => [
				// Common itinerary used if nothing more specific was defined
				self::DAY_ITINERARY_COMMON => [
					//ak may change this from [30, 'eisenhowerDay Plan', ], to something for eisenhower
					// eg if title = Eisenhower - then print it out, breaking up the number of lines....
					[ 32, 'eisenhowerDay Plan', ], //ak changed from 23 on 29/05/2024 8:30pm // number of rows to print - changed to 28
				],
				// Itinerary for the weekly retrospective
				self::DAY_ITINERARY_WEEK_RETRO => [
					[ 20, 'Week Review Notes' ],
					[1, "<a href='#year-overview'>Update Week Goals/Review Link</a>"],
				],
				// Itinerary for the month's overview
				self::MONTH_REVIEW => [
					[ 20, 'Month Review' ],
				],
				// Itinerary for the month's overview
				self::DAY_ITINERARY_MONTH_OVERVIEW => [
					[ 20, 'Coming Month Goals' ],
				],
			],
			// A list of habits that triggers generating a table on the month's overview
			// to help tracking those habits

			self::HABITS_COMMON => [
				 'Shoulders workout', 'Self-compassion',
				'Celebrate others',
			],
			self::HABITS => [
				10 => [ 'Pistol Squat in May, June, July, Aug',
			            'Celebrate others'],
			    11 => [ 'Pistol Squat in May, June, July, Aug',
			            'Celebrate others'],
				12 => [ 'Shoulders workout Oct, Nov, Dec, Jan', 'Self-compassion',
			            'Give time to others'],
				1 => [ 'Shoulders workout Oct, Nov, Dec, Jan', 'Self-compassion',
			            'Celebrate others'],
				2 => [ 'Shoulders workout Oct, Nov, Dec, Jan', 'Self-compassion',
			            'Celebrate others'],
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
			
			// Title of the Week overview page
			self::WEEK_NAME => 'Week',
			// A short version of "Week Number" used in the header of the small calendar in upper right corner of the page
			self::WEEK_NUMBER => 'W#',
			// Used for the bookmark of the weekly retrospective pages
			self::WEEKLY_RETROSPECTIVE_BOOKMARK => 'Week Review',
			// Used for the title of the weekly retrospective pages
			self::YEARLY_RETROSPECTIVE_BOOKMARK => 'Year Review',
			self::WEEKLY_RETROSPECTIVE_TITLE => 'Weekly Review',
					self::YEARLY_RETROSPECTIVE_TITLE => 'Yearly Review',
			// A list of items you'd like to be listed in the notes of the weekly overview
			self::WEEKLY_TODOS => [
			],
			// A list of special dates (anniversaries, birthdays, holidays) that will be highlighted throughout the calendar:
			// in the small calendar, on weekly overviews and daily entries.
			self::SPECIAL_DATES => [			
				 '01-01' => ['New Year!'],
				 '01-04' => ['April Fools Day'],
				 '06-06' => ['AKs Bday!'],
			],
			// Stylesheet filename
			self::STYLE_SHEET => 'style.css',
			// Used on the title page of the calendar
			self::SUBTITLE => 'ReCalendar',
			self::BIBLE_VERSES => [
				"For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life. - John 3:16 ",
				"'For I know the plans I have for you,' declares the LORD, 'plans to prosper you and not to harm you, plans to give you hope and a future.', - Jeremiah 29:11 ",
				"I can do all this through him who gives me strength. - Philippians 4:13 ",
				"And we know that in all things God works for the good of those who love him, who have been called according to his purpose. - Romans 8:28 ",
				"Even though I walk through the darkest valley, I will fear no evil, for you are with me; your rod and your staff, they comfort me. - Psalm 23:4 ",
				"Trust in the LORD with all your heart and lean not on your own understanding;, - Proverbs 3:5 ",
				"Do not conform to the pattern of this world, but be transformed by the renewing of your mind. Then you will be able to test and approve what God’s will is—his good, pleasing and perfect will. - Romans 12:2 ",
				"So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand. - Isaiah 41:10 ",
				"Have I not commanded you? Be strong and courageous. Do not be afraid; do not be discouraged, for the LORD your God will be with you wherever you go. - Joshua 1:9 ",
				"But God demonstrates his own love for us in this: While we were still sinners, Christ died for us. - Romans 5:8 ",
				"But those who hope in the LORD will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint. - Isaiah 40:31 ",
				"Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age. - Matthew 28:19-20 ",
				"God is our refuge and strength, an ever-present help in trouble. - Psalm 46:1 ",
				"But seek first his kingdom and his righteousness, and all these things will be given to you as well. - Matthew 6:33 ",
				"Jesus answered, 'I am the way and the truth and the life. No one comes to the Father except through me.', - John 14:6 ",
				"If you declare with your mouth, 'Jesus is Lord,' and believe in your heart that God raised him from the dead, you will be saved. - Romans 10:9 ",
				"Love is patient, love is kind. It does not envy, it does not boast, it is not proud. It does not dishonor others, it is not self-seeking, it is not easily angered, it keeps no record of wrongs. Love does not delight in evil but rejoices with the truth. It always protects, always trusts, always hopes, always perseveres. - 1 Corinthians 13:4-7 ",
				"But the fruit of the Spirit is love, joy, peace, forbearance, kindness, goodness, faithfulness, gentleness and self-control. Against such things there is no law. - Galatians 5:22-23 ",
				"For we live by faith, not by sight. - 2 Corinthians 5:7 ",
				"Finally, be strong in the Lord and in his mighty power. Put on the full armor of God, so that you can take your stand against the devil’s schemes. - Ephesians 6:10-11 ",
				"The LORD is my shepherd, I lack nothing. - Psalm 23:1 ",
				"Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus. - Philippians 4:6-7 ",
				"Your word is a lamp for my feet, a light on my path. - Psalm 119:105 ",
				"Cast all your anxiety on him because he cares for you. - 1 Peter 5:7 ",
				"Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls. For my yoke is easy and my burden is light. - Matthew 11:28-30 ",
				"I have told you these things, so that in me you may have peace. In this world you will have trouble. But take heart! I have overcome the world. - John 16:33 ",
				"If any of you lacks wisdom, let him ask of God, who gives to all liberally and without reproach, and it will be given to him. - James 1:5 ",
				"Ask and it will be given to you; seek and you will find; knock and the door will be opened to you. - Matthew 7:7 ",
				"For the wages of sin is death, but the gift of God is eternal life in Christ Jesus our Lord. - Romans 6:23 ",
				"'Love the Lord your God with all your heart and with all your soul and with all your mind.' This is the first and greatest commandment. And the second is like it: 'Love your neighbor as yourself.', - Matthew 22:37-39 ",
				"Give, and it will be given to you. A good measure, pressed down, shaken together and running over, will be poured into your lap. For with the measure you use, it will be measured to you. - Luke 6:38 ",
				"Whatever you do, work at it with all your heart, as working for the Lord, not for human masters. - Colossians 3:23 ",
				"Above all else, guard your heart, for everything you do flows from it. - Proverbs 4:23 ",
				"Here I am! I stand at the door and knock. If anyone hears my voice and opens the door, I will come in and eat with that person, and they with me. - Revelation 3:20 ",
				"In all your ways submit to him, and he will make your paths straight. - Proverbs 3:6 ",
				"Be joyful in hope, patient in affliction, faithful in prayer. - Romans 12:12 ",
				"We love because he first loved us. - 1 John 4:19 ",
				"For no word from God will ever fail. - Luke 1:37 ",
				"You are the light of the world. A town built on a hill cannot be hidden. Neither do people light a lamp and put it under a bowl. Instead, they put it on its stand, and it gives light to everyone in the house. In the same way, let your light shine before others, that they may see your good deeds and glorify your Father in heaven. - Matthew 5:14-16 ",
				"Don’t let anyone look down on you because you are young, but set an example for the believers in speech, in conduct, in love, in faith and in purity. - 1 Timothy 4:12 ",
				"Dear friends, let us love one another, for love comes from God. Everyone who loves has been born of God and knows God. Whoever does not love does not know God, because God is love. - 1 John 4:7-8 ",
				"Philippians 4:8 - Finally, brothers and sisters, whatever is true, whatever is noble, whatever is right, whatever is pure, whatever is lovely, whatever is admirable—if anything is excellent or praiseworthy—think about such things.",
				"Matthew 5:9 - Blessed are the peacemakers, for they will be called children of God.",
				"Psalm 34:18 - The LORD is close to the brokenhearted and saves those who are crushed in spirit.",
				"Romans 8:37 - No, in all these things we are more than conquerors through him who loved us.",
				"For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life. - John 3:16",
				"But God demonstrates his own love for us in this: While we were still sinners, Christ died for us. - Romans 5:8",
				"We love because he first loved us. - 1 John 4:19",
				"Because of the Lord's great love we are not consumed, for his compassions never fail. They are new every morning; great is your faithfulness. - Lamentations 3:22-23",
				"Give thanks to the Lord, for he is good. His love endures forever. - Psalm 136:1",
				"Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight. - Proverbs 3:5-6",
				"For I know the plans I have for you' declares the Lord, 'plans to prosper you and not to harm you, plans to give you hope and a future. - Jeremiah 29:11",
				"but those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint. - Isaiah 40:31",
				"And we know that in all things God works for the good of those who love him, who have been called according to his purpose. - Romans 8:28",
				"Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus. - Philippians 4:6-7",
				"Have I not commanded you? Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.' - Joshua 1:9",
				"Even though I walk through the darkest valley, I will fear no evil, for you are with me; your rod and your staff, they comfort me. - Psalm 23:4",
				"So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand. - Isaiah 41:10",
				"For the Spirit God gave us does not make us timid, but gives us power, love and self-discipline. - 2 Timothy 1:7",
				"I can do all this through him who gives me strength. - Philippians 4:13",
				"Faith in Action Now faith is confidence in what we hope for and assurance about what we do not see. - Hebrews 11:1",
				"For we live by faith, not by sight. - 2 Corinthians 5:7",
				"If you can?' said Jesus. 'Everything is possible for one who believes.' - Mark 9:23",
				"But when you ask, you must believe and not doubt, because the one who doubts is like a wave of the sea, blown and tossed by the wind. - James 1:6",
				"For it is by grace you have been saved, through faith and this is not from yourselves, it is the gift of God not by works, so that no one can boast. - Ephesians 2:8-9",
				"If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness. - 1 John 1:9",
				"as far as the east is from the west, so far has he removed our transgressions from us. - Psalm 103:12",
				"Who is a God like you, who pardons sin and forgives the transgression of the remnant of his inheritance? You do not stay angry forever but delight to show mercy. You will again have compassion on us; you will tread our sins underfoot and hurl all our iniquities into the depths of the sea. - Micah 7:18-19",
				"For if you forgive other people when they sin against you, your heavenly Father will also forgive you. But if you do not forgive others their sins, your Father will not forgive your sins. - Matthew 6:14-15",
				"for all have sinned and fall short of the glory of God, and all are justified freely by his grace through the redemption that came by Christ Jesus. - Romans 3:23-24",
				"Ask, Seek, Knock 'Ask and it will be given to you; seek and you will find; knock and the door will be opened to you. - Matthew 7:7",
				"Rejoice always, pray continually, give thanks in all circumstances; for this is God's will for you in Christ Jesus. - 1 Thessalonians 5:16-18",
				"Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. - Philippians 4:6",
				"Therefore confess your sins to each other and pray for each other so that you may be healed. The prayer of a righteous person is powerful and effective. - James 5:16",
				"The Lord is near to all who call on him, to all who call on him in truth. - Psalm 145:18",
				"Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid. - John 14:27",
				"Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls. For my yoke is easy and my burden is light.' - Matthew 11:28-30",
				"For the director of music. Of the Sons of Korah. According to alamoth. A song. God is our refuge and strength, an ever-present help in trouble. - Psalm 46:1",
				"He will wipe every tear from their eyes. There will be no more death' or mourning or crying or pain, for the old order of things has passed away.' - Revelation 21:4",
				"The Lord is close to the brokenhearted and saves those who are crushed in spirit. - Psalm 34:18",
				"Salvation is found in no one else, for there is no other name under heaven given to mankind by which we must be saved.' - Acts 4:12",
				"If you declare with your mouth, 'Jesus is Lord' and believe in your heart that God raised him from the dead, you will be saved. - Romans 10:9",
				"The thief comes only to steal and kill and destroy; I have come that they may have life, and have it to the full. - John 10:10",
				"And this is the testimony: God has given us eternal life, and this life is in his Son. Whoever has the Son has life; whoever does not have the Son of God does not have life. - 1 John 5:11-12",
				"he saved us, not because of righteous things we had done, but because of his mercy. He saved us through the washing of rebirth and renewal by the Holy Spirit, - Titus 3:5",
				"Your word is a lamp for my feet, a light on my path. - Psalm 119:105",
				"All Scripture is God-breathed and is useful for teaching, rebuking, correcting and training in righteousness, so that the servant of God may be thoroughly equipped for every good work. - 2 Timothy 3:16-17",
				"For the word of God is alive and active. Sharper than any double-edged sword, it penetrates even to dividing soul and spirit, joints and marrow; it judges the thoughts and attitudes of the heart. - Hebrews 4:12",
				"so is my word that goes out from my mouth: It will not return to me empty, but will accomplish what I desire and achieve the purpose for which I sent it. - Isaiah 55:11",
				"Jesus answered, 'It is written: 'Man shall not live on bread alone, but on every word that comes from the mouth of God.' ' - Matthew 4:4",
				"But seek first his kingdom and his righteousness, and all these things will be given to you as well. - Matthew 6:33",
				"Do not merely listen to the word, and so deceive yourselves. Do what it says. - James 1:22",
				"But just as he who called you is holy, so be holy in all you do; for it is written: 'Be holy, because I am holy.' - 1 Peter 1:15-16",
				"But the fruit of the Spirit is love, joy, peace, forbearance, kindness, goodness, faithfulness, gentleness and self-control. Against such things there is no law. - Galatians 5:22-23",
				"Do not conform to the pattern of this world, but be transformed by the renewing of your mind. Then you will be able to test and approve what God's will is his good, pleasing and perfect will. - Romans 12:2",
				"Love is patient, love is kind. It does not envy, it does not boast, it is not proud. It does not dishonor others, it is not self-seeking, it is not easily angered, it keeps no record of wrongs. Love does not delight in evil but rejoices with the truth. It always protects, always trusts, always hopes, always perseveres. - 1 Corinthians 13:4-7",
				"Jesus replied: 'Love the Lord your God with all your heart and with all your soul and with all your mind.' This is the first and greatest commandment. And the second is like it: 'Love your neighbor as yourself.' - Matthew 22:37-39",
				"A new command I give you: Love one another. As I have loved you, so you must love one another. By this everyone will know that you are my disciples, if you love one another.' - John 13:34-35",
				"For the entire law is fulfilled in keeping this one command: 'Love your neighbor as yourself.' - Galatians 5:14",
				"And over all these virtues put on love, which binds them all together in perfect unity. - Colossians 3:14",
				"Be strong and courageous. Do not be afraid or terrified because of them, for the Lord your God goes with you; he will never leave you nor forsake you.' - Deuteronomy 31:6",
				"Cast your cares on the Lord and he will sustain you; he will never let the righteous be shaken. - Psalm 55:22",
				"When you pass through the waters, I will be with you; and when you pass through the rivers, they will not sweep over you. When you walk through the fire, you will not be burned; the flames will not set you ablaze. - Isaiah 43:2",
				"May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit. - Romans 15:13",
				"But he said to me, 'My grace is sufficient for you, for my power is made perfect in weakness. ' Therefore I will boast all the more gladly about my weaknesses, so that Christ's power may rest on me. That is why, for Christ's sake, I delight in weaknesses, in insults, in hardships, in persecutions, in difficulties. For when I am weak, then I am strong. - 2 Corinthians 12:9-10",
				"If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you. - James 1:5",
				"The fear of the Lord is the beginning of knowledge, but fools despise wisdom and instruction. - Proverbs 1:7",
				"A Time for Everything There is a time for everything, and a season for every activity under the heavens: - Ecclesiastes 3:1",
				"The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding. - Proverbs 4:7",
				"Let the message of Christ dwell among you richly as you teach and admonish one another with all wisdom through psalms, hymns, and songs from the Spirit, singing to God with gratitude in your hearts. - Colossians 3:16",
				"Do nothing out of selfish ambition or vain conceit. Rather, in humility value others above yourselves, not looking to your own interests but each of you to the interests of the others. - Philippians 2:3-4",
				"He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God. - Micah 6:8",
				"For even the Son of Man did not come to be served, but to serve, and to give his life as a ransom for many.' - Mark 10:45",
				"Greater love has no one than this: to lay down one's life for one's friends. - John 15:13",
				"Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up. Therefore, as we have opportunity, let us do good to all people, especially to those who belong to the family of believers. - Galatians 6:9-10",
				"The Lord is not slow in keeping his promise, as some understand slowness. Instead he is patient with you, not wanting anyone to perish, but everyone to come to repentance. - 2 Peter 3:9",
				"God is not human, that he should lie, not a human being, that he should change his mind. Does he speak and then not act? Does he promise and not fulfill? - Numbers 23:19",
				"No temptation has overtaken you except what is common to mankind. And God is faithful; he will not let you be tempted beyond what you can bear. But when you are tempted, he will also provide a way out so that you can endure it. - 1 Corinthians 10:13",
				"Keep your lives free from the love of money and be content with what you have, because God has said, 'Never will I leave you; never will I forsake you.' - Hebrews 13:5",
				"and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age.' - Matthew 28:20",
				"The Beginning In the beginning God created the heavens and the earth. - Genesis 1:1",
				"For the director of music. A psalm of David. The heavens declare the glory of God; the skies proclaim the work of his hands. - Psalm 19:1",
				"For in him all things were created: things in heaven and on earth, visible and invisible, whether thrones or powers or rulers or authorities; all things have been created through him and for him. - Colossians 1:16",
				"You alone are the Lord . You made the heavens, even the highest heavens, and all their starry host, the earth and all that is on it, the seas and all that is in them. You give life to everything, and the multitudes of heaven worship you. - Nehemiah 9:6",
				"For since the creation of the world God's invisible qualitieshis eternal power and divine naturehave been clearly seen, being understood from what has been made, so that people are without excuse. - Romans 1:20",
				"I will instruct you and teach you in the way you should go; I will counsel you with my loving eye on you. - Psalm 32:8",
				"Whether you turn to the right or to the left, your ears will hear a voice behind you, saying, 'This is the way; walk in it.' - Isaiah 30:21",
				"But when he, the Spirit of truth, comes, he will guide you into all the truth. He will not speak on his own; he will speak only what he hears, and he will tell you what is yet to come. - John 16:13",
				"The Lord makes firm the steps of the one who delights in him; though he may stumble, he will not fall, for the Lord upholds him with his hand. - Psalm 37:23-24",
				"In their hearts humans plan their course, but the Lord establishes their steps. - Proverbs 16:9",
				"Give thanks to the Lord, for he is good; his love endures forever. - 1 Chronicles 16:34",
				"give thanks in all circumstances; for this is God's will for you in Christ Jesus. - 1 Thessalonians 5:18",
				"And whatever you do, whether in word or deed, do it all in the name of the Lord Jesus, giving thanks to God the Father through him. - Colossians 3:17",
				"Enter his gates with thanksgiving and his courts with praise; give thanks to him and praise his name. For the Lord is good and his love endures forever; his faithfulness continues through all generations. - Psalm 100:4-5",
				"Therefore, since we are receiving a kingdom that cannot be shaken, let us be thankful, and so worship God acceptably with reverence and awe, - Hebrews 12:28",
				"Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up. - Galatians 6:9",
				"Therefore, since we are surrounded by such a great cloud of witnesses, let us throw off everything that hinders and the sin that so easily entangles. And let us run with perseverance the race marked out for us, fixing our eyes on Jesus, the pioneer and perfecter of faith. For the joy set before him he endured the cross, scorning its shame, and sat down at the right hand of the throne of God. - Hebrews 12:1-2",
				"Not only so, but we also glory in our sufferings, because we know that suffering produces perseverance; perseverance, character; and character, hope. - Romans 5:3-4",
				"Blessed is the one who perseveres under trial because, having stood the test, that person will receive the crown of life that the Lord has promised to those who love him. - James 1:12",
				"Do not be afraid of what you are about to suffer. I tell you, the devil will put some of you in prison to test you, and you will suffer persecution for ten days. Be faithful, even to the point of death, and I will give you life as your victor's crown. - Revelation 2:10",
				"For I am convinced that neither death nor life, neither angels nor demons, neither the present nor the future, nor any powers, neither height nor depth, nor anything else in all creation, will be able to separate us from the love of God that is in Christ Jesus our Lord. - Romans 8:38-39",
				"Jesus said to her, 'I am the resurrection and the life. The one who believes in me will live, even though they die; and whoever lives by believing in me will never die. Do you believe this?' - John 11:25-26",
				"A song of ascents. I lift up my eyes to the mountains where does my help come from? My help comes from the Lord, the Maker of heaven and earth. - Psalm 121:1-2",
				"Epilogue: Invitation and Warning 'Look, I am coming soon! My reward is with me, and I will give to each person according to what they have done. I am the Alpha and the Omega, the First and the Last, the Beginning and the End. - Revelation 22:12-13",
				"Doxology To him who is able to keep you from stumbling and to present you before his glorious presence without fault and with great joy to the only God our Savior be glory, majesty, power and authority, through Jesus Christ our Lord, before all ages, now and forevermore! Amen. - Jude 1:24-25",
			],
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
