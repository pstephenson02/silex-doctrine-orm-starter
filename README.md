# silex-doctrine-orm-starter

[Silex](http://silex.sensiolabs.org/) is a PHP micro-framework based on Symfony components. Silex can be a pleasure to work with for developers that enjoy more control over the structure of their applications. However, large projects that use Silex often require more disciplined patterns and sometimes need a full-fledged ORM. While Silex does not officially support [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html), [dflydev-doctrine-orm-service-provider](https://github.com/dflydev/dflydev-doctrine-orm-service-provider) is an excellent extension for which to provide your Silex app with ORM behavior. This project goes a step futher. Silex-doctrine-orm-starter provides examples of extendible patterns and methods that I have found useful in my experience using Silex and Doctrine ORM. A few highlights include:

  - Doctrine ORM annotation mapping
  - Doctrine lifecycle event hooks in the form of a TimestampableEntity trait, and a UserSubscriber
  - A bootstrapped, custom Doctrine cli with an example custom command using the Symfony console component.
  - A test case class that provides easy integration with the doctrine-fixtures library.

The starter also includes some Silex specific goodies:
  - Defining controllers as services
  - Integration with the Silex web debug toolbar (also includes Doctrine DBAL queries)
