# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress plugin called "Version List" that collects software version information from WordPress installations and sends it to an external API. The plugin is developed by vonAffenfels and is designed to track WordPress versions, installed plugins, PHP information, and custom data.

## Development Commands

### Testing
- `composer test` - Runs phpcs code style checks
- `phpcs` - Direct code style checking (configured in composer.json)

### Dependencies
- `composer install` - Install PHP dependencies (primarily Guzzle HTTP client)
- `composer update` - Update dependencies

## Architecture

### Main Entry Point
- `wp-plugin-version-list.php` - WordPress plugin header file that initializes the Plugin class

### Core Classes (PSR-4 autoloaded under `VersionList\` namespace)
- **Plugin** (`src/Plugin.php`) - Main plugin initialization, handles WordPress hooks and REST API endpoints
- **APIConnector** (`src/APIConnector.php`) - Manages API communication using cURL, handles token refresh
- **InformationCollector** (`src/InformationCollector.php`) - Collects system information (WordPress version, plugins, PHP info)
- **SettingsPage** (`src/SettingsPage.php`) - WordPress admin interface for configuration

### Key Features
- **REST API Endpoint**: `GET /wp-json/version_list/v1/send` - Triggers information collection and API transmission
- **Admin Settings Page**: Configuration for API URL, Entry ID, and JWT Token
- **Custom Filter Hook**: `vaf_version_list_add_information` - Allows other plugins to add custom version data
- **Manual Trigger**: Admin button to manually send information to API

### Data Collection
The plugin collects:
- WordPress core version
- All installed plugin versions and slugs
- PHP version and loaded extensions
- Site URL
- Custom information via filter hooks

### API Integration
- Uses cURL for HTTP communication (with 5-second timeouts)
- Sends PUT requests with JWT Bearer authentication
- Automatically refreshes JWT tokens from API responses
- Stores configuration in WordPress options table

### WordPress Integration
- Follows WordPress plugin development standards
- Uses WordPress Settings API for admin interface
- Integrates with WordPress REST API
- Supports internationalization with text domain 'version-list'

## Configuration
The plugin requires three settings configured via the admin interface:
- **Entry ID**: Unique identifier for the WordPress installation
- **JWT Token**: Authentication token for API access
- **API URL**: Endpoint URL for sending version information

Registration for these credentials is done at: https://wp-versions.ape/