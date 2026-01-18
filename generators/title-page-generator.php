<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';

function checkAndResizeImageIfRequired($source_path, $max_width = 800, $max_height = 500, $quality = 90) {
    // Load the image
    $source_image = imagecreatefromjpeg($source_path);
    if (!$source_image) {
        return false;
    }

    $original_width  = imagesx($source_image);
    $original_height = imagesy($source_image);

    // Only resize if image exceeds at least one of the max dimensions
    if ($original_width <= $max_width && $original_height <= $max_height) {
        // No need to resize — clean up and exit early
        imagedestroy($source_image);
        return true;  // or false if you want to signal "no change made"
    }

    // Calculate scaling ratio to fit within both constraints (preserves aspect ratio)
    $ratio = min($max_width / $original_width, $max_height / $original_height);

    // New dimensions (will be ≤ max in both directions)
    $new_width  = (int) round($original_width * $ratio);
    $new_height = (int) round($original_height * $ratio);

    // Ensure we don't end up with zero dimension due to rounding
    $new_width  = max(1, $new_width);
    $new_height = max(1, $new_height);

    // Create new image
    $resized_image = imagecreatetruecolor($new_width, $new_height);
    if (!$resized_image) {
        imagedestroy($source_image);
        return false;
    }

    // Optional: fill with white background (good for JPG → JPG)
    $white = imagecolorallocate($resized_image, 255, 255, 255);
    imagefill($resized_image, 0, 0, $white);

    // High-quality resize
    imagecopyresampled(
        $resized_image, $source_image,
        0, 0, 0, 0,
        $new_width, $new_height,
        $original_width, $original_height
    );

    // Overwrite original file
    $success = imagejpeg($resized_image, $source_path, $quality);

    // Cleanup
    imagedestroy($source_image);
    imagedestroy($resized_image);

    return $success;
}




class TitlePageGenerator extends Generator {
	protected function generate_anchor_string() : ?string {
		return 'title_page';
	}



	protected function generate_content() : void {
        
        $config = \ReCalendar\LocalConfig::getInstance();
        
   /* if ( class_exists( '\ReCalendar\LocalConfig' ) ) {
        $config = new \Recalendar\LocalConfig();
    } else {
        $config = new \Recalendar\Config();
    }
*/
    $blDebug = $config->get('debug');

      
		$year = (int) $this->config->get( Config::YEAR );
		$subtitle = $this->config->get( Config::SUBTITLE );
		$title_image_file_and_path = "title_image.jpg";
		list($width, $height, $type) = getimagesize($title_image_file_and_path) ?: [0, 0, 0];
		checkAndResizeImageIfRequired($title_image_file_and_path);
        if ($blDebug) {
            $ifDebugRedStyle = " style='color:red'";
            $debugWord = "DEBUG!";
        } else {
            $ifDebugRedStyle = "";
            $debugWord = "";
        }
?>
		
		<div class="title-page">
			<div align=center><img src="title_image.png"></img></div>
			<div class="title-page__year" <?php echo $ifDebugRedStyle?>><?php echo $debugWord . $year; ?></div>
			<div class="title-page__recalendar"><?php echo $subtitle ?></div>
		</div>
<?php
	}
}
