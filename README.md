news_site
=========
Installation:
1. git clone
2. composer install
3. php bin/console doctrine:database:create
4. php bin/console doctrine:schema:update --force
5. php bin/console doctrine:fixtures:load