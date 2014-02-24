fbGraph
=======

A Plugin for moziloCMS 2.0

Reads the facebook graph and returns specific information.

## Installation
#### With moziloCMS installer
To add (or update) a plugin in moziloCMS, go to the backend tab *Plugins* and click the item *Manage Plugins*. Here you can choose the plugin archive file (note that it has to be a ZIP file with exactly the same name the plugin has) and click *Install*. Now the fbGraph plugin is listed below and can be activated.

#### Manually
Installing a plugin manually requires FTP Access. 
- Upload unpacked plugin folder into moziloCMS plugin directory: ```/<moziloroot>/plugins/```
- Set default permissions (chmod 777 for folders and 666 for files)
- Go to the backend tab *Plugins* and activate the now listed new fbGraph plugin

## Syntax
```{fbGraph|<id>|<tag>|<after>}```
Insert information from facebook graph.

1. Parameter ```<id>```: Facebook ID of facebook profile or page - can be numeric or page name
2. Parameter ```<tag>```: Information to get from facebook graph. Possible values are: ```about```, ```category```, ```company_overview```, ```founded```, ```description```, ```is_published```, ```talking_about_count```, ```username```, ```website```, ```were_here_count```, ```id```, ```name```, ```link``` and ```likes```
3. Parameter ```<after>```: Text to display after information output.

## License
This Plugin is distributed under *GNU General Public License, Version 3* (see LICENSE).

## Documentation
A detailed documentation and demo can be found on DEVMOUNT's website:
http://devmount.de/Develop/Mozilo%20Plugins/fbGraph.html
