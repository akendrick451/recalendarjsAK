<?php
//ak functions
   require_once __DIR__ . '/config.php';


$config = \ReCalendar\LocalConfig::getInstance();



   $blDebug = $config->get('debug');


function AKDebug (string $strMessage) {

	if ( $blDebug) {
		// echo may go to building the pdf, so write out echo and then something ob_start
		$currentEchoBuffer = ob_get_clean();

		echo "AKDebug " . $strMessage;
		ob_start(); // restart buffering
		echo $currentEchoBuffer; // put the previous data back in
	}

}

function minus2InBase7($num1) {
    // 1. Convert base-7 strings to decimal
    

    // 2. Subtract in base-10
    $resultDec = $num1 - 2;

    // 3. Convert result back to base-
	
	$intBase7Number = base_convert($resultDec, 10, 7);
	//echo "base7InitialValue " . $resultDec . " and convertednumber " . $intBase7Number;
    return $intBase7Number;
}

/**
 * Deletes .html and .pdf files in the given directory that are older than $hours hours.
 *
 * @param string $directory     Absolute or relative path to the directory
 * @param int    $hours         How many hours old a file must be to be deleted (default: 24)
 * @param bool   $dryRun        If true, only lists files that would be deleted (default: false)
 * @param bool   $verbose       If true, prints what is happening (default: true)
 * @return array                Array with 'deleted' and 'skipped' counts + list of deleted files
 */
function deleteOldHtmlAndPdf(string $directory, int $hours = 24, bool $dryRun = false, bool $verbose = true): array
{
    $result = [
        'deleted' => 0,
        'skipped' => 0,
        'files_deleted' => [],
        'errors' => [],
    ];

    // Normalize path and check if directory exists
    $directory = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR;
    if (!is_dir($directory)) {
        $result['errors'][] = "Directory does not exist: $directory";
        if ($verbose) {
            echo "Error: Directory does not exist: $directory\n";
        }
        return $result;
    }

    if (!is_writable($directory)) {
        $result['errors'][] = "Directory is not writable: $directory";
        if ($verbose) {
            echo "Error: Directory is not writable: $directory\n";
        }
        return $result;
    }

    $now = time();
    $ageLimit = $hours * 3600; // seconds

    $files = glob($directory . "*.{html,pdf}", GLOB_BRACE);

    if (empty($files)) {
        if ($verbose) {
            echo "No .html or .pdf files found in $directory\n";
        }
        return $result;
    }

    foreach ($files as $file) {
        if (!is_file($file)) {
            continue;
        }

        $fileAge = $now - filemtime($file);

        if ($fileAge >= $ageLimit) {
            $filename = basename($file);

            if ($dryRun) {
                if ($verbose) {
                    echo "[DRY RUN] Would delete: $filename (age: " . round($fileAge / 3600, 1) . " hours)\n";
                }
                $result['deleted']++;
                $result['files_deleted'][] = $filename;
                continue;
            }

            if (@unlink($file)) {
                if ($verbose) {
                    echo "Deleted: $filename (age: " . round($fileAge / 3600, 1) . " hours)\n";
                }
                $result['deleted']++;
                $result['files_deleted'][] = $filename;
            } else {
                $error = error_get_last();
                $msg = $error['message'] ?? 'Unknown error';
                if ($verbose) {
                    echo "Failed to delete $filename: $msg\n";
                }
                $result['errors'][] = "Failed to delete $filename: $msg";
                $result['skipped']++;
            }
        } else {
            $result['skipped']++;
            // Optional: log skipped files too
            // if ($verbose) echo "Kept: " . basename($file) . " (too new)\n";
        }
    }

    if ($verbose && $result['deleted'] === 0 && empty($result['errors'])) {
        echo "No files older than $hours hours were found.\n";
    }

    return $result;
}

function error_beep() {
		
		
	// Simple success beep
	//beep(1000, 200);
	//sleep(1);

	// Play a little victory tune
	$melody = [
		[1046, 150], // C6
		[1318, 150], // E6
		[1568, 150], // G6
		[2093, 600], // C7
	];

	foreach ($melody as $note) {
		beep($note[0], $note[1]);
		usleep(50000); // tiny pause between notes
	}
	/*
	// Basic beep (800 Hz, 500 ms)
	//	echo "1st beep\n";
	//	shell_exec('powershell -Command "[console]::Beep(800,500)"');
	//	echo "2nt beeps\n";
	// Multiple beeps example	
	//	shell_exec('powershell -Command "[console]::Beep(1000,200); [console]::Beep(1500,200); [console]::Beep(2000,400)"');
	//	shell_exec('powershell -Command "[console]::Beep(1000,200); [console]::Beep(1500,200); [console]::Beep(2000,400)"');
	//	shell_exec('powershell -Command "[console]::Beep(1000,200); [console]::Beep(1500,200); [console]::Beep(2000,400)"');

	//shell_exec('powershell -Command "Add-Type -AssemblyName System.Windows.Forms; [System.Windows.Forms.MessageBeep]::Play"');

	// Or specific frequencies (same as Method 1)
	//shell_exec('powershell -Command "[console]::Beep(440,300)"'); // A note


	// Plays the default Windows "Exclamation" or "Asterisk" sound
	shell_exec('powershell -Command "(New-Object System.Media.SoundPlayer).PlaySync()"');

	// Or play the classic Windows Ding.wav
	shell_exec('powershell -Command "(New-Object Media.SoundPlayer \'C:\\Windows\\Media\\Windows Ding.wav\').PlaySync()"');
	*/
} // error beep noise

function good_beep() {
		
		
	// Simple success beep
	beep(1000, 200);
	sleep(1);

	
} // error beep noise

?>