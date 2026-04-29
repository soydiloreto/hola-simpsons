=== Hola Simpsons ===
Contributors: pablodiloreto
Donate link: https://pablodiloreto.com/hola-simpsons/
Tags: los-simpsons, the-simpsons, quotes, frases, hola-simpsons
Requires at least: 5.1.2
Tested up to: 6.9.4
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The best quotes from 'The Simpsons' in your WordPress Admin area.


== Description ==

'Hola Simpsons' is a plugin that show quotes from 'Los Simpsons' in your admin area, in spanish. For each refresh, you will find at the top of the admin-area a quote from any character in the series.

Now with iconic quotes from the original English, Spain (es_ES), Brazilian Portuguese (pt_BR) and Italian (it_IT) dubs of the show, in addition to the original Latin American Spanish dub. The plugin auto-selects the right set based on the user's WordPress locale (e.g. en_GB → English, pt_PT → Brazilian Portuguese, es_AR/es_MX → LATAM Spanish). Languages without a curated set fall back to LATAM Spanish.

== Installation ==

The normal plugin install process applies, that is search for 'Hola Simpsons' from your plugin screen or via the manual method:

1. Upload the 'Hola Simpsons' folder into your '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress

That's it! 'Hola Simpsons' will appear with quotes in your admin area.

== Frequently Asked Questions ==

= Does this plugin host information in the local WordPress database? =

No. Currently the plugin does not host information in the database. We have plans that do so in future versions.

= Can I add new quotes or remove the ones I don't like? =

No. Currently these actions cannot be performed. We have plans that you can customize quotes in future versions.

= In which languages will the quotes be displayed? =

The plugin auto-selects the quote set based on your WordPress user locale. Currently supported sets: Latin American Spanish (default and fallback), European Spanish (es_ES), Brazilian Portuguese (pt_BR), Italian (it_IT) and original English (en_US). Variants like en_GB or pt_PT fall back to en_US and pt_BR respectively. Locales with no curated set fall back to LATAM Spanish.

= Does this plugin connect to any external web service? =

Not right now. We have plans to do it in future versions, to obtain updated quotes without the need for changes in the code.

= I love it, how can I show my appreciation? =

If you have been impressed with this plugin and would like to somehow show some appreciation, rather than send a donation my way, please donate to your charity of choice. I will never ask for any form of reward or compensation. Helping others achieve their goals is satisfying for me :)

== Screenshots ==
 
1. Example quote from the plugin, in the admin area.


== Upgrade Notice ==

= 1.3.2 =
* Added iconic quotes in 4 additional dubs (English, Spain, Brazilian Portuguese, Italian) with automatic locale-based selection.

= 1.3 =
* New classic quotes from 'The Simpsons' added.
* Compatibility verified with the latest WordPress versions.
* Minor improvements and readme fixes.

= 1.2.4 =
* Compatibility with WP 5.6.1 checked. No functional changes.

= 1.2.3 =
* Bug in Author URL. Done.

= 1.2.2 =
* Compatibility with WP 5.4
* Changes in minimal requirements (now, it requires WP 5.1.2).
* New quotes!

= 1.2.1 =
Minor corrections for configuration files.

= 1.2 =
WordPress automatic update testing.

= 1.1 =
WordPress SVN upgrade testing.

= 1.0 =
Initial source code.

== Changelog ==

= 1.3.2 (2026-04-28) =
* Added iconic quote sets from the original English, European Spanish, Brazilian Portuguese, and Italian dubs of The Simpsons.
* New locale-aware quote selection: the plugin picks the quote set based on the user's WordPress locale, with fallback by language family (e.g. en_GB → en_US, pt_PT → pt_BR) and a final fallback to Latin American Spanish.
* Refactored quote storage and selection into dedicated functions; output uses the proper `lang` attribute when the quote language differs from the user's UI language.

= 1.3.1 (2026-04-28) =
* Typo fix in screenshot caption ("quota" → "quote").

= 1.3 (2026-04-22) =
* Added several new classic quotes from 'The Simpsons'.
* Compatibility verified with the latest WordPress versions.
* Added "Requires PHP" header.
* Added proper text-domain to translatable strings.
* Minor typo corrections in the changelog.

= 1.2.4 =
* Compatibility with WP 5.6.1 checked. No functional changes.

= 1.2.3 (2020-04-05) =
* Bug in Author URL. Done.

= 1.2.2 (2020-04-05) =
* Compatibility with WP 5.4
* Changes in minimal requirements (now, it requires WP 5.1.2).
* New quotes!

= 1.2.1 (2020-02-11) =
* Minor corrections for readme.txt and plugin headers. Nothing functional.
* We will not continue playing :-).

= 1.2 (2020-02-10) =
* Just testing automatic update from WordPress Plugins section.

= 1.1 (2020-02-10) =
* Just testing new version in WordPress SVN.

= 1.0 (2020-02-10) =
* Initial source code. Part of the code is from 'Hello Dolly' (a great) plugin.
* Bump tested WordPress version to 5.3.2