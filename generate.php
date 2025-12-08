#!/usr/bin/env php
<?php
declare(strict_types=1);


error_reporting(E_ERROR); ini_set('display_errors', '1');


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


if ( class_exists( '\ReCalendar\LocalConfig' ) ) {
	$config = new \Recalendar\LocalConfig();
} else {
	$config = new \Recalendar\Config();
}

echo "Set Locale...";

setlocale( LC_TIME, $config->get( \ReCalendar\Config::LOCALE ) );

echo "Get recalendar.php";

try {
	require_once __DIR__ . '/recalendar.php';
	echo "Get recalendar.php2";

 } catch (\Throwable $e) {
	
	echo "Get recalendar.php 3";

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
    // Escape for PowerShell
    $cmd = "powershell -Command \"[console]::Beep($freq, $dur)\"";
    shell_exec($cmd);
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
		'tempDir' =>  "C:\\temp\\",
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
	echo 'Total Execution Time: '. number_format((float) $execution_time, 2).' Mins';
	// if you get weird results, use number_format((float) $execution_time, 10)
	echo "\nIf all good - you can run py renameLatestJournalPDF.py";
} catch (\Throwable $e) {
    echo "\nAK Error - This was caught: " . $e->getMessage();
	error_beep();
	echo $e;
}

	