TOPS Library
================
Description
----------------
TOPS is a library of helper classes that may be used with PHP and JavaScript applications, 
Symphony 2 or Drupal 7 & 8.

This code is intended for non-commercial use by Friends Meetings and other socially progressive non-profit organizations.
It is released as an open-source project under an MIT/X11 License as detailed in tops_license.html.  This file should be included
on every site where tops components are deployed.


Added to GitHub: https://github.com/tsorelle/tops.core


lib directory:
    Contains Tops custom code and vendor dependencies not included and Drupal 8.
    
core\vendor directory
    
    This folder emulates the core\vendor directory structure of Drupal 8, for the purpose of developing D8 compatible tops routines.
    Download files from the Drupal 8 core and copy the core\vendor directory:
    
    [Drupal Releases](https://www.drupal.org/node/3060/release)
    
    Current version used here is: 8.0.0-beta6
    
    In PHPStorm the phpunit.phar file must be the same version as the phpunit shipped in Drupal core.
    Currently 4.4.*, see core\composer.json

assets\js\bower directory
    Contains bower JavaScript dependency managment components.
    
