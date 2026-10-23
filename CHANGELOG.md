# Changelog

<a name="2.2.3"></a>
## [2.2.3](https://github.com/maicol07/flarum_sso_wp_plugin/compare/2.2.2...2.2.3)

> Released on October 23, 2026

### ♻️ Code Refactoring

- [`5924dd2`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/5924dd270946c7675e8b28d9995174ff2e589b5b) ♻️ apply rector rules

### 👷 Building scripts changes

- [`b9a061e`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/b9a061e8e753ff4af67dea492c94cce4fb103719) 🔧 add rector targeting the composer PHP floor

### 👷 CI changes

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/82a4ad08b4e9c8f582d5cab31574c6289fd5591c"><code>82a4ad0</code></a> 🚀 remove label commenter workflow and configuration</summary>

  > - Eliminated the label commenter GitHub Actions workflow and its configuration file as they are no longer needed.

  </details>
- [`7f6c81e`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/7f6c81e808ee13900503883fcc989ecfe63b0f7a) 👷 add git-cliff changelog generation

### Other changes

- [`87997d2`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/87997d2ca8e26d422f5b845920f24d518e1cee5a) **deps:** Updated dependencies

<a name="2.2.2"></a>
## [2.2.2](https://github.com/maicol07/flarum_sso_wp_plugin/compare/2.2.1...2.2.2)

> Released on May 23, 2026

### 📝 Docs changes

- [`9704842`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/97048422a973fb78755e56fedadd64429174f942) Docs: 📖 update README requirements and stable tag

### 👷 Building scripts changes

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/8c68725c972018a677d77e361f3ffbe13e183e1c"><code>8c68725</code></a> 🔧 remove unused dependency &quot;eastwest&#x2F;json&quot; from composer.json</summary>

  > - This change cleans up the dependency list by removing an unused package.
  > - Helps to reduce potential security vulnerabilities and improve project maintainability.

  </details>

### 👷 CI changes

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/a8baa998047f6949a86edc167fe8cdcf4291a692"><code>a8baa99</code></a> 🚀 add GitHub Actions workflow for WordPress plugin deployment</summary>

  > - Set up a CI workflow to automate deployment to WordPress.org upon release.
  > - Includes steps for checking out the code, setting up PHP and Node.js, installing dependencies, and running the release build.

  </details>
- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/791c43367bf8bb2ea49cbb28fd01ae0f6c552fa6"><code>791c433</code></a> 🚀 update WP-CLI installation step in deployment workflow</summary>

  > - Changed the installation step to download WP-CLI directly from the official source.
  > - This ensures the latest version is used and simplifies the setup process.

  </details>
- [`f809048`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/f809048a1a84df9521e2e3d4c38e94a9d212f990) 🚀 update SLUG in deployment configuration for consistency
- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/bc69fae723bb6c7ff617c3823ad4f26b6744eb64"><code>bc69fae</code></a> 🚀 update actions&#x2F;checkout and actions&#x2F;setup-node to latest versions</summary>

  > - Upgraded actions/checkout from v4 to v6 for improved performance and features.
  > - Upgraded actions/setup-node from v4 to v6 to ensure compatibility with Node.js 20.

  </details>
- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/2be885a68b17ac8dbf99af3d91b234edd72c07e8"><code>2be885a</code></a> 🚀 update SVN credentials in deployment configuration</summary>

  > - Changed SVN_USERNAME and SVN_PASSWORD environment variables for consistency
  > - Ensures correct access to the SVN repository during deployment

  </details>
- [`47e1163`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/47e116351aeb60a9b89c62b9ad5e795d61d1cd59) 🚀 update SLUG in deployment configuration for consistency

### Other changes

- [`6d5d5b3`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/6d5d5b3813b3a6f180abed150ca412e0c0b485b8) 🔧 bump version to 2.2.2
- [`d5917f4`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/d5917f46078e175f3a9ce38761a3fab421927103) 🔧 update .gitignore to remove composer.lock and yarn.lock

<a name="2.2.1"></a>
## [2.2.1](https://github.com/maicol07/flarum_sso_wp_plugin/compare/2.2...2.2.1)

