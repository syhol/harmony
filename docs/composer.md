# Composer

Composer in harmony sits in the functions directory. Composer is used to autoload the /functions/psr-0 directory, so make sure that composer is install if you are planning to use this feature. 

The composer path can be changed setting the VENDOR_PATH before harmony loads, set the VENDOR_PATH to the directory where composer install its packages to, harmony will look in this directory for an autoload.php file.

After harmony loades the composer autoload.php file, the action 'composer_loaded' is fired off, if any modules or code segments rely on a composer package, make sure to load it on or after this event.

##### The composer's vendor directory must not be version controlled!