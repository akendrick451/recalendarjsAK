#!/usr/bin/env php
<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
error_reporting(E_ERROR); 
ini_set('display_errors', '1');

// AK VERSION INFO
// Version 1.2 17 Jan 2025 (17/01/2025)
// 1.3 18/01/2025 - darker lines in eisenhower

//place this before any script you want to calculate time
date_default_timezone_set('Australia/Melbourne');
$time_start = microtime(true); 
$intRepeat = 100;



echo str_repeat("=", $intRepeat) . "\n";
echo str_repeat("=", $intRepeat) . "\n";
echo str_repeat("=", $intRepeat) . "\n";
echo str_repeat("=", $intRepeat) . "\n";
echo "=== RECALENDAR JS STARTING ";
echo "Start now " .  (new \DateTime())->format( 'Y-m-d H:i:s' ) . "\n";
echo str_repeat("=", $intRepeat) . "\n";
echo str_repeat("=", $intRepeat) . "\n";
echo str_repeat("=", $intRepeat) . "\n";
echo str_repeat("=", $intRepeat) . "\n";


//on very first run make sure we have an output folder that is not created automatically by git as it has gitignore 

try {
	echo "require config.php";
   require_once __DIR__ . '/config.php';
   echo "... require vendor autoload.";
   require_once __DIR__ . '/vendor/autoload.php';
  
} catch (\Throwable $e) {
    echo "This was caught: " . $e->getMessage();
}


echo "Check Arguments";

if ( $argc > 1 && $argv[1] === '-c' ) {
	if ( empty( $argv[2] ) ) {
		exit( 'Please provide a path to the configuration file.' );
	}

	if ( ! file_exists( $argv[2] ) ) {
		exit( 'The provided configuration file does not exist: ' . $argv[2] );
	}

	require_once $argv[2];
} elseif ( file_exists( __DIR__ . '/local.config.php' ) ) {
	require_once __DIR__ . '/local.config.php';
}



echo "Check if class exists...";

$config = \ReCalendar\LocalConfig::getInstance();
/*
if ( class_exists( '\ReCalendar\LocalConfig' ) ) {
	$config = new \Recalendar\LocalConfig();
} else {
	$config = new \Recalendar\Config();
}*/

require __DIR__ . '/generators/generator.php';


// check if we are debug or test.. then set to only 1 month for speed
// else set to 6
if ( $argc > 1 && $argv[1] === 'debug' ) {
	$config->set('debug', true);
	$month_count = (int) $config->get( 'month_count' );
	echo $month_count;
	$config->set( 'month_count', 1);
	echo "DEBUG/TEST ONLY USING ONE MONTH";
	$month_count = (int) $config->get( 'month_count' );
	echo "Month count should now be one.... it is [" . $month_count . "]";

} else {
	$config->set('debug', false);
}


echo "Set Locale...";

setlocale( LC_TIME, $config->get( \ReCalendar\Config::LOCALE ) );

echo "Get recalendar.php";

try {
	require_once __DIR__ . '/recalendar.php';
	echo "Get recalendar.php2";

 } catch (\Throwable $e) {
	
	echo "Get recalendar.php 3";
	echo "Have you installed mpdf at least once? eg linux composer require mpdf/mpdf";
	echo "And sudo apt install php8.3-gd gd extesnion";

	 echo "\nThis was caught: " . $e->getMessage();
	 echo $e;
 }


echo "l function";
function l( $stuff ) : void {
	if ( is_string( $stuff ) ) {
		echo $stuff . "\n";
	} else {
		var_export( $stuff );
		echo "\n";
	}
}

function beep($frequency = 800, $duration = 300) {
    $freq = (int)$frequency;
    $dur  = (int)$duration;
	for ($i = 0; $i < 4; $i++) {
    // Output the ASCII Bell character
    echo "\x07"; 
    
    // Brief pause to distinguish individual beeps
    usleep(50000); // 0.05 seconds
}

    
}


try {
	echo "Setup done.. get config1...";

	// try to do a beep\a
	

	$defaultConfig = ( new \Mpdf\Config\ConfigVariables() )->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];

	echo "Setup done.. get config2...";

	$defaultFontConfig = ( new \Mpdf\Config\FontVariables() )->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];

	echo "\nSetup done.. create new mpdf...";
	// creates a calendar and saves it in ReCalendar.pdf
	$mpdf = new \Mpdf\Mpdf( [
	    'tempDir' => __DIR__ . '/my-mpdf-temp',
		'fontDir' => array_merge( $fontDirs, [
			__DIR__ . $config->get( \ReCalendar\Config::FONT_DIR ),
		] ),
		'fontdata' => $fontData + $config->get( \ReCalendar\Config::FONT_DATA ),
		'mode' => 'utf-8',
		'format' => $config->get( \ReCalendar\Config::FORMAT ),
		'default_font' => $config->get( \ReCalendar\Config::FONT_DEFAULT ),
		'margin_left' => 0,
		'margin_right' => 0,
		'margin_top' => 0,
		'margin_bottom' => 0,
		'margin_header' => 0,
		'margin_footer' => 0, 
		
	] );

	$mpdf->useSubstitutions = false;

	$recalendar = new \ReCalendar\ReCalendar( $mpdf, $config );

	echo "trying to generate now...";
	$recalendar->generate();
	$time_end = microtime(true);
	echo 'Finish at '.  (new \DateTime())->format( 'Y-m-d H:i:s' );
	//dividing with 60 will give the execution time in minutes otherwise seconds
	$execution_time = ($time_end - $time_start)/60;   //execution time of the script
	echo "You probably now want to run python .\\renameLatestJournalPDF.py";
	echo '<b>Total Execution Time:</b> '. number_format((float) $execution_time, 1).' Mins';
	// if you get weird results, use number_format((float) $execution_time, 10)
	echo "\nIf all good - you can run python .\\renameLatestJournalPDF.py";
	good_beep();

	
} catch (\Throwable $e) {
    echo "\nAK Error - This was caught: " . $e->getMessage();
	error_beep();
	echo $e;
}

	