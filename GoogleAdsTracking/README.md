# Google Ads Tracking Plugin for Shopware 5

Integrate Goolge Ads Conversion Tracking with Google Consent Mode v2 for Shopware 5.

## Features

- Google Consent Mode v2 aware conversion tracking solution
- Fires conversion event at /checkout/finish page 
- Configurable through the Shopware backend

## Installation

1. Upload the plugin files to `custom/plugins/GoogleAdsTracking`
2. Install the plugin through the Plugin Manager in Shopware backend
3. Configure your Google Ads Conversion ID and Conversion Label in the plugin settings
4. Clear the cache and check that Google Ads cookies appear in the cookie manager

## Configuration

- **Google Ads Conversion ID**: Your Google Ads conversion ID (format: AW-XXXXXXXXXX)
- **Google Ads Conversion Label**: Your Google Ads conversion label for purchase tracking

## Cookie Consent

The plugin registers the following cookie for consent:

- `google_consent`

## Requirements

- Shopware 5.7.0 or higher