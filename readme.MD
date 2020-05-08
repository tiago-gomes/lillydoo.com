# Notes
- Trying Domain Driven Design with a 3 Layered Architecture, Using DDD Building Blocks and Codeception for Acceptance Tests.
- A tier is a server a layer is a layer containing for example Domain Model Layer, Presentation Layer, etc...!
# Layered Architecture
![alt text](https://www.techopedia.com/images/uploads/3b108f50042e4c398169ec3fa43d9b94.png)

# Benefits of a Layered Architecture
- The maintenance of your application is easier because of the low coupling between layers.
- Adding more functionality to your application is made easier.
- Layers make your application more testable.
- Building a well formed layers makes the orientation in your application more easier.
- Having your application not layered means that you have to deal with all security threats in one place which is very difficult. Having your application distributed to layers makes it much easier for design and implement
- Without a good deployment plan it is not trivial to distribute your layers over multiple physical tiers in distributed computing. You need to plan ahead your layers when you create a distributed application.

# Domain Driven Design Building Blocks

# Application Service
The Application Service encapsulates logic that does not fit the business model rules, such as:
- AuthService
- ProxyService

- # Controller
The Controller acts as a bridge between Application Services and Domain Models.

# Entity
The entity mostly contains the business logic.

# Domain Model
The Domain Model Encapsulates the business logic of the specified domain.

# Domain Repository
The Domain Repository should contain operations to the Database, it is by nature database agnostic.

# Value object
 — an immutable object that describes some characteristic or attribute but carries no concept of identity. Sometimes in one context something is an entity while in another it is just a value object.

# Docker Commands
- docker exec -i symfony_composer composer update
- docker exec -i symfony_app php bin/console
- composer dump-autoload

# Installation
- git clone ...
- docker-compose up -d --build
- docker exec -i symfony_composer composer update
- docker exec -i symfony_app php ./bin/console doctrine:database:create --env=dev
- docker exec -i symfony_app php ./bin/console doctrine:database:create --env=prod
- docker exec -i symfony_app php ./bin/console doctrine:database:create --env=test
- docker exec -i symfony_app php ./bin/console doctrine:migrations:migrate

# Find database differences
- docker exec -i symfony_app php ./bin/console doctrine:migrations:diff

# Seeding commands
- docker exec -i symfony_app php ./bin/console seeder:db --env=dev
- docker exec -i symfony_app php ./bin/console seeder:db --env=test

# Composer commands
 docker exec -i symfony_composer composer require codeception/codeception --dev

# error log
sentry.io to monitor the container

# Queue
- bin/console rabbitmq:consumer emailing

# Message Broker
A message broker preforms asynchronous request to 3rd party providers, such as: email, upload of files,  

# testing
- codeception

# Continuous Integration.
- to decide how to do it.

# Issues
- Password field must be hidden.
- Seeders are necessary.
