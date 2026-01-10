<?php
declare(strict_types=1);

namespace ReCalendar;

require_once __DIR__ . '/generator.php';

function checkAndResizeImageIfRequired($source_path, $max_width = 800, $max_height = 500, $quality = 90) {
    // Load
    $source_image = imagecreatefromjpeg($source_path);
    if (!$source_image) return false;

    $original_width  = imagesx($source_image);
    $original_height = imagesy($source_image);

    // Calculate the ratio
    $ratio = min($max_width / $original_width, $max_height / $original_height);

    // New dimensions
    $new_width  = (int)($original_width * $ratio);
    $new_height = (int)($original_height * $ratio);

    // Create resized image
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    // Optional: white background for JPG
    $white = imagecolorallocate($resized_image, 255, 255, 255);
    imagefill($resized_image, 0, 0, $white);

    // Resize with high quality
    imagecopyresampled(
        $resized_image, $source_image,
        0, 0, 0, 0,
        $new_width, $new_height,
        $original_width, $original_height
    );

    // Save
    imagejpeg($resized_image, $source_path, $quality);

    // Cleanup
    imagedestroy($source_image);
    imagedestroy($resized_image);

    return true;
}




class TitlePageGenerator extends Generator {
	protected function generate_anchor_string() : ?string {
		return 'title_page';
	}



	protected function generate_content() : void {
        
        
    if ( class_exists( '\ReCalendar\LocalConfig' ) ) {
        $config = new \Recalendar\LocalConfig();
    } else {
        $config = new \Recalendar\Config();
    }

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
