<?php
//ak functions

$G_BL_AK_DEBUG = false;

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