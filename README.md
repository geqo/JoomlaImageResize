# JoomlaImageResize
ImageResize is a simple **plugin** for creating small copies of an image when it is uploaded by standard media manager and Drag&amp;Drop in editor. Only width available.
## Usage
Install the plugin.
Go to `Extensions -> plugin`, find `Image Resize` and setup.  
All what you need to do - is install and configure just as you like. The ImageResize will do everything itself.  
There are four different versions of images you can configure: small, medium, medium-large and large.  
You can create all thumbnails together or create only what you need.  
You can even just disable the creation of thumbnails when downloading and enable only Drag&amp;Drop.  
Supports the processing and insertion of images into the editor with the Drag&amp;Drop, creates resized image and place in editor instead fullsize.  
#### Download from here
```git clone https://github.com/geqo/JoomlaImageResize.git```   
Don't forget about `composer update` in plugin directory if you use `git clone`.
#### Or you can download it directly
```https://geqo.space/joomla/plg_content_imageresize/updates/latest/plg_content_imageresize.zip```
#### Minimal requirements
PHP 5.6  
Joomla 3.8
#### Joomla 3.6
For Joomla 3.6 select Joomla3.6 branch. Or download latest from
```https://geqo.ru/joomla/plg_content_imageresize/Joomla3.6/latest/plg_content_imageresize.zip```
#### Changelist
23 August 2018, 1.1.2 - forgot about image/jpeg type :) Fixed.  
22 August 2018, 1.2.1 - added developer messages.  
29 August 2018, 1.3.0 - added default 10% compression for JPG, sure if it enabled.  
11 October 2018, 1.4.1 - added PNG to JPG conversion  
30 October 2019, 1.4.2 - critical fix, image cannot be processed if filetype is JPEG  