> Released on May 23, 2021

### 🐛 Bug Fixes

- [`350c20b`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/350c20bdc00828aceb4153add3c47ed27f51e8e6) 🐛 Composer autoloader not found
- [`dbe730d`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/dbe730de8591be64cb5c6e012282c81a6e0b5520) 🐛 Verify SSL exception when CA cert path is empty

### 👷 Building scripts changes

- [`ddb0a10`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/ddb0a10cc4d1ac23bbf84d5d20925d3803fb5d8a) Fixed script
- [`24c1508`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/24c1508044b18688b94986e286bd5c8154206202) Fixed script
- [`37ef072`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/37ef0723507c399ea2e59c08db040fadbc36c82f) 💚 Added more exclusions to build script

### Other changes

- [`527bb60`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/527bb6088e8903ebaa89821c0429f41da6721f28) 🔥 Removed composer auto installer

<a name="2.2"></a>
## [2.2](https://github.com/maicol07/flarum_sso_wp_plugin/compare/2.1.1...2.2)

> Released on May 22, 2021

### ✨ Features

- [`f945e8e`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/f945e8e934feb5c9cb53a7d7821791d5cd597b56) ✨ Added option to toggle avatars auto sync
- [`eed78c9`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/eed78c9696e6b92c6151f56cb70d79420a227acf) ✨ Auto composer installer

### 🐛 Bug Fixes

- [`b5df91b`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/b5df91b1496eceb161b1b994220f6aa691e5639b) 🐛 Fixed user image always set to gravatar default
- [`9f50ade`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/9f50ade87294144c54d36d958b3b3f7de095f3fa) Return a previously triggered error during login
- [`efc4f4c`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/efc4f4cc94eabed9735217c32236cb2ced7e6d0b) Use SSL cert path when trying to verify SSL

### 👷 Building scripts changes

- [`cd5336a`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/cd5336a51cdca65e65f842c6fc98c081f1f96803) 💚 Updated build script

### Other changes

- [`7de1874`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/7de1874771b10a659ef4161f62d3902e66996382) **meta:** Change project type to wordpress plugin
- [`866562d`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/866562d4d0b56acc916f9a5e6b2443a049969cc8) **build:** 💚 Improved build scripts
- [`0558df5`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/0558df5265eef6fcbeaa38c54b5f2199e9ce69ad) **lang:** 🌐 Updated POT

<a name="2.1.1"></a>
## [2.1.1](https://github.com/maicol07/flarum_sso_wp_plugin/compare/2.1...2.1.1)

> Released on April 10, 2021

### 🐛 Bug Fixes

- [`f59e6ff`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/f59e6ff60d1b065e732a65b62d46900c6f57d593) 🐛 Exception when deleting users from the WP dashboard

### 👷 Building scripts changes

- [`8389102`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/83891028dadc04ce98bc4cf94ad8a1198ea72ba2) 👷 Updated build script

### Other changes

- [`5093d45`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/5093d452da1e780c89a4d633d154a43737ee7532) **release:** 2.1.1

<a name="2.1"></a>
## [2.1](https://github.com/maicol07/flarum_sso_wp_plugin/compare/2.0...2.1)

> Released on April 09, 2021

### ✨ Features

- [`cb95a58`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/cb95a583d0a9b945861a6670481bce6855a76c62) ✨ 👽 Updated code to Flarum beta16 and PHP plugin v3

### 🐛 Bug Fixes

- [`e4a53fc`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/e4a53fcc6a750ad57401630480add0e2126965f7) Fatal error when disabling plugin (FSSOE-16)

### 💄 UI & Style

- [`08a4c58`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/08a4c588f39afdc26028eca5cf0254bf34cacd19) 🎨 Improved PHPDoc format

### 👷 Building scripts changes

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/d76e569503e4abffa848e842140b9c6833375beb"><code>d76e569</code></a> Updated gulp script</summary>

  > - Removed deprecated gulp clean

  </details>
- [`70ba765`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/70ba7655bb1e3d449a765107654e2bf4882f94f1) 👷 Improved build scripts

### Other changes

