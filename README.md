# Indexy

A bootstrapped minimal, light, fast and mobile-friendly script to
make Directory listing on web servers a pleasant experience.

Inspired from [h5ai](http://larsjung.de/h5ai/).

## Features:
* Breadcrumb at the top
* Mobile friendly
* Image previews using [Swipebox](http://brutaldesign.github.io/swipebox/)
* File-sizes in human-readable notations
* Five file-types - Image, Audio, Video, Directory and a generic File;
each type having different glyphicon

If you need more features, you are probably looking for [h5ai](http://larsjung.de/h5ai/).

## Installation:

Requires PHP 5

1. Clone the repository
```
git clone http://github.com/crusador/indexy.git
```
This will clone the repository to `indexy` folder.

2. Copy folder `indexy` to your web server.
Say, you copy it to `/path/to/indexy` with respect to your webroot.

3. Add `/path/to/indexy/index.php` to the end of your webserver's default
index-file list. All directories that don't have a valid index file will
get styled by indexy.

Examples of the last step for

**nginx**: in `nginx.conf`, set for example:
```
index  index.html  index.php  /path/to/indexy/index.php;
```

**apache**: in `httpd.conf` or in any directory's `.htaccess` file, set for example:
```
DirectoryIndex  index.html  index.php  /_h5ai/server/php/index.php
```

---
Copyright 2014 [Jitesh Kamble](http://github.com/crusador)
