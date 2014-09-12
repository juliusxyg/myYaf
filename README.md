myYaf
=====

learning yaf

composer(.phar) install --prefer-dist

deprecated: php vendor/bin/doctrine orm:convert-mapping --from-database php application/library/

这个东西还真是麻烦，实体有了namespace就会创建一个对应的新目录，所以目标路径要写Entity目录所在的folder
php vendor/bin/doctrine orm:generate-entities --no-backup application/library/

php vendor/bin/doctrine orm:schema-tool:create --dump-sql
