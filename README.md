# wp-single-install

Run all your Wordpress sites on 1 code base. Got 6 sites with 6 databases and 6 different directory locations? Like this:

* wordpress-blog/
* ecommerce-store/
* sisters-diary-blog/
* husbands-autoblog/

With these explanations you can run all these Wordpress installations from 1 directory.

* wordpress/
    - configs/
        - wordpress-blog.php
        - ecommerce-store.php
        - sisters-diary-blog.php
        - husbands-autoblog.php
    - wp-config.php

## Here is how

1. Replace the standard wp-config.php file with the one that comes with this project.
2. Create a "configs" directory under the root directory of the site installation.

## Setup sites

1. Assign each site a code. It can be anything that can be a filename.
2. Create an environment variable for that site in its web server configuration file.

http://httpd.apache.org/docs/2.4/env.html

There you can find how to create environment variables for Apache at that link. Create one for each
site. Then under the "configs/" directory create a PHP file with that code.

Example: site with code "code-here-1" would be set in Apache as

SetEnv SITE_CODE code-here-1

And the file under "configs/" would be "code-here-1.php".

Then you can put in the Wordpress configs for that site in that config file.

You can leave out these lines here.

```php
if (!defined('ABSPATH'))
    define('ABSPATH', __DIR__ . '/');

require_once(ABSPATH . 'wp-settings.php');
```

However the code will ignore them if you leave them in there.
