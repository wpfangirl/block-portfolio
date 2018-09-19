# Block-Based Portfolio
Contributors: wpfangirl
Donate link: https://www.wpfangirl.com
Tags: portfolio, gutenberg, custom post types, custom taxonomies
Requires at least: 4.9.8
Tested up to: 4.9.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 0.6

Creates a portfolio post type with 3 custom taxonomies and a Gutenberg block template for single portfolio entries.

## Description

This plugin builds the single portfolio entry from core Gutenberg blocks, arranged in a template to make it easier to create a portfolio of project case studies. Includes two hierarchical taxonomies (project type and client type) and one flat taxonomy (project tag).

Block attributes are now set for heading levels, font sizes in paragraphs, and alignment of images.

## Installation

1. Upload `block-portfolio.zip` via the 'Plugins | Add New |Upload' in the WordPress admin, or unzip the file and upload the `block-portfolio` folder to the `/wp-content/plugins/` directory by FTP or SSH.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. There are no settings for this plugin. Your portfolio entries and portfolio taxonomies will appear in the left admin menu. 

## Screenshots
1. What you see when you add a new portfolio item.
![screenshot of new portfolio item with empty blocks](https://github.com/wpfangirl/block-portfolio/blob/master/assets/screenshot-1.png)

## FAQ
### Is there a UI for choosing, customizing, and saving the blocks in the template?
That would be an amazing feature. Unfortunately, I don't know how to build it. If you do and would like to, let's talk. 

This plugin can be used as-is by an end user who wants to use this format for a portfolio, but it's really designed as a proof of concept and to provide an exampe for developers who want to use block templates in their CPTs.

### Will this plugin be in the WordPress.org repository?
I don't have plans to submit it at this time, but perhaps if I get it polished, or someone helps me build a UI.

## Changelog

= 0.6 =
* Added block attributes for headings and paragraphs.

= 0.5 =
* First functional version, not really ready for prime time but shouldn't blow up anyone's site.