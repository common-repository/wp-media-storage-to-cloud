<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://rextheme.com/wp-debug
 * @since      1.0.0
 *
 * @package    Wp_Debug
 * @subpackage Wp_Debug/admin/partials
 */
?>

<?php
if (file_exists(WP_CONTENT_DIR. '/debug.log')) {
    $directory = WP_CONTENT_DIR. '/debug.log';
    if (filesize($directory) > 5000000) {
        unlink($directory);
    } else {
        $data = file($directory, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
} else {
    $data = false;
}
?>

<div class="debug-log-container">
    <h1 class="debug-log-header">Debug Log</h1>
    <div class="debug-log-button_container">
      <button type="button" id="wp_debug_clear" class="wp_debug_button" name="wp_debug_clear">Clear All</button>
      <?php
        if ($data) {
            $path = home_url() .'/wp-content/debug.log'; ?>
            <a href="<?php echo $path; ?>" class="wp_debug_button" download>Download</a>
          <?php
        }
      ?>
    </div>
    <?php
      if ($data) {
          ?>
        <div class="debug-log-body-container">
            <ul style="padding: 5%;">
              <?php
                foreach ($data as $line) {
                    ?>
                    <li><?php echo $line; ?></li>
                  <?php
                } ?>
            </ul>
        </div>
        <?php
      } else {
          ?>
        <div class="debug-log-body-container" style="height:50px; overflow:auto;">
            <p class="debug-log-empty" style="text-align:center;">No log found</p>
        </div>
        <?php
      }
    ?>
</div>