- [`0327ba1`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/0327ba18df6736314cdfa1bb0c2af84d204e08a7) Load Bulma CSS locally
- [`95aed91`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/95aed913edd08cc543ed1994d648f1a7aefa3865) Do not include docs and development packages
- [`74d5c67`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/74d5c67019f81ac0249493c6b265273a0d54713a) Do not include docs and development packages
- [`700d7ae`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/700d7aee81d22c8f4f4de3d64036e2c6433f7dd3) Removed lifetime option
- [`c2bf954`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/c2bf9549b47798f74d878521d5c82ec6a4db573b) **release:** 🔖 2.1

<a name="2.0"></a>
## [2.0](https://github.com/maicol07/flarum_sso_wp_plugin/compare/1.2...2.0)

> Released on November 02, 2020

### ✨ Features

- [`330624a`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/330624a4b4fc53959ea66444bb5ce415049ff58d) ✨ Added compatibility with PHP plugin v2
- [`420fdcb`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/420fdcb450e365ec3c4d658c6396d5da96a44f33) ✨ Added auto update
- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/344bfebd354ef30b9105dfea920e3a925ce8fa1b"><code>344bfeb</code></a> Addons compatibility and utilities</summary>

  > - Added utils.php with the register fields function
  > - Added some filters on Flarum and Flarum User objects

  </details>
- [`1ac360f`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/1ac360f4ca342ce15ccd8ff2e88390b4d1ac8c57) Update option when a new update changes them

### 🐛 Bug Fixes

- [`d84117d`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/d84117db458dae5a2f42e42a81a84b864d053b54) Exception on login
- [`f12d68e`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/f12d68e3f2fd03a72b6084ceb0ec5e2274116c5e) Latest commit throwing an error
- [`f5ec464`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/f5ec4644ac4c44d4bd527b77f0250303770390e3) Fixed setting ID
- [`fe48c88`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/fe48c88ef4e8f9219c00c616d0c1aa8c9e6d5e04) Links not showing in plugin meta (Plugins page)

### ♻️ Code Refactoring

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/ce6d0e2b882093ff9540e8aa035d4b0c319ae27a"><code>ce6d0e2</code></a> ♻️ Refactor code</summary>

  > - PHP 7.2 required

  </details>
- [`ebad6ad`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/ebad6ad3c331896d6625f487169332e8bb37e1c0) ♻️ Refactored public files
- [`e1440f6`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/e1440f6a36d588dd5a8abbd039e8f9c567df6e43) 🚚 Moved some functions to their own context
- [`97cd928`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/97cd928b5a2e576c6db1a3504f9a66c62de724a8) ♻️ WordPress Coding Standards Refactor

### 📝 Docs changes

- [`1835986`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/1835986cc8941826a590e05b37868560a0d3ba9c) Updated screenshot
- [`83a1d2c`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/83a1d2cfa514533fe877eedd885edd7773604d63) Added changelog to README
- [`a7dddf3`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/a7dddf35c65acb5eadd0ab7f5cf1f275c4440f31) Fixed README link
- [`75ee068`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/75ee0683e061cf1b774f378e062d61fc5e3492ee) Update README.txt

### 👷 Building scripts changes

- [`acfd13a`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/acfd13abcf4bbd95cbbc987038f7cf3948015261) Changed var to const
- [`9400690`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/94006901afbd5f0d88e221c4e72173cda456c612) Using WP Cli as a phar

### Other changes

- [`c0a01fc`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/c0a01fc7bf8f95f88c19793eb97d689a4aad2373) **deps:** ⬆️ Upgrade dependencies
- [`ea286af`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/ea286af97354f05aa574765f0a602bc7c07c7a58) Removed version from package.json
- [`f9ea520`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/f9ea5203547712655eb45f0253328abe233175e5) 🙈 Added .gitignore
- [`9e71c24`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/9e71c24332ffed09ee90b5579a891b3889b97673) Removed old pro
- [`43eb2f6`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/43eb2f61203be0c68ddd03d417267c1f92c952c1) 🙈 Updated .gitignore
- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/012f15c3a51e2e3368a14c8e946cc9fc4bee3982"><code>012f15c</code></a> Major settings overhaul</summary>

  > - style: 💄 New settings page design
  > - chore: Detached plugin settings from addons ones

  </details>
