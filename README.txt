=== Flarum SSO WP Plugin ===
Contributors: maicol07
Donate link: https://paypal.me/maicol072001/10eur
Tags: flarum, sso, extension, plguin, php, authentication, forum, auth
Requires at least: 4.4
Tested up to: 5.4
Stable tag: 4.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin for your WordPress website to get the Flarum SSO extension working

== Description ==
Plugin for your WordPress website to get the Flarum SSO extension working

## Other requirements
- [Flarum SSO Extension](https://github.com/maicol07/flarum-ext-sso) installed on your Flarum
- JSON and CURL extensions installed on PHP

## Pre-installation

You need to create a random token (40 characters, you can use [this tool](https://onlinerandomtools.com/generate-random-string) to make one)
and put it into the `api_keys` table of your Flarum database.
You only need to set the `key` column and the `user_id` one. In the first one write your new generated token and in the latter your admin user id.

## Pro Features
There are some pro features in this plugin that can only be used with a pro subscription. You can view plans [here](https://docs.maicol07.it/docs/en/flarum_sso/plugin/pro)
### Integrations
- This plugin integrates with the Membership plugin, allowing to sync user role in Flarum


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
You can check the [documentation](https://docs.maicol07.it/docs/en/flarum_sso/plugin/introduction) first.
If that didn't help, you can open a discussion on the [community](https://community.maicol07.it) in the relevant category.

== Changelog ==
= 1.1 =
#### ➕ New Features
- ❗️ Update user username, email or password on Flarum (check API documentation)
- Set user groups on signup
- ❗️ Plugin has been renamed, so follow the [upgrade](https://docs.maicol07.it/docs/en/flarum_sso/plugin/upgrade) instructions.
- Memberpress Integration: change password, forgot password links now redirects to WP
- Finally available in the WordPress Plugin Directory
#### ⭐️ Improvements
- Code style improvements
- Updated dependencies
#### 🐛 Fixes
- ❗️ Fixed the `not_authenticated` error (https://discuss.flarum.org/d/21666-single-sign-on-sso-with-wordpress-integration/157)
- Fixed logout on Flarum (see [#FSSOE-1](https://bugs.maicol07.it/issue/FSSOE-1))
- Other fixes

= 1.0 =
- All the new features in PHP plugin
- New settings page
- Paid PRO features (read more on Docs, link below)
- Memberpress plugin integration (PRO FEATURE)

== Upgrade Notice ==
= 1.1 =
New features, several major fixes

= 1.0 =
New features
