# Nepali Date Converter

![License](https://img.shields.io/badge/license-GPLv2%2B-blue.svg)
![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-7.2%2B-blue.svg)

Convert dates between English (Gregorian) and Nepali (Bikram Sambat) formats with widgets, shortcodes, and developer custom functions.

## Description

Nepali Date Converter makes it easy to convert dates between English and Nepali formats directly in WordPress. Whether you're building a Nepali-language site or just need to display today's Nepali date, this plugin provides:

- Post Date to Nepali conversion
- Today's Nepali date display
- Nepali human time differences (e.g., "३ सेकेन्ड अगाडि")
- Shortcodes and widgets for easy implementation
- Developer-friendly functions for custom implementations

Fully rewritten for version 3.0.0, this release modernizes the plugin with improved accuracy and better compatibility.

## Key Features

- 🔁 Convert English ↔ Nepali dates
- 🗓️ Show Nepali date for post publish dates
- ⏳ Nepali human time differences (e.g., "३ मिनेट अगाडि")
- 🧩 Widgets: Date Converter and Today's Date
- 🧪 Shortcodes: `[nepali-date-converter]`, `[ndc-today-date]`
- 🔧 Developer functions for custom implementations
- 📅 Supports Bikram Sambat years 2000 to 2099 BS
- 🔒 Security improvements and code hardening

## Installation

### Automatic Installation

1. Go to Plugins → Add New in your WordPress admin
2. Search for "Nepali Date Converter"
3. Click Install and then Activate

### Manual Installation

1. Upload the `nepali-date-converter` folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins menu

After activation:

- Go to Appearance → Widgets to use NDC widgets
- Use shortcodes in posts/pages as needed
- To enable Nepali Post Date, go to Settings → General and scroll to the bottom

## Shortcodes

### Date Converter

`[nepali-date-converter]` - Display a Nepali date converter form

**Attributes:**

- `title`: Custom title (default: "Nepali Date Converter")
- `result_format`: Output format (e.g., "l, F j, Y")
- `disable_ndc_convert_eng_to_nep`: Set to "1" to disable English to Nepali conversion
- `disable_ndc_convert_nep_to_eng`: Set to "1" to disable Nepali to English conversion
- `nepali_date_lang`: "nep_char" (e.g., "शुक्रबार, अशोज ८, २०७२") or "eng_char"

**Examples:**

```php
[nepali-date-converter]
[nepali-date-converter title="Nepali Date"]
[nepali-date-converter title="Nepali date" result_format="l, F j, Y"]
```

### Today's Date

`[ndc-today-date]` - Displays today's Nepali date

## Widgets

- **NDC: Nepali Date Converter** - Interactive date conversion widget
- **NDC: Today Date** - Displays current Nepali date

## Developer Functions

Use these functions in your theme or custom plugins:

```php
// Convert English to Nepali date
ndc_eng_to_nep_date($year, $month, $day);

// Convert with formatted string
ndc_convert_eng_to_nep($format, $date);

// Convert Nepali to English date
ndc_nep_to_eng_date($year, $month, $day);

// Convert with formatted string
ndc_convert_nep_to_eng($format, $date);
```

## FAQ

### What's new in version 3.0.0?

- Complete plugin rewrite with modern PHP practices
- Improved date conversion engine
- Support for dates from 2000 BS to 2099 BS
- Minimum PHP version requirement: 7.2+
- Security improvements

### Can I show post publish dates in Nepali?

Yes, enable this feature in Settings → General (scroll to the bottom).

### Can I use this in theme/plugin development?

Absolutely! Use the provided helper functions or shortcodes as needed.

## Changelog

### 3.0.0 - 2025-03-28

- Complete plugin rewrite with modern codebase
- Removed deprecated and legacy functions
- Improved date conversion logic and accuracy
- Support for dates from 2000 to 2099 BS
- Code hardening and data sanitization
- PHP 7.2+ minimum requirement

Here's a rewritten version tailored for the Nepali Date Converter project:

## Contributing

Thank you for your interest in contributing to Nepali Date Converter! We welcome contributions from developers of all skill levels. To submit your changes, please follow these steps:

1. **Fork the Repository:** Click the "Fork" button in the top-right corner of the [GitHub repository](https://github.com/codersantosh/nepali-date-converter) to create your copy.

2. **Clone Your Fork:** Clone your forked repository to your local machine:

   ```sh
   git clone https://github.com/your-username/nepali-date-converter.git
   ```

3. **Create a Feature Branch:** Make a new branch for your changes:

   ```sh
   git checkout -b feature/your-feature-name
   ```

4. **Make Your Changes:** Implement your improvements or fixes. Please ensure:

   - Code follows WordPress coding standards
   - Date conversion accuracy is maintained
   - Backward compatibility is preserved

5. **Commit Your Changes:** Commit with a descriptive message:

   ```sh
   git commit -m "Fixed: Issue with date conversion for month X"
   ```

6. **Push to Your Branch:** Upload your changes:

   ```sh
   git push origin feature/your-feature-name
   ```

7. **Submit a Pull Request:** Create a PR from your fork to the main repository with:
   - Clear description of changes
   - Reference to any related issues
   - Screenshots if applicable

We especially welcome contributions for:

- Adding new data range
- Adding new date formats
- Enhancing language support
- Creating better documentation

See the full list of [contributors](https://github.com/codersantosh/nepali-date-converter/graphs/contributors) who have helped improve this plugin.

## License & Attribution

- GPLv2 or later © [Santosh Kunwar](https://twitter.com/codersantosh).

## About Me

<strong>I just love WordPress more…</strong>

- [![CoderSantosh on Twitter](https://img.shields.io/twitter/follow/codersantosh.svg)](https://twitter.com/codersantosh/)
- <a href="https://profiles.wordpress.org/codersantosh/" target="_blank"><img src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" width="50" height="50" />WordPress Profile</a>

## Related Projects

- [Gutentor](https://www.gutentor.com/)
- [CosmosWP](https://www.cosmoswp.com/)
- [PatternsWP](https://patternswp.com/)
