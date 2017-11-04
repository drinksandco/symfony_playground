# Symfony playground

An Uvinum project to play around Symfony framework.

For now, let's use the built-in PHP webserver Symfony provide us using: `bin/console server:run`

We've modelled a `User` (Aggregate Root) that can learn new `Skill`s. 

The App implements a CommandBus and Event management. The controllers execute the needed `Command` sending it to the CommandBus, who will match it with its CommandHandler.
 
We have two CommandBus middlewares (`DBTransactionality` and `EventAware`) that will ensure the Commands transactionality, and the Events management (all events generated in the models will be stored during the Command execution, and will be handled / dispatched if the transaction went OK).
 
There are three example implementations for the `User` aggregate repository. One using Doctrine ORM and the Domain Entities (`Playground\App\Infrastructure\Repository\Doctrine\User\UserOrmRepository`), another one using Doctrine ORM and separating Domain Entities from Doctrine Entities (`Playground\App\Infrastructure\Repository\Doctrine\User\UserOrmEntitiesRepository`) and another one using raw DBAL connection (`Playground\App\Infrastructure\Repository\Doctrine\User\UserDbalRepository`). 

In the ORM cases, we don't extend directly from the Doctrine repos. Instead of this, we inject the Doctrine Manager Registry to our repo, so we can decouple from Doctrine's implementation and prevent our app to access all public methods available on Doctrine repos. In this direction, the `UserOrmEntitiesRepository` is a test to see if we could keep our domain entities totally decoupled from Doctrine, even for those properties that "map" other entities as relations (ArrayCollections and so). 

All Doctrine ORM mapping config files will be found on `src/Playground/App/Infrastructure/Repository/Doctrine/_mapping/*.yml`

You can re-create the needed schema (the app is configured to use sqlite, so you don't need to install or run MySQL or any other DB) with the following commands: 
* `bin/console doctrine:database:drop --force` (in order to remove any previous DB in the project)
* `bin/console doctrine:schema:update --force` (in order to create the SQL schema)
 
The first time you execute a `composer install` your own parameters.yml will be created based on
parameters.yml.dist values.

You can use the PHP webserver to run and test the application, executing `bin/console server:start`

Go & play. ;-)
