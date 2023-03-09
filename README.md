# pjc - PHP Jquery Chat

Client and server side library of simple functions in plain PHP and JQUERY UI for managing a chat with conversation saved in a postgresql database in real time.

![image](https://user-images.githubusercontent.com/24400013/167026515-bb9f1b25-8cdd-4567-a629-ae82bc6e4eab.png)

Requirements
------------

  * PHP 7.2.9 or higher;
  * pdo_pgsql PHP extension enabled in php.ini;
  * Postgresql standalone OR Docker-compose

Installation
------------

Verify that you have installed, depending on your environment, [docker-compose][1] OR [postgresql][2], [npm][5], [yarn][6], [nodejs][7] and [git][8].

Verify that you have PHP installed : `sudo apt-get install php` on linux or, for windows, use php already included in [xampp][3].
If you have Windows, do not forget to indicate in the environment variable PATH, 
the path to access php.exe (for example, C:\xampp\php).

run these linux commands:

```bash
$ sudo su postgres
$ psql
postgres$ CREATE DATABASE test
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    CONNECTION LIMIT = -1;
postgres$ CREATE USER test WITH
  LOGIN
  NOSUPERUSER
  INHERIT
  NOCREATEDB
  NOCREATEROLE
  NOREPLICATION;
postgres$ ALTER ROLE test with password 'test';
postgres$ ALTER USER test with password 'test';
postgres$ REVOKE ALL ON DATABASE test FROM public;
postgres$ GRANT ALL ON DATABASE test TO test;        
postgres$ exit
$ cd /var/www/html
$ sudo git clone https://github.com/coyote333666/pjp pjp
$ cd pjp
$ psql -f script.sql -U test
(password test)
$ cd ..
$ sudo git clone https://github.com/coyote333666/pjc pjc
$ cd pjc
$ psql -f script.sql -U test
(password test)
```
Install dependancies:

```bash
$ cd /var/www/html
$ sudo git clone https://github.com/dexterpu/jquery.ui.chatbox chatbox
$ sudo yarn add jquery-ui
```

Then access the application in your browser at the given URL (localhost/pjc).

Note
----

If you want to test localy, use two different browser (ex: chrome and apache) to simulate two session.
If you don't want to log chat requests in Apache access.log, modify [access.log][4] :

```bash
<VirtualHost *:80>
  ServerName www.mywebsite.com
  DocumentRoot /home/www/mywebsite
  ...
  SetEnvIf Request_URI "^/piwik(.*)$" dontlog
  CustomLog ${APACHE_LOG_DIR}/other_vhosts_access.log vhost_combined env=!dontlog
</VirtualHost>
```


[1]: https://docs.docker.com/compose/install/
[2]: https://www.postgresql.org/
[3]: https://www.apachefriends.org/index.html
[4]: https://stackoverflow.com/questions/40205569/dont-log-certain-requests-in-apache-access-log
[5]: https://www.npmjs.com/
[6]: https://yarnpkg.com/
[7]: https://nodejs.org/en/
[8]: https://git-scm.com/