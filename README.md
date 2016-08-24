# myplugins
* Contributors: bobbingwide
* Donate link: http://www.oik-plugins.com/oik/oik-donate/
* Tags: oik-wp,command
* Requires at least: 4.6
* Tested up to: 4.6
* Stable tag: 0.0.0
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description 
Sample routine to run under oik-wp.php

## Installation 
1. Install the pre-requisite plugins: oik-wp and oik.
1. Clone myplugins to your wp-content\plugins directory
1. Change directory to the myplugins folder
1. Run `oikwp myplugins.php [plugin_list]` 

where 
* oikwp is your command to run oik-wp.php
* plugin_list is a comma separated list of plugin slugs
* If you omit the plugin_list parameter a default set is chosen: @bobbingwide's plugins on wordpress.org

```
cd wp-content\plugins\myplugins 
oikwp myplugins.php akismet,jetpack

```

Expected output
```
oik-wp running WordPress 4.6
C:\apache\htdocs\wordpress\wp-content\plugins\myplugins
cli
Shifting argv
There are: 2
akismet,51194511,3.1.11,4.5.3,3.2
jetpack,27768343,4.2.2,4.6,4.5
Script required once: myplugins.php
Did: run_myplugins.php

```



[](http://www.oik-plugins.com/oik-plugins/oik-batch)



## Upgrade Notice 

# 0.0.0
Tested with WordPress 4.6. 

# 0.0.0 
New plugin, also available from GitHub and oik-plugins.

## Changelog 

# 0.0.0 
* Added: New plugin - available from GitHub

