=== Nepali Date Converter ===
Contributors: addonspress, acmeit, codersantosh
Donate link: https://www.addonspress.com/
Tags: Nepali post date, Nepali date converter, today Nepali date, English to Nepali date converter, Nepali to English date converter
Requires at least: 4.9
Tested up to: 6.7
Requires PHP: 7.2
Stable tag: 3.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

Convert English dates to Nepali and vice versa, including WordPress post dates. Includes widgets, shortcodes, and custom functions.

== Description ==
Nepali Date Converter makes converting dates between English (Gregorian) and Nepali (Bikram Sambat) formats easy. Whether you're building a Nepali-language WordPress site or just need to display today’s Nepali date, this plugin has you covered.

For the best experience with Nepali Date Converter, check out the free [CosmosWP](https://wordpress.org/themes/cosmoswp/) theme. 
[View Demo](https://demo.cosmoswp.com/demo-99/) → See Nepali Date Converter in action with real-world implementations.

Includes:
- Post Date to Nepali conversion
- Today’s Nepali date display
- Nepali human time differences (e.g., "३ सेकेन्ड अगाडि")
- Shortcodes and widgets
- Custom functions for developers

Fully rewritten for version 3.0.0, this release modernizes the plugin from the ground up, improves accuracy, and ensures better compatibility.

== Key Features ==

* 🔁 Convert English ↔ Nepali dates
* 🗓️ Show Nepali date for post publish dates
* ⏳ Nepali human time differences (e.g., ३ मिनेट अगाडि)
* 🧩 Widgets: Date Converter and Today’s Date
* 🧪 Shortcodes: `[nepali-date-converter]`, `[ndc-today-date]`
* 🔧 Developer functions: `ndc_eng_to_nep_date`, `ndc_nep_to_eng_date`, and more
* 📅 Supports Bikram Sambat years 2000 to 2099 BS
* 🔒 Security improvements and code hardening

== Installation ==

**Automatic Installation:**
1. Go to Plugins → Add New
2. Search for "Nepali Date Converter"
3. Click Install and then Activate

**Manual Installation:**
1. Upload the `nepali-date-converter` folder to `/wp-content/plugins/`
2. Activate via the Plugins menu

After activation:
- Go to Appearance → Widgets to use NDC widgets
- Use shortcodes in posts/pages as needed
- To enable Nepali Post Date, go to Settings → General and scroll to the bottom

== Shortcodes ==

### 1. `[nepali-date-converter]`
Display a Nepali date converter form.

**Attributes:**
- `title`: Custom title (default: Nepali Date Converter)
- `result_format`: Format for output (e.g., `l, F j, Y`)
- `disable_ndc_convert_eng_to_nep`: `1` to disable English to Nepali conversion
- `disable_ndc_convert_nep_to_eng`: `1` to disable Nepali to English conversion
- `nepali_date_lang`: `nep_char` (e.g., `शुक्रबार, अशोज ८, २०७२`) or `eng_char`

**Examples:**
```
[nepali-date-converter]
[nepali-date-converter title="Nepali Date"]
[nepali-date-converter title="Nepali date" result_format="l, F j, Y"]
```

### 2. `[ndc-today-date]`
Displays today’s Nepali date.

== Widgets ==

- **NDC: Nepali Date Converter** – Date converter widget
- **NDC: Today Date** – Show today’s Nepali date

== Developer Functions ==

- `ndc_eng_to_nep_date()` – Convert English to Nepali
- `ndc_convert_eng_to_nep()` – Convert using formatted string
- `ndc_nep_to_eng_date()` – Convert Nepali to English
- `ndc_convert_nep_to_eng()` – Convert using formatted string

Use in code:
echo do_shortcode('[nepali-date-converter]');
echo do_shortcode('[ndc-today-date]');
```
Please visit [Nepali Date Converter](https://www.addonspress.com/wordpress-plugins/nepali-date-converter/) for more information about another shortcode [ndc-today-date] and for all available functions.

== Frequently Asked Questions ==

= What’s new in version 3.0.0? =
- Full plugin rewrite using modern PHP practices
- Deprecated functions removed
- Date conversion engine improved
- Date range supported: 2000 BS to 2099 BS
- Minimum PHP version now required: 7.2+
- Security improvements

= Can I show post publish dates in Nepali? =
Yes, enable it from Settings → General (scroll to the bottom).

= Can I use this in theme or plugin development? =
Absolutely. Use the helper functions or shortcodes as needed.

== Screenshots ==

1. Post date in Nepali
2. Date converter widget (backend)
3. Today’s date widget (backend)
4. Widget settings
5. Date converter frontend
6. Today’s date frontend
7. Combined output via shortcode

== Changelog ==

= 3.0.2 - 2025-03-29 =
* Fixed: Ensured 0 hour is correctly handled in date formatting
* Fixed: Added checks to prevent fatal errors from themes passing invalid date formats

= 3.0.1 - 2025-03-29 =
* Fixed: Few translation issue

= 3.0.0 - 2025-03-28 =
* Rewrite: Complete plugin rewrite with modern codebase
* Removed: Deprecated and legacy functions
* Improved: Date conversion logic and accuracy
* Supported: Dates from 2000 to 2099 BS
* Security: Code hardening and data sanitization
* Requirement: PHP 7.2+ minimum

= 2.0.8 - 2024-10-31 =
* Added: WordPress latest compatibility
* Added: Language folder

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
