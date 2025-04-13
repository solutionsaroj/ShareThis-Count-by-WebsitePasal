<?php
/*
Plugin Name: ShareThis Count by WebsitePasal
Description: Multiplies ShareThis counts and formats them as K/M
Version: 1.6
Author: Solutionsaroj
Author URI: https://sarojkhanal.com
Text Domain: sharethis-count-by-websitepasal
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Admin settings page
add_action('admin_menu', function() {
    add_options_page(
        __('ShareThis Count Settings', 'sharethis-count-by-websitepasal'),
        __('ShareThis Count', 'sharethis-count-by-websitepasal'),
        'manage_options',
        'sharethis-count',
        'stc_settings_page'
    );
});

// Register the multiplier setting
add_action('admin_init', function() {
    register_setting('stc_settings_group', 'stc_multiplier');
});

// Backend settings page content
function stc_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('ShareThis Count Settings', 'sharethis-count-by-websitepasal'); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('stc_settings_group'); ?>
            <?php do_settings_sections('stc_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <?php esc_html_e('Share Count Multiplier', 'sharethis-count-by-websitepasal'); ?>
                    </th>
                    <td>
                        <input type="number" step="0.1" name="stc_multiplier" value="<?php echo esc_attr(get_option('stc_multiplier', 10)); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Hide original share count until modified
add_action('wp_head', function() {
    echo '<style>.st-label { visibility: hidden; }</style>';
});

// Inject JavaScript to update frontend counts
add_action('wp_footer', function() {
    $multiplier = get_option('stc_multiplier', 10);
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
                var el = $(this);
                if (el.attr('data-modified') === 'true') return;

                var originalText = el.text();
                var original = parseFormattedNumber(originalText);
                if (!isNaN(original)) {
                    var multiplied = original * <?php echo floatval($multiplier); ?>;
                    el.text(formatNumber(multiplied));
                    el.css('visibility', 'visible');
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