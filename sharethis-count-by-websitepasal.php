<?php
/*
Plugin Name: ShareThis Count by WebsitePasal
Description: Multiplies ShareThis share counts and formats them as K/M style numbers.
Version: 1.7
Author: Solutionsaroj
Author URI: https://sarojkhanal.com
Text Domain: sharethis-count-by-websitepasal
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Admin settings page
add_action('admin_menu', function() {
    add_options_page('ShareThis Count Settings', 'ShareThis Count', 'manage_options', 'sharethis-count', 'stc_settings_page');
});

// Register the setting with sanitization
add_action('admin_init', function() {
    register_setting(
        'stc_settings_group',      // Option group
        'stc_multiplier',          // Option name
        'stc_sanitize_multiplier'  // Sanitization callback
    );
});

// Sanitization callback
function stc_sanitize_multiplier($input) {
    return floatval($input); // Ensures it's a float
}

// Backend settings page content
function stc_settings_page() {
    ?>
    <div class="wrap">
        <h1>ShareThis Count Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('stc_settings_group'); ?>
            <?php do_settings_sections('stc_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Share Count Multiplier</th>
                    <td><input type="number" name="stc_multiplier" value="<?php echo esc_attr(get_option('stc_multiplier', 10)); ?>" step="0.1" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Hide original share count until updated
add_action('wp_head', function() {
    echo '<style>.st-label { visibility: hidden; }</style>';
});

// Inject JS to modify share counts
add_action('wp_footer', function() {
    $multiplier = get_option('stc_multiplier', 10); // Default multiplier
    ?>
    <script>
    (function($) {
        function parseFormattedNumber(str) {
            str = str.toLowerCase().replace(/,/g, '').trim();
            if (str.endsWith('k')) return parseFloat(str) * 1000;
            if (str.endsWith('m')) return parseFloat(str) * 1000000;
            return parseFloat(str);
        }

        function formatNumber(num) {
            if (num >= 1000000) return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
            if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
            return Math.round(num);
        }

        function updateShareCounts() {
            $('span.st-label').each(function() {
                let el = $(this);
                if (el.attr('data-modified') === 'true') return;

                let originalText = el.text();
                let original = parseFormattedNumber(originalText);
                if (!isNaN(original)) {
                    let multiplied = original * <?php echo esc_js($multiplier); ?>;
                    el.text(formatNumber(multiplied)).css('visibility', 'visible');
                    el.attr('data-modified', 'true');
                }
            });
        }

        let tries = 0;
        let interval = setInterval(function() {
            updateShareCounts();
            tries++;
            if (tries > 10) clearInterval(interval);
        }, 1000);
    })(jQuery);
    </script>
    <?php
});
