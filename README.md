myYaf
=====

learning yaf

==install composer===

curl -sS https://getcomposer.org/installer | php

mv composer.phar /usr/local/bin/composer

==run composer====

composer(.phar) install --prefer-dist

==integrate doctrime===

deprecated: php vendor/bin/doctrine orm:convert-mapping --from-database php library/

这个东西还真是麻烦，实体有了namespace就会创建一个对应的新目录，所以目标路径要写Entity目录所在的folder

php vendor/bin/doctrine orm:generate-entities --no-backup library/

php vendor/bin/doctrine orm:schema-tool:create --dump-sql

php vendor/bin/doctrine orm:schema-tool:update --dump-sql

==use command line======

php app/yaf yaf:helloworld xiaoming [--upper]
