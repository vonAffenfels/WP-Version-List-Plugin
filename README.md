# WordPress Plugin - Software Versions Overview

This WordPress plugin provides an easy way to collect information of the 
software versions used on your website and send the information to our API.

## Installation

### Nativ
1. Download the plugin zip archive.
2. Go to your WordPress dashboard.
3. Navigate to "Plugins" > "Add New."
4. Click on "Upload Plugin" and select the downloaded zip archive.
5. Activate the plugin after installation.

### Composer
1. Add this to the repositories in your composer.json
```json
     {
      "type": "git",
      "url": "git@github.com:vonAffenfels/WP-Version-List-Plugin.git"
     }
```
2. Require it by adding it to your composer.json
```json
    "require": {
        "va/wp-plugin-version-list": "1.0.0",
    }
```
3. Execute "composer update"


## Usage

After activating the plugin, it will automatically add a Settings-Page where you add 
the Entry-ID, JWT Token and API URL. you get the Entry-ID and JWT Token by register the new Instanz 
here: https://wp-versions.ape/. \
After saving the Settings an WP-cronjob will be added, wich sends the collected Information once a 
day to the API.

You can add your own custom Information by calling a Filter. \
e.g.
```php
add_filter('vaf_version_list_add_information', function ($currentCustomInformation) {
    $currentCustomInformation['myInformation'] = 'ver0.0.0';
    return $currentCustomInformation;
});
```

## Features

- Collect Information 
- Send the Information to the API

## Changelog

- **1.0.0** (28.09.2023)
    - Initial release of the plugin.


- **1.0.1** (10.10.2023)
    - remove Blogname from collected Information


- **1.0.2** (11.10.2023)
  - Limit registered Cronjobs to one


- **1.1.0** (30.11.2023)
  - Remove Cron Logic and add custom REST Endpoint
