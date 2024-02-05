# WP AJAX Plugin README

## Overview
This is a simple AJAX example for WordPress using a custom plugin called `WP AJAX Plugin`. It demonstrates how to create an AJAX endpoint and handle form submissions with nonces for security purposes.

## Installation
To install this plugin, follow these steps:

1. Create a new directory named "wp-ajax-plugin" within the plugins folder of your WordPress installation.
2. Copy all files from the provided code into the newly created directory.
3. Activate the plugin through the WordPress Admin Dashboard > Plugins page.

## Usage
After activating the plugin, navigate to **Settings** -> **My AJAX Plugin**. Here, users can enter their names and submit them via AJAX.

The plugin includes a JavaScript file that handles the AJAX requests. This file enqueues the necessary dependencies and localizes variables such as the AJAX URL.

## Features
* Simple AJAX functionality for handling form submission
* Nonce verification for added security
* Customizable user interface
* Handles both logged-in and not-logged-in users

## Limitations
* Limited error checking on client side
* No database storage for submitted data
* Not optimized for performance or scalability

## Contribution
Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or pull request on GitHub at https://github.com/zendyani/wp-ajax-plugin.

## License
This project is licensed under the MIT license - see the LICENSE file for details.