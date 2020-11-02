=== Flarum SSO WP Plugin ===
Contributors: maicol07
Donate link: https://paypal.me/maicol072001/10eur
Tags: flarum, sso, extension, plugin, php, authentication, forum, auth
Requires at least: 4.4
Tested up to: 5.5.3
Stable tag: 2.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin for your WordPress website to get the Flarum SSO extension working

== Description ==
Plugin for your WordPress website to get the Flarum SSO extension working

## Other requirements
- [Flarum SSO Extension](https://github.com/maicol07/flarum-ext-sso) installed on your Flarum
- JSON and CURL extensions installed on PHP

## Pre-installation

Check the [docs](https://docs.maicol07.it/en/flarum-sso/ext) to know how to get started with the Flarum SSO Extension

## Premium Addons
There are some premium addon you can subscribe to if you want to use them. You can see what they are [here](https://docs.maicol07.it/docs/en/flarum_sso/plugin/pro)
### Integrations
- This plugin integrates with the Memberpress plugin, allowing to sync user role in Flarum


== Installation ==

1. Upload `sso-flarum.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin via the 'Settings' menu in WordPress

== Screenshots ==
1. Plugin configurable settings. You can check their meaning in the docs

== Frequently Asked Questions ==

= How to install? =

Check the Installation tab

= Where can I get help? =
You can check the [documentation](https://docs.maicol07.it/en/flarum-sso/plugins/wordpress) first.
If that didn't help, you can open a discussion on the [community](https://community.maicol07.it) in the relevant category.

== Changelog ==
= 2.0 - The modular update (2020-11-02) =
:boom: Requires PHP 7.2+ and the JSON extension
### :heavy_plus_sign: Added
- All the changes from PHP plugin
- :pencil2: When an user is updated, it will get updated in Flarum too
- :art: New settings page design
- Detached plugin settings from addons ones
- Supported login with email and password [`#FSSOE-11`](https://tracker.maicol07.it/issue/FSSOE-11)

### :star: Improvements
- :memo: Revamped docs

### :hammer_and_wrench: Fixes
- :bug: :envelope: Can't update email [`#FSSOE-12`](https://tracker.maicol07.it/issue/FSSOE-12)
- :rotating_light: Exception on login in some cases [`#FSSOE-10`](https://tracker.maicol07.it/issue/FSSOE-10)

= 1.2 (2020-04-22) =
### :heavy_plus_sign: New Features
- All the new features from the PHP plugin (added option to settings)

### :star: Improvements
- Code style improvements
- Updated dependencies

### :hammer_and_wrench: Fixes
- Fixes from PHP plugin
- Removing PRO key didn't deactivate PRO features
- MEMBERPRESS: Groups weren't deleted if user has no memberships

## 1.1.2 (2020-04-20)
- Changes from PHP Plugin
= 1.1 =
#### ➕ New Features
- ❗️ Update user username, email or password on Flarum (check API documentation)
- Set user groups on signup
- ❗️ Plugin has been renamed, so follow the [upgrade](https://docs.maicol07.it/en/flarum-sso/plugins/wordpress#upgrading) instructions.
- Memberpress Integration: change password, forgot password links now redirects to WP
- Finally available in the WordPress Plugin Directory
#### ⭐️ Improvements
- Code style improvements
- Updated dependencies
#### 🐛 Fixes
- ❗️ Fixed the `not_authenticated` error (https://discuss.flarum.org/d/21666-single-sign-on-sso-with-wordpress-integration/157)
- Fixed logout on Flarum (see [#FSSOE-1](https://tracker.maicol07.it/issue/FSSOE-1))
- Other fixes

= 1.0 =
- All the new features in PHP plugin
- New settings page
- Paid PRO features (read more on Docs, link below)
- Memberpress plugin integration (PRO FEATURE)

== Upgrade Notice ==
= 2.0 =
New features, improvements, new JWT addon, improvements and fixes

= 1.2 =
New features, memberpress addon, improvements and fixes

= 1.1 =
New features, several major fixes

= 1.0 =
New features
