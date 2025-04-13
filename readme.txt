=== ShareThis Count by WebsitePasal ===
Contributors: solutionsaroj
Tags: share count, sharethis, social sharing, multiplier, format counts
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.7
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Visually multiply and format ShareThis share counts into K (thousand) and M (million). Ideal for publishers who want to show scaled-up social proof.

== Description ==
This plugin enhances ShareThis social share buttons by allowing you to multiply the share count visually on the frontend and display it in a more impactful format like **1.5k** or **2M**.

It's great for publishers, marketers, and bloggers who want to display rounded, eye-catching numbers based on ShareThis' share counts.

> ⚠ Requires the [ShareThis plugin](https://wordpress.org/plugins/sharethis-share-buttons/) to function.

== Installation ==
1. Install and activate the ShareThis plugin first.
2. Upload this plugin to the `/wp-content/plugins/` directory or install it via WordPress admin.
3. Activate **ShareThis Count by WebsitePasal**.
4. Go to **Settings > ShareThis Count** to configure the multiplier value.

== Frequently Asked Questions ==

= Does this modify actual share counts? =
No. It only affects what users *see* on the frontend. The backend values from ShareThis remain untouched.

= Can I use a decimal multiplier like 1.5? =
Yes! The input accepts decimal numbers like `1.5`, `2.75`, etc.

= Will this work without the ShareThis plugin? =
No. This plugin requires ShareThis to be installed and active.

== Screenshots ==
1. Settings page with multiplier input.
2. Share buttons showing multiplied and formatted counts (1.5k, 2M, etc.).

== Changelog ==

= 1.7 =
* Fixed stable tag mismatch.
* Limited tags to 5 (as per WP.org standards).
* Sanitization and escaping functions added.
* Compatible with WP 6.5.

== Upgrade Notice ==
= 1.7 =
Sanitization and escaping improvements. Complies with WordPress.org plugin guidelines.
