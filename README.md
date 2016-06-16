#Symfony playground

An Uvinum project to play around Symfony framework.

For now, let's use the built-in server Symfony provide us using: `bin/console server:run`

We have a test DB (sqlite) on `/app/test_db.db3`. This app is configured to use this DB as the default one,
so when you use the Doctrine DBAL (it exists as a predefined service, and you have an example repository
using it on `/src/AppBundle/TestRepository.php`) this will be the default database.

You can create a connection to the Database using your IDE, so you can easily create new tables and
insert test data. Since the database is single phisical file, you can version it too.

The first time you execute a `composer install` your own parameters.yml will be created based on
parameters.yml.dist values.

Go & play. ;-)
