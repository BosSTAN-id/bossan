BosSTAN
===================

Aplikasi Pengelolaan dana Bantuan Operasional Sekolah
-------------------
Aplikasi ini adalah aplikasi Pengelolaan dana Bantuan Operasional Sekolah untuk Sekolah. Repositori ini berisi Community Version dari aplikasi bosstan yang dikembangkan oleh [bosstan.id](https://bosstan.id) dan dapat digunakan secara bebas dengan perizinan dari kami.

Silahkan hubungi heru@belajararief.com untuk dapat menggunakan aplikasi ini.

Aplikasi ini merupakan aplikasi yang ditujukan untuk penggunaan akademik sehingga tidak dipungut biaya untuk penggunaannya.

Demo:  [Demo](http://showcase.belajararief.com/bossan)

User Diknas : diknas/diknas

user Sekolah: smpn2ba3/smpn2ba3

Database
------------

Restore database yang tersimpan dalam aplikasi ini.

INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Make sure you have fxp-asset-plugin installed. If not, run this following code:
~~~
composer global require "fxp/composer-asset-plugin:~1.3"
~~~

For additional information of fxp-asset-plugin visit this [link](https://github.com/fxpio/composer-asset-plugin/blob/master/Resources/doc/index.md).

You can then install this project template using the following command:

~~~
php composer update
~~~

Then configure your application to connect to database via _protected/config/db.php

Now you should be able to access the application through the following URL

~~~
http://localhost/bossan
~~~