- [`7c2a730`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/7c2a730676130425a3fc935d9bbf9318fc5d1de2) ✨ Added action to add CSS and JS to WP Frontend
- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/d2eec4f6b511e6a410eaef918bf0ae17a4191c0a"><code>d2eec4f</code></a> Added more user details on update</summary>

  > - fix: Can't update email [#FSSOE-12](https://tracker.maicol07.it/issue/FSSOE-12)

  </details>
- [`78e519f`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/78e519fb8eb0eeb11bc20a6909b86e88019c78f0) Updated options to latest PHP plugin changes
- [`8bcea16`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/8bcea16892c5d552e26131f2d577e3be4c2f8b1f) Get user data before login
- [`3090994`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/3090994b6c52d2bba566fbd9d1db159d8bf7d425) Updated screenshot
- [`e88172c`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/e88172ce1e8a2b83a0d7982d4f725b053208e5ef) 💬 Minor texts update
- [`c7d29c5`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/c7d29c52a163c939708d652498b36546a09546e6) Added support for JWT addon
- [`0a7ebbc`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/0a7ebbc9ccf7e94ecc68445804fba91fd56dd3d0) Added support for ADDON status text
- [`6bc8a78`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/6bc8a78c206b648ce3c758c44066f1b522287b2e) Check if required options are set
- [`b8d37e5`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/b8d37e5be642165f4c5c2bd800d75f512819a228) Fix links
- [`9aeacec`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/9aeacec598fcec79bcb19af0e854314b812fadb2) Pin PHP plugin to ^1
- [`84ee63c`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/84ee63ce99557dc8d929bed81840579d0da949a4) Pin PHP plugin to ^2
- [`c2e0e67`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/c2e0e6753d54c29bdca8af574a3f18a47effa526) **locale:** Updated pot file

<a name="1.2"></a>
## [1.2](https://github.com/maicol07/flarum_sso_wp_plugin/compare/1.1.2...1.2)

> Released on April 22, 2020

### ✨ Features

- [`7998ca3`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/7998ca3a178cc5663e951454384b6e5bd15f3760) Disable setting groups to admins

### 🐛 Bug Fixes

- [`1d449f7`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/1d449f71ebb12a22f193ee7e42a3f9db89c4870b) Removing PRO key don't deactivate PRO features

<a name="1.1"></a>
## [1.1](https://github.com/maicol07/flarum_sso_wp_plugin/compare/1.0...1.1)

> Released on April 20, 2020

### ✨ Features

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/e3c504d1515f2f74b7a8be4be38ec9dbbf026047"><code>e3c504d</code></a> Password reset</summary>

  > Includes general code style reformat and some  fixes for the pro login feature

  </details>

### Other changes

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/2b9b6703792be5ddc487cc40ed01372e142d250d"><code>2b9b670</code></a> Slug rename</summary>

  > Plugin slug has been renamed to sso-flarum.
  > Naming conventions from now on:
  > - Files: prefix-flarum-sso-suffix.ext
  > - Options names, ids or function names: prefix_flarum_sso_plugin_suffix
  > - Slugs, text domain and other slug-related strings: sso-flarum with eventually a prefix, suffix or extension

  </details>
- [`0f34fe0`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/0f34fe0edff8eb4cf7a6323193ab01af60a70cc8) Fixed critical rename error
- [`de18b36`](https://github.com/maicol07/flarum_sso_wp_plugin/commit/de18b36b08dc644b3e374cd7a8e5cdd5e712de97) Silenced error on login form

<a name="1.0"></a>
## 1.0

> Released on April 08, 2020

### Other changes

- <details><summary><a href="https://github.com/maicol07/flarum_sso_wp_plugin/commit/c1ce4127279a828743420b6230b6352e150876d7"><code>c1ce412</code></a> Release 1.0</summary>

  > - Completely new WordPress plugin!
  > - Settings page
  > - PRO features (read more on docs)
  > - In the nearby future will be published in the WordPress Plugins Directory!

  </details>

