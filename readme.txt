=== Nepali Date Converter ===
Contributors: addonspress, acmeit, codersantosh
Donate link: https://www.addonspress.com/
Tags: Nepali post date, Nepali date converter, today Nepali date, English to Nepali  date converter, Nepali to English date converter
Requires at least: 4.9
Tested up to: 6.5
Stable tag: 2.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Effortlessly Convert between English and Nepali Dates, Including Converting Post Dates to Nepali Dates. Also supports displaying today's date.

== Description ==

If you're looking for a sleek and functional WordPress theme that integrates seamlessly with a Nepali date converter plugin, 
check out this [free WordPress theme: CosmosWP](https://wordpress.org/themes/cosmoswp/). It comes with a [demo showcasing the Nepali date converter](https://demo.cosmoswp.com/demo-99/) plugin in action.

Newly Added Feature: Convert Post Dates to Nepali Dates. Access the setting under Admin => Setting => General.

Nepali Date Converter is a plugin with widgets and shortcodes which convert Nepali Dates to English Date and English Date to Nepali Date.
You can also show either today's Nepali date, today's English date or both.
Now you can also change the Post Date to Nepali Date.

== Main Features ==

* Show Post Date to Nepali
* Nepali Human Time Diff (Eg: ३ सेकेन्ड अगाडि)
* Widget: Nepali Date Converter
* Widget: Nepali Today Date
* Shortcode: Nepali Date Converter=> [nepali-date-converter]
* Shortcode: Nepali Today Date=> [ndc-today-date]
* Various Custom function to convert English Date to Nepali and Nepali Date to English

== Show Post Date to Nepali ==

From the Dashboard go to `Setting => General` and scroll to the bottom

== Available Widgets ==

You will find the following widgets with advanced options:

* NDC: Nepali Date Converter
* NDC: Today Date

== Available Shortcodes ==

You can use the following shortcodes either to display Nepali Date Converter or Today Date anywhere in the posts or pages:

* Use `[nepali-date-converter]` to show Nepali Date Converter
* Use `[ndc-today-date]` to show Today Date

Again the shortcode `[nepali-date-converter]` comes with the following options:

* 'before' => Use anything to show before Nepali Date Converter eg: `<div class="ndc-wrapper">`,
* 'after' => Use anything to show after Nepali Date Converter eg: `</div>`,
* 'before_title' => Use anything to show before Title eg: `<div class="ndc-title">`,
* 'after_title' => Use anything to show after title eg: `</div>`,
* 'title' => Write something for the title `Nepali Date Converter`,
* 'disable_ndc_convert_nep_to_eng' => Write `1` to disable converting Nepali Date to English Date,
* 'disable_ndc_convert_eng_to_nep' =>  Write `1` to disable converting English Date to Nepali Date,
* 'nep_to_eng_button_text' => Write text for button for Nepali to English eg: `Nepali to English`,
* 'eng_to_nep_button_text' => Write text for button for Nepali to English eg: `English to Nepali`,
* 'result_format' => You can use any date format for the result display in the front end. See date format here [Formatting Date](https://codex.wordpress.org/Formatting_Date_and_Time). eg: 'D, F j, Y'.
Please note that "S The English suffix for the day of the month" is not supported for version 1.0,
* 'nepali_date_lang' => By default Nepali date language is `nep_char` that means date display like this `शुक्रबार, अशोज ८, २०७२`,
You can also use 'eng_char' to display dates like this `Sukrabar, Ashwin 8, 2072`
* Example shortcodes: `[nepali-date-converter]`, `[nepali-date-converter title="Nepali date"]`, `[nepali-date-converter title="Nepali date" result_format ="l, F j, Y"]`

Please visit [Nepali Date Converter](https://www.addonspress.com/wordpress-plugins/nepali-date-converter/) for more information about another shortcode `[ndc-today-date]` and for all available functions.

== Installation ==

1. Login to the admin panel, Go to Plugins => Add New.
2. Search for "Nepali Date Converter" and install it.
3. Once you install it, activate it
4. Go to Appearance => Widgets, NDC: Nepali Date Converter and NDC: Today Date is waiting for you :) And also available shortcodes and functions.

Or

1. Put the plug-in folder `nepali-date-converter` into [wordpress_dir]/wp-content/plugins/
2. Go into the WordPress admin interface and activate the plugin
3. Go to Appearance => Widgets, NDC: Nepali Date Converter and NDC: Today Date is waiting for you :) And also available shortcodes and functions.

Have fun!!!

== Frequently Asked Questions ==

= What does this plugin do? =

* You can show the Post Date to Nepali
* Convert Nepali Date to English Date and English Date to Nepali Date.
* You can also show either today's Nepali date today, the English date or both.
* Custom functions are available

= What are date formats that I can use with this plugin? =

Please note that "S The English suffix for the day of the month" is not supported for version 1.0. Other than that you can use any date format [Formatting Date](https://codex.wordpress.org/Formatting_Date_and_Time).

= How can I display the Nepali Date Converter or Today Date in any post/page content?  =

You can use the following shortcodes either to display Nepali Date Converter or Today Date anywhere in the posts or pages:

* Use `[nepali-date-converter]` to show Nepali Date Converter
* Use `[ndc-today-date]` to show Today Date

= Are there any functions available in this   =

Yes, you can use the following functions

* ndc_eng_to_nep_date
* ndc_convert_eng_to_nep
* ndc_nep_to_eng_date
* ndc_convert_nep_to_eng

For showing the whole Nepali date converter or today's Nepali date you can use the do_shortcode function

* `echo do_shortcode('[nepali-date-converter]')`
* `echo do_shortcode('[ndc-today-date]')`

= Still have some questions? =

Please use support [support forum](https://wordpress.org/support/plugin/nepali-date-converter/)

== Screenshots ==

1. Nepali Post Date

2. Nepali Date Converter Widget

3. Today's Date Widget

4. Widgets area

5. Nepali Date Converter Widget Frontend

6. Today's Date Widget Frontend

7. Frontend Display form shortcode and widget

== Changelog ==

= 2.0.7 - 2024-06-15 =
* Fixed : [Date issue](https://wordpress.org/support/topic/jestha-32-is-not-showing/)

= 2.0.6 - 2024-04-07 =
* Updated : Tested up WordPress 6.5

= 2.0.5 - 2022-02-25 =
* Fixed: Post Date Array notice in some cases

= 2.0.4 - 2022-02-04 =
* Updated: WordPress version

= 2.0.3 - 2022-01-05 =
* Added: Post Type Support

= 2.0.2 - 2021-04-21 =
* Updated: WordPress version

= 2.0.1 - 2020-06-11 =
* Added: New Feature => Nepali Human Time Diff
* Updated: NDC_Nepali_Calendar

= 2.0.0 - 2020-06-10 =
* Added: New Feature => Show Post Date to Nepali
* Updated: Code Review
* Updated: Prefix

= 1.0.1 - 2020-05-03 =
* Updated: Latest version test
* Added: Contributor

= 1.0 =
Initial version