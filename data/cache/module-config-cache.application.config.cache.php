<?php
return array (
  'service_manager' => 
  array (
    'factories' => 
    array (
      'Zend\\Mail\\Protocol\\SmtpPluginManager' => 'Zend\\Mail\\Protocol\\SmtpPluginManagerFactory',
      'SerializerAdapterManager' => 'Zend\\Serializer\\AdapterPluginManagerFactory',
      'doctrine.cli' => 'DoctrineModule\\Service\\CliFactory',
      'Doctrine\\ORM\\EntityManager' => 'DoctrineORMModule\\Service\\EntityManagerAliasCompatFactory',
      'Zend\\Cache\\PatternPluginManager' => 'Zend\\Cache\\Service\\PatternPluginManagerFactory',
      'Zend\\Cache\\Storage\\AdapterPluginManager' => 'Zend\\Cache\\Service\\StorageAdapterPluginManagerFactory',
      'Zend\\Cache\\Storage\\PluginManager' => 'Zend\\Cache\\Service\\StoragePluginManagerFactory',
      'Zend\\Paginator\\AdapterPluginManager' => 'Zend\\Paginator\\AdapterPluginManagerFactory',
      'Zend\\Paginator\\ScrollingStylePluginManager' => 'Zend\\Paginator\\ScrollingStylePluginManagerFactory',
      'Zend\\I18n\\Translator\\TranslatorInterface' => 'Zend\\I18n\\Translator\\TranslatorServiceFactory',
      'Zend\\I18n\\Translator\\LoaderPluginManager' => 'Zend\\I18n\\Translator\\LoaderPluginManagerFactory',
      'Zend\\InputFilter\\InputFilterPluginManager' => 'Zend\\InputFilter\\InputFilterPluginManagerFactory',
      'Zend\\Filter\\FilterPluginManager' => 'Zend\\Filter\\FilterPluginManagerFactory',
      'Zend\\Hydrator\\HydratorPluginManager' => 'Zend\\Hydrator\\HydratorPluginManagerFactory',
      'Zend\\Session\\Config\\ConfigInterface' => 'Zend\\Session\\Service\\SessionConfigFactory',
      'Zend\\Session\\ManagerInterface' => 'Zend\\Session\\Service\\SessionManagerFactory',
      'Zend\\Session\\Storage\\StorageInterface' => 'Zend\\Session\\Service\\StorageFactory',
      'FormAnnotationBuilder' => 'Zend\\Form\\Annotation\\AnnotationBuilderFactory',
      'FormElementManager' => 'Zend\\Form\\FormElementManagerFactory',
      'Zend\\Router\\Http\\TreeRouteStack' => 'Zend\\Router\\Http\\HttpRouterFactory',
      'Zend\\Router\\RoutePluginManager' => 'Zend\\Router\\RoutePluginManagerFactory',
      'Zend\\Router\\RouteStackInterface' => 'Zend\\Router\\RouterFactory',
      'Zend\\Validator\\ValidatorPluginManager' => 'Zend\\Validator\\ValidatorPluginManagerFactory',
      'TCPDF' => 'TCPDFModule\\Factory\\TCPDFFactory',
      'Application\\Service\\NavManager' => 'Application\\Service\\Factory\\NavManagerFactory',
      'Application\\Service\\RbacAssertionManager' => 'Application\\Service\\Factory\\RbacAssertionManagerFactory',
      'Zend\\Authentication\\AuthenticationService' => 'User\\Service\\Factory\\AuthenticationServiceFactory',
      'User\\Service\\AuthAdapter' => 'User\\Service\\Factory\\AuthAdapterFactory',
      'User\\Service\\AuthManager' => 'User\\Service\\Factory\\AuthManagerFactory',
      'User\\Service\\PermissionManager' => 'User\\Service\\Factory\\PermissionManagerFactory',
      'User\\Service\\RbacManager' => 'User\\Service\\Factory\\RbacManagerFactory',
      'User\\Service\\RoleManager' => 'User\\Service\\Factory\\RoleManagerFactory',
      'User\\Service\\UserManager' => 'User\\Service\\Factory\\UserManagerFactory',
      'Anneescolaire\\Service\\AnneescolaireManager' => 'Anneescolaire\\Service\\Factory\\AnneescolaireManagerFactory',
      'Eleve\\Service\\EleveManager' => 'Eleve\\Service\\Factory\\EleveManagerFactory',
      'Eleve\\Service\\ImageManager' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Salle\\Service\\SalleManager' => 'Salle\\Service\\Factory\\SalleManagerFactory',
      'Ecole\\Service\\EcoleManager' => 'Ecole\\Service\\Factory\\EcoleManagerFactory',
      'Matiere\\Service\\MatiereManager' => 'Matiere\\Service\\Factory\\MatiereManagerFactory',
      'Classe\\Service\\ClasseManager' => 'Classe\\Service\\Factory\\ClasseManagerFactory',
      'Periodeval\\Service\\PeriodevalManager' => 'Periodeval\\Service\\Factory\\PeriodevalManagerFactory',
      'Evaluation\\Service\\EvaluationManager' => 'Evaluation\\Service\\Factory\\EvaluationManagerFactory',
      'Test\\Service\\LivreManager' => 'Test\\Service\\Factory\\LivreManagerFactory',
      'Test\\Service\\PersonneManager' => 'Test\\Service\\Factory\\PersonneManagerFactory',
    ),
    'invokables' => 
    array (
      'DoctrineModule\\Authentication\\Storage\\Session' => 'Zend\\Authentication\\Storage\\Session',
      'doctrine.dbal_cmd.runsql' => 'Doctrine\\DBAL\\Tools\\Console\\Command\\RunSqlCommand',
      'doctrine.dbal_cmd.import' => 'Doctrine\\DBAL\\Tools\\Console\\Command\\ImportCommand',
      'doctrine.orm_cmd.clear_cache_metadata' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\MetadataCommand',
      'doctrine.orm_cmd.clear_cache_result' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\ResultCommand',
      'doctrine.orm_cmd.clear_cache_query' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ClearCache\\QueryCommand',
      'doctrine.orm_cmd.schema_tool_create' => 'Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\CreateCommand',
      'doctrine.orm_cmd.schema_tool_update' => 'Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\UpdateCommand',
      'doctrine.orm_cmd.schema_tool_drop' => 'Doctrine\\ORM\\Tools\\Console\\Command\\SchemaTool\\DropCommand',
      'doctrine.orm_cmd.convert_d1_schema' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ConvertDoctrine1SchemaCommand',
      'doctrine.orm_cmd.generate_entities' => 'Doctrine\\ORM\\Tools\\Console\\Command\\GenerateEntitiesCommand',
      'doctrine.orm_cmd.generate_proxies' => 'Doctrine\\ORM\\Tools\\Console\\Command\\GenerateProxiesCommand',
      'doctrine.orm_cmd.convert_mapping' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ConvertMappingCommand',
      'doctrine.orm_cmd.run_dql' => 'Doctrine\\ORM\\Tools\\Console\\Command\\RunDqlCommand',
      'doctrine.orm_cmd.validate_schema' => 'Doctrine\\ORM\\Tools\\Console\\Command\\ValidateSchemaCommand',
      'doctrine.orm_cmd.info' => 'Doctrine\\ORM\\Tools\\Console\\Command\\InfoCommand',
      'doctrine.orm_cmd.ensure_production_settings' => 'Doctrine\\ORM\\Tools\\Console\\Command\\EnsureProductionSettingsCommand',
      'doctrine.orm_cmd.generate_repositories' => 'Doctrine\\ORM\\Tools\\Console\\Command\\GenerateRepositoriesCommand',
    ),
    'abstract_factories' => 
    array (
      'DoctrineModule' => 'DoctrineModule\\ServiceFactory\\AbstractDoctrineServiceFactory',
      0 => 'Zend\\Cache\\Service\\StorageCacheAbstractServiceFactory',
      1 => 'Zend\\Session\\Service\\ContainerAbstractServiceFactory',
      2 => 'Zend\\Form\\FormAbstractServiceFactory',
    ),
    'aliases' => 
    array (
      'TranslatorPluginManager' => 'Zend\\I18n\\Translator\\LoaderPluginManager',
      'InputFilterManager' => 'Zend\\InputFilter\\InputFilterPluginManager',
      'FilterManager' => 'Zend\\Filter\\FilterPluginManager',
      'HydratorManager' => 'Zend\\Hydrator\\HydratorPluginManager',
      'Zend\\Session\\SessionManager' => 'Zend\\Session\\ManagerInterface',
      'Zend\\Form\\Annotation\\FormAnnotationBuilder' => 'FormAnnotationBuilder',
      'Zend\\Form\\Annotation\\AnnotationBuilder' => 'FormAnnotationBuilder',
      'Zend\\Form\\FormElementManager' => 'FormElementManager',
      'HttpRouter' => 'Zend\\Router\\Http\\TreeRouteStack',
      'router' => 'Zend\\Router\\RouteStackInterface',
      'Router' => 'Zend\\Router\\RouteStackInterface',
      'RoutePluginManager' => 'Zend\\Router\\RoutePluginManager',
      'ValidatorManager' => 'Zend\\Validator\\ValidatorPluginManager',
    ),
    'shared' => 
    array (
      'TCPDF' => false,
    ),
  ),
  'doctrine' => 
  array (
    'cache' => 
    array (
      'apc' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ApcCache',
        'namespace' => 'DoctrineModule',
      ),
      'apcu' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ApcuCache',
        'namespace' => 'DoctrineModule',
      ),
      'array' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ArrayCache',
        'namespace' => 'DoctrineModule',
      ),
      'filesystem' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
        'directory' => 'data/DoctrineModule/cache',
        'namespace' => 'DoctrineModule',
      ),
      'memcache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
        'instance' => 'my_memcache_alias',
        'namespace' => 'DoctrineModule',
      ),
      'memcached' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
        'instance' => 'my_memcached_alias',
        'namespace' => 'DoctrineModule',
      ),
      'predis' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\PredisCache',
        'instance' => 'my_predis_alias',
        'namespace' => 'DoctrineModule',
      ),
      'redis' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\RedisCache',
        'instance' => 'my_redis_alias',
        'namespace' => 'DoctrineModule',
      ),
      'wincache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
        'namespace' => 'DoctrineModule',
      ),
      'xcache' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\XcacheCache',
        'namespace' => 'DoctrineModule',
      ),
      'zenddata' => 
      array (
        'class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
        'namespace' => 'DoctrineModule',
      ),
    ),
    'authentication' => 
    array (
      'odm_default' => 
      array (
      ),
      'orm_default' => 
      array (
        'objectManager' => 'doctrine.entitymanager.orm_default',
      ),
    ),
    'authenticationadapter' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'authenticationstorage' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'authenticationservice' => 
    array (
      'odm_default' => true,
      'orm_default' => true,
    ),
    'connection' => 
    array (
      'orm_default' => 
      array (
        'configuration' => 'orm_default',
        'eventmanager' => 'orm_default',
        'params' => 
        array (
          'host' => 'localhost',
          'port' => '3306',
          'user' => 'username',
          'password' => 'password',
          'dbname' => 'database',
        ),
      ),
    ),
    'configuration' => 
    array (
      'orm_default' => 
      array (
        'metadata_cache' => 'array',
        'query_cache' => 'array',
        'result_cache' => 'array',
        'hydration_cache' => 'array',
        'driver' => 'orm_default',
        'generate_proxies' => true,
        'proxy_dir' => 'data/DoctrineORMModule/Proxy',
        'proxy_namespace' => 'DoctrineORMModule\\Proxy',
        'filters' => 
        array (
        ),
        'datetime_functions' => 
        array (
        ),
        'string_functions' => 
        array (
        ),
        'numeric_functions' => 
        array (
        ),
        'second_level_cache' => 
        array (
        ),
      ),
    ),
    'driver' => 
    array (
      'orm_default' => 
      array (
        'class' => 'Doctrine\\Common\\Persistence\\Mapping\\Driver\\MappingDriverChain',
        'drivers' => 
        array (
          'User\\Entity' => 'User_driver',
          'Anneescolaire\\Entity' => 'Anneescolaire_driver',
          'Eleve\\Entity' => 'Eleve_driver',
          'Salle\\Entity' => 'Salle_driver',
          'Ecole\\Entity' => 'Ecole_driver',
          'Matiere\\Entity' => 'Matiere_driver',
          'Classe\\Entity' => 'Classe_driver',
          'Periodeval\\Entity' => 'Periodeval_driver',
          'Evaluation\\Entity' => 'Evaluation_driver',
          'Test\\Entity' => 'Test_driver',
        ),
      ),
      'User_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\User\\config/../src/Entity',
        ),
      ),
      'Anneescolaire_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Anneescolaire\\config/../src/Entity',
        ),
      ),
      'Eleve_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Eleve\\config/../src/Entity',
        ),
      ),
      'Salle_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Salle\\config/../src/Entity',
        ),
      ),
      'Ecole_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Ecole\\config/../src/Entity',
        ),
      ),
      'Matiere_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Matiere\\config/../src/Entity',
        ),
      ),
      'Classe_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Classe\\config/../src/Entity',
        ),
      ),
      'Periodeval_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Periodeval\\config/../src/Entity',
        ),
      ),
      'Evaluation_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Evaluation\\config/../src/Entity',
        ),
      ),
      'Test_driver' => 
      array (
        'class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
        'cache' => 'array',
        'paths' => 
        array (
          0 => 'C:\\wamp64\\www\\softnote\\module\\Test\\config/../src/Entity',
        ),
      ),
    ),
    'entitymanager' => 
    array (
      'orm_default' => 
      array (
        'connection' => 'orm_default',
        'configuration' => 'orm_default',
      ),
    ),
    'eventmanager' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'sql_logger_collector' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'mapping_collector' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'formannotationbuilder' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'entity_resolver' => 
    array (
      'orm_default' => 
      array (
      ),
    ),
    'migrations_configuration' => 
    array (
      'orm_default' => 
      array (
        'directory' => 'data/Migrations',
        'name' => 'Doctrine Database Migrations',
        'namespace' => 'Migrations',
        'table' => 'migrations',
        'column' => 'version',
      ),
    ),
    'migrations_cmd' => 
    array (
      'generate' => 
      array (
      ),
      'execute' => 
      array (
      ),
      'migrate' => 
      array (
      ),
      'status' => 
      array (
      ),
      'version' => 
      array (
      ),
      'diff' => 
      array (
      ),
      'latest' => 
      array (
      ),
    ),
  ),
  'doctrine_factories' => 
  array (
    'cache' => 'DoctrineModule\\Service\\CacheFactory',
    'eventmanager' => 'DoctrineModule\\Service\\EventManagerFactory',
    'driver' => 'DoctrineModule\\Service\\DriverFactory',
    'authenticationadapter' => 'DoctrineModule\\Service\\Authentication\\AdapterFactory',
    'authenticationstorage' => 'DoctrineModule\\Service\\Authentication\\StorageFactory',
    'authenticationservice' => 'DoctrineModule\\Service\\Authentication\\AuthenticationServiceFactory',
    'connection' => 'DoctrineORMModule\\Service\\DBALConnectionFactory',
    'configuration' => 'DoctrineORMModule\\Service\\ConfigurationFactory',
    'entitymanager' => 'DoctrineORMModule\\Service\\EntityManagerFactory',
    'entity_resolver' => 'DoctrineORMModule\\Service\\EntityResolverFactory',
    'sql_logger_collector' => 'DoctrineORMModule\\Service\\SQLLoggerCollectorFactory',
    'mapping_collector' => 'DoctrineORMModule\\Service\\MappingCollectorFactory',
    'formannotationbuilder' => 'DoctrineORMModule\\Service\\FormAnnotationBuilderFactory',
    'migrations_configuration' => 'DoctrineORMModule\\Service\\MigrationsConfigurationFactory',
    'migrations_cmd' => 'DoctrineORMModule\\Service\\MigrationsCommandFactory',
  ),
  'controllers' => 
  array (
    'factories' => 
    array (
      'DoctrineModule\\Controller\\Cli' => 'DoctrineModule\\Service\\CliControllerFactory',
      'Application\\Controller\\IndexController' => 'Application\\Controller\\Factory\\IndexControllerFactory',
      'User\\Controller\\AuthController' => 'User\\Controller\\Factory\\AuthControllerFactory',
      'User\\Controller\\PermissionController' => 'User\\Controller\\Factory\\PermissionControllerFactory',
      'User\\Controller\\RoleController' => 'User\\Controller\\Factory\\RoleControllerFactory',
      'User\\Controller\\UserController' => 'User\\Controller\\Factory\\UserControllerFactory',
      'Anneescolaire\\Controller\\AnneescolaireController' => 'Anneescolaire\\Controller\\Factory\\AnneescolaireControllerFactory',
      'Eleve\\Controller\\EleveController' => 'Eleve\\Controller\\Factory\\EleveControllerFactory',
      'Salle\\Controller\\SalleController' => 'Salle\\Controller\\Factory\\SalleControllerFactory',
      'Ecole\\Controller\\EcoleController' => 'Ecole\\Controller\\Factory\\EcoleControllerFactory',
      'Matiere\\Controller\\MatiereController' => 'Matiere\\Controller\\Factory\\MatiereControllerFactory',
      'Classe\\Controller\\ClasseController' => 'Classe\\Controller\\Factory\\ClasseControllerFactory',
      'Periodeval\\Controller\\PeriodevalController' => 'Periodeval\\Controller\\Factory\\PeriodevalControllerFactory',
      'Evaluation\\Controller\\EvaluationController' => 'Evaluation\\Controller\\Factory\\EvaluationControllerFactory',
      'Test\\Controller\\TestController' => 'Test\\Controller\\Factory\\TestControllerFactory',
    ),
  ),
  'route_manager' => 
  array (
    'factories' => 
    array (
      'symfony_cli' => 'DoctrineModule\\Service\\SymfonyCliRouteFactory',
    ),
  ),
  'console' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'doctrine_cli' => 
        array (
          'type' => 'symfony_cli',
        ),
      ),
    ),
  ),
  'form_elements' => 
  array (
    'aliases' => 
    array (
      'objectselect' => 'DoctrineModule\\Form\\Element\\ObjectSelect',
      'objectradio' => 'DoctrineModule\\Form\\Element\\ObjectRadio',
      'objectmulticheckbox' => 'DoctrineModule\\Form\\Element\\ObjectMultiCheckbox',
    ),
    'factories' => 
    array (
      'DoctrineModule\\Form\\Element\\ObjectSelect' => 'DoctrineORMModule\\Service\\ObjectSelectFactory',
      'DoctrineModule\\Form\\Element\\ObjectRadio' => 'DoctrineORMModule\\Service\\ObjectRadioFactory',
      'DoctrineModule\\Form\\Element\\ObjectMultiCheckbox' => 'DoctrineORMModule\\Service\\ObjectMultiCheckboxFactory',
    ),
  ),
  'hydrators' => 
  array (
    'factories' => 
    array (
      'DoctrineModule\\Stdlib\\Hydrator\\DoctrineObject' => 'DoctrineORMModule\\Service\\DoctrineObjectHydratorFactory',
    ),
  ),
  'router' => 
  array (
    'routes' => 
    array (
      'doctrine_orm_module_yuml' => 
      array (
        'type' => 'literal',
        'options' => 
        array (
          'route' => '/ocra_service_manager_yuml',
          'defaults' => 
          array (
            'controller' => 'DoctrineORMModule\\Yuml\\YumlController',
            'action' => 'index',
          ),
        ),
      ),
      'home' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\IndexController',
            'action' => 'index',
          ),
        ),
      ),
      'application' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/application[/:action[/:id]]',
          'constraints' => 
          array (
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
          ),
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\IndexController',
            'action' => 'index',
          ),
        ),
      ),
      'about' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/about',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\IndexController',
            'action' => 'about',
          ),
        ),
      ),
      'contact' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/contact',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\IndexController',
            'action' => 'contact',
          ),
        ),
      ),
      'login' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/login',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\AuthController',
            'action' => 'login',
          ),
        ),
      ),
      'logout' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/logout',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\AuthController',
            'action' => 'logout',
          ),
        ),
      ),
      'not-authorized' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/not-authorized',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\AuthController',
            'action' => 'notAuthorized',
          ),
        ),
      ),
      'reset-password' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/reset-password',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\UserController',
            'action' => 'resetPassword',
          ),
        ),
      ),
      'set-password' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/set-password',
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\UserController',
            'action' => 'setPassword',
          ),
        ),
      ),
      'users' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/users[/:action[/:id]]',
          'constraints' => 
          array (
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[a-zA-Z0-9_-]*',
          ),
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\UserController',
            'action' => 'index',
          ),
        ),
      ),
      'roles' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/roles[/:action[/:id]]',
          'constraints' => 
          array (
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]*',
          ),
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\RoleController',
            'action' => 'index',
          ),
        ),
      ),
      'permissions' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/permissions[/:action[/:id]]',
          'constraints' => 
          array (
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]*',
          ),
          'defaults' => 
          array (
            'controller' => 'User\\Controller\\PermissionController',
            'action' => 'index',
          ),
        ),
      ),
      'anneescolaire' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/anneescolaire[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Anneescolaire\\Controller\\AnneescolaireController',
            'action' => 'index',
          ),
        ),
      ),
      'eleve' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/eleve[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Eleve\\Controller\\EleveController',
            'action' => 'index',
          ),
        ),
      ),
      'salle' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/salle[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Salle\\Controller\\SalleController',
            'action' => 'index',
          ),
        ),
      ),
      'ecole' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/ecole[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Ecole\\Controller\\EcoleController',
            'action' => 'index',
          ),
        ),
      ),
      'matiere' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/matiere[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Matiere\\Controller\\MatiereController',
            'action' => 'index',
          ),
        ),
      ),
      'classe' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/classe[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Classe\\Controller\\ClasseController',
            'action' => 'index',
          ),
        ),
      ),
      'periodeval' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/periodeval[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Periodeval\\Controller\\PeriodevalController',
            'action' => 'index',
          ),
        ),
      ),
      'evaluation' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/evaluation[/:action][/:id][/:classe][/:periode][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Evaluation\\Controller\\EvaluationController',
            'action' => 'index',
          ),
        ),
      ),
      'palmares' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/palmares',
          'defaults' => 
          array (
            'controller' => 'Evaluation\\Controller\\EvaluationController',
            'action' => 'palmares',
          ),
        ),
      ),
      'palmaresnotes' => 
      array (
        'type' => 'Zend\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/palmaresnotes',
          'defaults' => 
          array (
            'controller' => 'Evaluation\\Controller\\EvaluationController',
            'action' => 'palmaresnotes',
          ),
        ),
      ),
      'test' => 
      array (
        'type' => 'Zend\\Router\\Http\\Segment',
        'options' => 
        array (
          'route' => '/test[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
          'constraints' => 
          array (
            'action' => '(?!\\bpage\\b)(?!\\border_by\\b)(?!\\bsearch_by\\b)[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
            'page' => '[0-9]+',
            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'order' => 'ASC|DESC',
          ),
          'defaults' => 
          array (
            'controller' => 'Test\\Controller\\TestController',
            'action' => 'index',
          ),
        ),
      ),
    ),
  ),
  'view_manager' => 
  array (
    'template_map' => 
    array (
      'zend-developer-tools/toolbar/doctrine-orm-queries' => 'C:\\wamp64\\www\\softnote\\vendor\\doctrine\\doctrine-orm-module\\config/../view/zend-developer-tools/toolbar/doctrine-orm-queries.phtml',
      'zend-developer-tools/toolbar/doctrine-orm-mappings' => 'C:\\wamp64\\www\\softnote\\vendor\\doctrine\\doctrine-orm-module\\config/../view/zend-developer-tools/toolbar/doctrine-orm-mappings.phtml',
      'layout/layout' => 'C:\\wamp64\\www\\softnote\\module\\Application\\config/../view/layout/layout.phtml',
      'application/index/index' => 'C:\\wamp64\\www\\softnote\\module\\Application\\config/../view/application/index/index.phtml',
      'error/404' => 'C:\\wamp64\\www\\softnote\\module\\Application\\config/../view/error/404.phtml',
      'error/index' => 'C:\\wamp64\\www\\softnote\\module\\Application\\config/../view/error/index.phtml',
    ),
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
    'template_path_stack' => 
    array (
      0 => 'C:\\wamp64\\www\\softnote\\module\\Application\\config/../view',
      1 => 'C:\\wamp64\\www\\softnote\\module\\User\\config/../view',
      2 => 'C:\\wamp64\\www\\softnote\\module\\Anneescolaire\\config/../view',
      3 => 'C:\\wamp64\\www\\softnote\\module\\Eleve\\config/../view',
      4 => 'C:\\wamp64\\www\\softnote\\module\\Salle\\config/../view',
      5 => 'C:\\wamp64\\www\\softnote\\module\\Ecole\\config/../view',
      6 => 'C:\\wamp64\\www\\softnote\\module\\Matiere\\config/../view',
      7 => 'C:\\wamp64\\www\\softnote\\module\\Classe\\config/../view',
      8 => 'C:\\wamp64\\www\\softnote\\module\\Periodeval\\config/../view',
      9 => 'C:\\wamp64\\www\\softnote\\module\\Evaluation\\config/../view',
      10 => 'C:\\wamp64\\www\\softnote\\module\\Test\\config/../view',
    ),
    'strategies' => 
    array (
      0 => 'ViewJsonStrategy',
      1 => 'ViewJsonStrategy',
      2 => 'ViewJsonStrategy',
      3 => 'ViewJsonStrategy',
      4 => 'ViewJsonStrategy',
      5 => 'ViewJsonStrategy',
      6 => 'ViewJsonStrategy',
      7 => 'ViewJsonStrategy',
      8 => 'ViewJsonStrategy',
    ),
  ),
  'zenddevelopertools' => 
  array (
    'profiler' => 
    array (
      'collectors' => 
      array (
        'doctrine.sql_logger_collector.orm_default' => 'doctrine.sql_logger_collector.orm_default',
        'doctrine.mapping_collector.orm_default' => 'doctrine.mapping_collector.orm_default',
      ),
    ),
    'toolbar' => 
    array (
      'entries' => 
      array (
        'doctrine.sql_logger_collector.orm_default' => 'zend-developer-tools/toolbar/doctrine-orm-queries',
        'doctrine.mapping_collector.orm_default' => 'zend-developer-tools/toolbar/doctrine-orm-mappings',
      ),
    ),
  ),
  'filters' => 
  array (
    'aliases' => 
    array (
      'alnum' => 'Zend\\I18n\\Filter\\Alnum',
      'Alnum' => 'Zend\\I18n\\Filter\\Alnum',
      'alpha' => 'Zend\\I18n\\Filter\\Alpha',
      'Alpha' => 'Zend\\I18n\\Filter\\Alpha',
      'numberformat' => 'Zend\\I18n\\Filter\\NumberFormat',
      'numberFormat' => 'Zend\\I18n\\Filter\\NumberFormat',
      'NumberFormat' => 'Zend\\I18n\\Filter\\NumberFormat',
      'numberparse' => 'Zend\\I18n\\Filter\\NumberParse',
      'numberParse' => 'Zend\\I18n\\Filter\\NumberParse',
      'NumberParse' => 'Zend\\I18n\\Filter\\NumberParse',
    ),
    'factories' => 
    array (
      'Zend\\I18n\\Filter\\Alnum' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Filter\\Alpha' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Filter\\NumberFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Filter\\NumberParse' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
    ),
  ),
  'validators' => 
  array (
    'aliases' => 
    array (
      'alnum' => 'Zend\\I18n\\Validator\\Alnum',
      'Alnum' => 'Zend\\I18n\\Validator\\Alnum',
      'alpha' => 'Zend\\I18n\\Validator\\Alpha',
      'Alpha' => 'Zend\\I18n\\Validator\\Alpha',
      'datetime' => 'Zend\\I18n\\Validator\\DateTime',
      'dateTime' => 'Zend\\I18n\\Validator\\DateTime',
      'DateTime' => 'Zend\\I18n\\Validator\\DateTime',
      'float' => 'Zend\\I18n\\Validator\\IsFloat',
      'Float' => 'Zend\\I18n\\Validator\\IsFloat',
      'int' => 'Zend\\I18n\\Validator\\IsInt',
      'Int' => 'Zend\\I18n\\Validator\\IsInt',
      'isfloat' => 'Zend\\I18n\\Validator\\IsFloat',
      'isFloat' => 'Zend\\I18n\\Validator\\IsFloat',
      'IsFloat' => 'Zend\\I18n\\Validator\\IsFloat',
      'isint' => 'Zend\\I18n\\Validator\\IsInt',
      'isInt' => 'Zend\\I18n\\Validator\\IsInt',
      'IsInt' => 'Zend\\I18n\\Validator\\IsInt',
      'phonenumber' => 'Zend\\I18n\\Validator\\PhoneNumber',
      'phoneNumber' => 'Zend\\I18n\\Validator\\PhoneNumber',
      'PhoneNumber' => 'Zend\\I18n\\Validator\\PhoneNumber',
      'postcode' => 'Zend\\I18n\\Validator\\PostCode',
      'postCode' => 'Zend\\I18n\\Validator\\PostCode',
      'PostCode' => 'Zend\\I18n\\Validator\\PostCode',
    ),
    'factories' => 
    array (
      'Zend\\I18n\\Validator\\Alnum' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\Alpha' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\DateTime' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\IsFloat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\IsInt' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\PhoneNumber' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\Validator\\PostCode' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
    ),
  ),
  'view_helpers' => 
  array (
    'aliases' => 
    array (
      'currencyformat' => 'Zend\\I18n\\View\\Helper\\CurrencyFormat',
      'currencyFormat' => 'Zend\\I18n\\View\\Helper\\CurrencyFormat',
      'CurrencyFormat' => 'Zend\\I18n\\View\\Helper\\CurrencyFormat',
      'dateformat' => 'Zend\\I18n\\View\\Helper\\DateFormat',
      'dateFormat' => 'Zend\\I18n\\View\\Helper\\DateFormat',
      'DateFormat' => 'Zend\\I18n\\View\\Helper\\DateFormat',
      'numberformat' => 'Zend\\I18n\\View\\Helper\\NumberFormat',
      'numberFormat' => 'Zend\\I18n\\View\\Helper\\NumberFormat',
      'NumberFormat' => 'Zend\\I18n\\View\\Helper\\NumberFormat',
      'plural' => 'Zend\\I18n\\View\\Helper\\Plural',
      'Plural' => 'Zend\\I18n\\View\\Helper\\Plural',
      'translate' => 'Zend\\I18n\\View\\Helper\\Translate',
      'Translate' => 'Zend\\I18n\\View\\Helper\\Translate',
      'translateplural' => 'Zend\\I18n\\View\\Helper\\TranslatePlural',
      'translatePlural' => 'Zend\\I18n\\View\\Helper\\TranslatePlural',
      'TranslatePlural' => 'Zend\\I18n\\View\\Helper\\TranslatePlural',
      'flashmessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\View\\Helper\\FlashMessenger',
      'flashMessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\View\\Helper\\FlashMessenger',
      'FlashMessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\View\\Helper\\FlashMessenger',
      'form' => 'Zend\\Form\\View\\Helper\\Form',
      'Form' => 'Zend\\Form\\View\\Helper\\Form',
      'formbutton' => 'Zend\\Form\\View\\Helper\\FormButton',
      'form_button' => 'Zend\\Form\\View\\Helper\\FormButton',
      'formButton' => 'Zend\\Form\\View\\Helper\\FormButton',
      'FormButton' => 'Zend\\Form\\View\\Helper\\FormButton',
      'formcaptcha' => 'Zend\\Form\\View\\Helper\\FormCaptcha',
      'form_captcha' => 'Zend\\Form\\View\\Helper\\FormCaptcha',
      'formCaptcha' => 'Zend\\Form\\View\\Helper\\FormCaptcha',
      'FormCaptcha' => 'Zend\\Form\\View\\Helper\\FormCaptcha',
      'captchadumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'captcha_dumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'captcha/dumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'CaptchaDumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'captchaDumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'formcaptchadumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'form_captcha_dumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'formCaptchaDumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'FormCaptchaDumb' => 'Zend\\Form\\View\\Helper\\Captcha\\Dumb',
      'captchafiglet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'captcha/figlet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'captcha_figlet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'captchaFiglet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'CaptchaFiglet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'formcaptchafiglet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'form_captcha_figlet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'formCaptchaFiglet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'FormCaptchaFiglet' => 'Zend\\Form\\View\\Helper\\Captcha\\Figlet',
      'captchaimage' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'captcha/image' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'captcha_image' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'captchaImage' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'CaptchaImage' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'formcaptchaimage' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'form_captcha_image' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'formCaptchaImage' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'FormCaptchaImage' => 'Zend\\Form\\View\\Helper\\Captcha\\Image',
      'captcharecaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'captcha/recaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'captcha_recaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'captchaRecaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'CaptchaRecaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'formcaptcharecaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'form_captcha_recaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'formCaptchaRecaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'FormCaptchaRecaptcha' => 'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha',
      'formcheckbox' => 'Zend\\Form\\View\\Helper\\FormCheckbox',
      'form_checkbox' => 'Zend\\Form\\View\\Helper\\FormCheckbox',
      'formCheckbox' => 'Zend\\Form\\View\\Helper\\FormCheckbox',
      'FormCheckbox' => 'Zend\\Form\\View\\Helper\\FormCheckbox',
      'formcollection' => 'Zend\\Form\\View\\Helper\\FormCollection',
      'form_collection' => 'Zend\\Form\\View\\Helper\\FormCollection',
      'formCollection' => 'Zend\\Form\\View\\Helper\\FormCollection',
      'FormCollection' => 'Zend\\Form\\View\\Helper\\FormCollection',
      'formcolor' => 'Zend\\Form\\View\\Helper\\FormColor',
      'form_color' => 'Zend\\Form\\View\\Helper\\FormColor',
      'formColor' => 'Zend\\Form\\View\\Helper\\FormColor',
      'FormColor' => 'Zend\\Form\\View\\Helper\\FormColor',
      'formdate' => 'Zend\\Form\\View\\Helper\\FormDate',
      'form_date' => 'Zend\\Form\\View\\Helper\\FormDate',
      'formDate' => 'Zend\\Form\\View\\Helper\\FormDate',
      'FormDate' => 'Zend\\Form\\View\\Helper\\FormDate',
      'formdatetime' => 'Zend\\Form\\View\\Helper\\FormDateTime',
      'form_date_time' => 'Zend\\Form\\View\\Helper\\FormDateTime',
      'formDateTime' => 'Zend\\Form\\View\\Helper\\FormDateTime',
      'FormDateTime' => 'Zend\\Form\\View\\Helper\\FormDateTime',
      'formdatetimelocal' => 'Zend\\Form\\View\\Helper\\FormDateTimeLocal',
      'form_date_time_local' => 'Zend\\Form\\View\\Helper\\FormDateTimeLocal',
      'formDateTimeLocal' => 'Zend\\Form\\View\\Helper\\FormDateTimeLocal',
      'FormDateTimeLocal' => 'Zend\\Form\\View\\Helper\\FormDateTimeLocal',
      'formdatetimeselect' => 'Zend\\Form\\View\\Helper\\FormDateTimeSelect',
      'form_date_time_select' => 'Zend\\Form\\View\\Helper\\FormDateTimeSelect',
      'formDateTimeSelect' => 'Zend\\Form\\View\\Helper\\FormDateTimeSelect',
      'FormDateTimeSelect' => 'Zend\\Form\\View\\Helper\\FormDateTimeSelect',
      'formdateselect' => 'Zend\\Form\\View\\Helper\\FormDateSelect',
      'form_date_select' => 'Zend\\Form\\View\\Helper\\FormDateSelect',
      'formDateSelect' => 'Zend\\Form\\View\\Helper\\FormDateSelect',
      'FormDateSelect' => 'Zend\\Form\\View\\Helper\\FormDateSelect',
      'form_element' => 'Zend\\Form\\View\\Helper\\FormElement',
      'formelement' => 'Zend\\Form\\View\\Helper\\FormElement',
      'formElement' => 'Zend\\Form\\View\\Helper\\FormElement',
      'FormElement' => 'Zend\\Form\\View\\Helper\\FormElement',
      'form_element_errors' => 'Zend\\Form\\View\\Helper\\FormElementErrors',
      'formelementerrors' => 'Zend\\Form\\View\\Helper\\FormElementErrors',
      'formElementErrors' => 'Zend\\Form\\View\\Helper\\FormElementErrors',
      'FormElementErrors' => 'Zend\\Form\\View\\Helper\\FormElementErrors',
      'form_email' => 'Zend\\Form\\View\\Helper\\FormEmail',
      'formemail' => 'Zend\\Form\\View\\Helper\\FormEmail',
      'formEmail' => 'Zend\\Form\\View\\Helper\\FormEmail',
      'FormEmail' => 'Zend\\Form\\View\\Helper\\FormEmail',
      'form_file' => 'Zend\\Form\\View\\Helper\\FormFile',
      'formfile' => 'Zend\\Form\\View\\Helper\\FormFile',
      'formFile' => 'Zend\\Form\\View\\Helper\\FormFile',
      'FormFile' => 'Zend\\Form\\View\\Helper\\FormFile',
      'formfileapcprogress' => 'Zend\\Form\\View\\Helper\\File\\FormFileApcProgress',
      'form_file_apc_progress' => 'Zend\\Form\\View\\Helper\\File\\FormFileApcProgress',
      'formFileApcProgress' => 'Zend\\Form\\View\\Helper\\File\\FormFileApcProgress',
      'FormFileApcProgress' => 'Zend\\Form\\View\\Helper\\File\\FormFileApcProgress',
      'formfilesessionprogress' => 'Zend\\Form\\View\\Helper\\File\\FormFileSessionProgress',
      'form_file_session_progress' => 'Zend\\Form\\View\\Helper\\File\\FormFileSessionProgress',
      'formFileSessionProgress' => 'Zend\\Form\\View\\Helper\\File\\FormFileSessionProgress',
      'FormFileSessionProgress' => 'Zend\\Form\\View\\Helper\\File\\FormFileSessionProgress',
      'formfileuploadprogress' => 'Zend\\Form\\View\\Helper\\File\\FormFileUploadProgress',
      'form_file_upload_progress' => 'Zend\\Form\\View\\Helper\\File\\FormFileUploadProgress',
      'formFileUploadProgress' => 'Zend\\Form\\View\\Helper\\File\\FormFileUploadProgress',
      'FormFileUploadProgress' => 'Zend\\Form\\View\\Helper\\File\\FormFileUploadProgress',
      'formhidden' => 'Zend\\Form\\View\\Helper\\FormHidden',
      'form_hidden' => 'Zend\\Form\\View\\Helper\\FormHidden',
      'formHidden' => 'Zend\\Form\\View\\Helper\\FormHidden',
      'FormHidden' => 'Zend\\Form\\View\\Helper\\FormHidden',
      'formimage' => 'Zend\\Form\\View\\Helper\\FormImage',
      'form_image' => 'Zend\\Form\\View\\Helper\\FormImage',
      'formImage' => 'Zend\\Form\\View\\Helper\\FormImage',
      'FormImage' => 'Zend\\Form\\View\\Helper\\FormImage',
      'forminput' => 'Zend\\Form\\View\\Helper\\FormInput',
      'form_input' => 'Zend\\Form\\View\\Helper\\FormInput',
      'formInput' => 'Zend\\Form\\View\\Helper\\FormInput',
      'FormInput' => 'Zend\\Form\\View\\Helper\\FormInput',
      'formlabel' => 'Zend\\Form\\View\\Helper\\FormLabel',
      'form_label' => 'Zend\\Form\\View\\Helper\\FormLabel',
      'formLabel' => 'Zend\\Form\\View\\Helper\\FormLabel',
      'FormLabel' => 'Zend\\Form\\View\\Helper\\FormLabel',
      'formmonth' => 'Zend\\Form\\View\\Helper\\FormMonth',
      'form_month' => 'Zend\\Form\\View\\Helper\\FormMonth',
      'formMonth' => 'Zend\\Form\\View\\Helper\\FormMonth',
      'FormMonth' => 'Zend\\Form\\View\\Helper\\FormMonth',
      'formmonthselect' => 'Zend\\Form\\View\\Helper\\FormMonthSelect',
      'form_month_select' => 'Zend\\Form\\View\\Helper\\FormMonthSelect',
      'formMonthSelect' => 'Zend\\Form\\View\\Helper\\FormMonthSelect',
      'FormMonthSelect' => 'Zend\\Form\\View\\Helper\\FormMonthSelect',
      'formmulticheckbox' => 'Zend\\Form\\View\\Helper\\FormMultiCheckbox',
      'form_multi_checkbox' => 'Zend\\Form\\View\\Helper\\FormMultiCheckbox',
      'formMultiCheckbox' => 'Zend\\Form\\View\\Helper\\FormMultiCheckbox',
      'FormMultiCheckbox' => 'Zend\\Form\\View\\Helper\\FormMultiCheckbox',
      'formnumber' => 'Zend\\Form\\View\\Helper\\FormNumber',
      'form_number' => 'Zend\\Form\\View\\Helper\\FormNumber',
      'formNumber' => 'Zend\\Form\\View\\Helper\\FormNumber',
      'FormNumber' => 'Zend\\Form\\View\\Helper\\FormNumber',
      'formpassword' => 'Zend\\Form\\View\\Helper\\FormPassword',
      'form_password' => 'Zend\\Form\\View\\Helper\\FormPassword',
      'formPassword' => 'Zend\\Form\\View\\Helper\\FormPassword',
      'FormPassword' => 'Zend\\Form\\View\\Helper\\FormPassword',
      'formradio' => 'Zend\\Form\\View\\Helper\\FormRadio',
      'form_radio' => 'Zend\\Form\\View\\Helper\\FormRadio',
      'formRadio' => 'Zend\\Form\\View\\Helper\\FormRadio',
      'FormRadio' => 'Zend\\Form\\View\\Helper\\FormRadio',
      'formrange' => 'Zend\\Form\\View\\Helper\\FormRange',
      'form_range' => 'Zend\\Form\\View\\Helper\\FormRange',
      'formRange' => 'Zend\\Form\\View\\Helper\\FormRange',
      'FormRange' => 'Zend\\Form\\View\\Helper\\FormRange',
      'formreset' => 'Zend\\Form\\View\\Helper\\FormReset',
      'form_reset' => 'Zend\\Form\\View\\Helper\\FormReset',
      'formReset' => 'Zend\\Form\\View\\Helper\\FormReset',
      'FormReset' => 'Zend\\Form\\View\\Helper\\FormReset',
      'formrow' => 'Zend\\Form\\View\\Helper\\FormRow',
      'form_row' => 'Zend\\Form\\View\\Helper\\FormRow',
      'formRow' => 'Zend\\Form\\View\\Helper\\FormRow',
      'FormRow' => 'Zend\\Form\\View\\Helper\\FormRow',
      'formsearch' => 'Zend\\Form\\View\\Helper\\FormSearch',
      'form_search' => 'Zend\\Form\\View\\Helper\\FormSearch',
      'formSearch' => 'Zend\\Form\\View\\Helper\\FormSearch',
      'FormSearch' => 'Zend\\Form\\View\\Helper\\FormSearch',
      'formselect' => 'Zend\\Form\\View\\Helper\\FormSelect',
      'form_select' => 'Zend\\Form\\View\\Helper\\FormSelect',
      'formSelect' => 'Zend\\Form\\View\\Helper\\FormSelect',
      'FormSelect' => 'Zend\\Form\\View\\Helper\\FormSelect',
      'formsubmit' => 'Zend\\Form\\View\\Helper\\FormSubmit',
      'form_submit' => 'Zend\\Form\\View\\Helper\\FormSubmit',
      'formSubmit' => 'Zend\\Form\\View\\Helper\\FormSubmit',
      'FormSubmit' => 'Zend\\Form\\View\\Helper\\FormSubmit',
      'formtel' => 'Zend\\Form\\View\\Helper\\FormTel',
      'form_tel' => 'Zend\\Form\\View\\Helper\\FormTel',
      'formTel' => 'Zend\\Form\\View\\Helper\\FormTel',
      'FormTel' => 'Zend\\Form\\View\\Helper\\FormTel',
      'formtext' => 'Zend\\Form\\View\\Helper\\FormText',
      'form_text' => 'Zend\\Form\\View\\Helper\\FormText',
      'formText' => 'Zend\\Form\\View\\Helper\\FormText',
      'FormText' => 'Zend\\Form\\View\\Helper\\FormText',
      'formtextarea' => 'Zend\\Form\\View\\Helper\\FormTextarea',
      'form_text_area' => 'Zend\\Form\\View\\Helper\\FormTextarea',
      'formTextarea' => 'Zend\\Form\\View\\Helper\\FormTextarea',
      'formTextArea' => 'Zend\\Form\\View\\Helper\\FormTextarea',
      'FormTextArea' => 'Zend\\Form\\View\\Helper\\FormTextarea',
      'formtime' => 'Zend\\Form\\View\\Helper\\FormTime',
      'form_time' => 'Zend\\Form\\View\\Helper\\FormTime',
      'formTime' => 'Zend\\Form\\View\\Helper\\FormTime',
      'FormTime' => 'Zend\\Form\\View\\Helper\\FormTime',
      'formurl' => 'Zend\\Form\\View\\Helper\\FormUrl',
      'form_url' => 'Zend\\Form\\View\\Helper\\FormUrl',
      'formUrl' => 'Zend\\Form\\View\\Helper\\FormUrl',
      'FormUrl' => 'Zend\\Form\\View\\Helper\\FormUrl',
      'formweek' => 'Zend\\Form\\View\\Helper\\FormWeek',
      'form_week' => 'Zend\\Form\\View\\Helper\\FormWeek',
      'formWeek' => 'Zend\\Form\\View\\Helper\\FormWeek',
      'FormWeek' => 'Zend\\Form\\View\\Helper\\FormWeek',
      'mainMenu' => 'Application\\View\\Helper\\Menu',
      'pageBreadcrumbs' => 'Application\\View\\Helper\\Breadcrumbs',
      'access' => 'User\\View\\Helper\\Access',
      'currentUser' => 'User\\View\\Helper\\CurrentUser',
    ),
    'factories' => 
    array (
      'Zend\\I18n\\View\\Helper\\CurrencyFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\DateFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\NumberFormat' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\Plural' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\Translate' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\I18n\\View\\Helper\\TranslatePlural' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Mvc\\Plugin\\FlashMessenger\\View\\Helper\\FlashMessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\View\\Helper\\FlashMessengerFactory',
      'zendviewhelperflashmessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\View\\Helper\\FlashMessengerFactory',
      'Zend\\Form\\View\\Helper\\Form' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormButton' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormCaptcha' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\Captcha\\Dumb' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\Captcha\\Figlet' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\Captcha\\Image' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\Captcha\\ReCaptcha' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormCheckbox' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormCollection' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormColor' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormDate' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormDateTime' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormDateTimeLocal' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormDateTimeSelect' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormDateSelect' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormElement' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormElementErrors' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormEmail' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormFile' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\File\\FormFileApcProgress' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\File\\FormFileSessionProgress' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\File\\FormFileUploadProgress' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormHidden' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormImage' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormInput' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormLabel' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormMonth' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormMonthSelect' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormMultiCheckbox' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormNumber' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormPassword' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormRadio' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormRange' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormReset' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormRow' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormSearch' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormSelect' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormSubmit' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormTel' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormText' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormTextarea' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormTime' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormUrl' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Form\\View\\Helper\\FormWeek' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Application\\View\\Helper\\Menu' => 'Application\\View\\Helper\\Factory\\MenuFactory',
      'Application\\View\\Helper\\Breadcrumbs' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'User\\View\\Helper\\Access' => 'User\\View\\Helper\\Factory\\AccessFactory',
      'User\\View\\Helper\\CurrentUser' => 'User\\View\\Helper\\Factory\\CurrentUserFactory',
    ),
  ),
  'controller_plugins' => 
  array (
    'aliases' => 
    array (
      'prg' => 'Zend\\Mvc\\Plugin\\Prg\\PostRedirectGet',
      'PostRedirectGet' => 'Zend\\Mvc\\Plugin\\Prg\\PostRedirectGet',
      'postRedirectGet' => 'Zend\\Mvc\\Plugin\\Prg\\PostRedirectGet',
      'postredirectget' => 'Zend\\Mvc\\Plugin\\Prg\\PostRedirectGet',
      'Zend\\Mvc\\Controller\\Plugin\\PostRedirectGet' => 'Zend\\Mvc\\Plugin\\Prg\\PostRedirectGet',
      'identity' => 'Zend\\Mvc\\Plugin\\Identity\\Identity',
      'Identity' => 'Zend\\Mvc\\Plugin\\Identity\\Identity',
      'Zend\\Mvc\\Controller\\Plugin\\Identity' => 'Zend\\Mvc\\Plugin\\Identity\\Identity',
      'flashmessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\FlashMessenger',
      'flashMessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\FlashMessenger',
      'FlashMessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\FlashMessenger',
      'Zend\\Mvc\\Controller\\Plugin\\FlashMessenger' => 'Zend\\Mvc\\Plugin\\FlashMessenger\\FlashMessenger',
      'fileprg' => 'Zend\\Mvc\\Plugin\\FilePrg\\FilePostRedirectGet',
      'FilePostRedirectGet' => 'Zend\\Mvc\\Plugin\\FilePrg\\FilePostRedirectGet',
      'filePostRedirectGet' => 'Zend\\Mvc\\Plugin\\FilePrg\\FilePostRedirectGet',
      'filepostredirectget' => 'Zend\\Mvc\\Plugin\\FilePrg\\FilePostRedirectGet',
      'Zend\\Mvc\\Controller\\Plugin\\FilePostRedirectGet' => 'Zend\\Mvc\\Plugin\\FilePrg\\FilePostRedirectGet',
      'access' => 'User\\Controller\\Plugin\\AccessPlugin',
      'currentUser' => 'User\\Controller\\Plugin\\CurrentUserPlugin',
    ),
    'factories' => 
    array (
      'Zend\\Mvc\\Plugin\\Prg\\PostRedirectGet' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Mvc\\Plugin\\Identity\\Identity' => 'Zend\\Mvc\\Plugin\\Identity\\IdentityFactory',
      'Zend\\Mvc\\Plugin\\FlashMessenger\\FlashMessenger' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'Zend\\Mvc\\Plugin\\FilePrg\\FilePostRedirectGet' => 'Zend\\ServiceManager\\Factory\\InvokableFactory',
      'User\\Controller\\Plugin\\AccessPlugin' => 'User\\Controller\\Plugin\\Factory\\AccessPluginFactory',
      'User\\Controller\\Plugin\\CurrentUserPlugin' => 'User\\Controller\\Plugin\\Factory\\CurrentUserPluginFactory',
    ),
  ),
  'access_filter' => 
  array (
    'options' => 
    array (
      'mode' => 'restrictive',
    ),
    'controllers' => 
    array (
      'Application\\Controller\\IndexController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
          ),
          'allow' => '*',
        ),
        1 => 
        array (
          'actions' => 
          array (
            0 => 'settings',
          ),
          'allow' => '@',
        ),
      ),
      'User\\Controller\\UserController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'resetPassword',
            1 => 'message',
            2 => 'setPassword',
          ),
          'allow' => '*',
        ),
        1 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'add',
            2 => 'edit',
            3 => 'view',
            4 => 'changePassword',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'User\\Controller\\RoleController' => 
      array (
        0 => 
        array (
          'actions' => '*',
          'allow' => '+role.manage',
        ),
      ),
      'User\\Controller\\PermissionController' => 
      array (
        0 => 
        array (
          'actions' => '*',
          'allow' => '+permission.manage',
        ),
      ),
      'Anneescolaire\\Controller\\AnneescolaireController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'matiere',
            2 => 'add',
            3 => 'addLibeleDiscipline',
            4 => 'edit',
            5 => 'editd',
            6 => 'view',
            7 => 'delete',
            8 => 'deleted',
            9 => 'confirm',
            10 => 'viewd',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Eleve\\Controller\\EleveController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'afficherElevesParClasse',
            2 => 'afficherElevesAdmis',
            3 => 'eleve',
            4 => 'search',
            5 => 'add',
            6 => 'edit',
            7 => 'view',
            8 => 'addEleve',
            9 => 'contact',
            10 => 'delete',
            11 => 'confirm',
            12 => 'file',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Salle\\Controller\\SalleController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'salle',
            2 => 'add',
            3 => 'edit',
            4 => 'view',
            5 => 'delete',
            6 => 'confirm',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Ecole\\Controller\\EcoleController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'ecole',
            2 => 'ajouter',
            3 => 'edit',
            4 => 'view',
            5 => 'delete',
            6 => 'confirm',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Matiere\\Controller\\MatiereController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'afficherMatiereClasse',
            2 => 'affecterMatiereClasse',
            3 => 'matiere',
            4 => 'afficherMatiereNotInClasse',
            5 => 'desaffecter',
            6 => 'affecter',
            7 => 'add',
            8 => 'addLibeleDiscipline',
            9 => 'edit',
            10 => 'editd',
            11 => 'view',
            12 => 'delete',
            13 => 'deleted',
            14 => 'confirm',
            15 => 'viewd',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Classe\\Controller\\ClasseController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'afficherEleveMatiereClasseNonEvalue',
            2 => 'afficherEleveMatiereClasse',
            3 => 'affecterEleves',
            4 => 'affecterSalle',
            5 => 'affecterMatieres',
            6 => 'configurer',
            7 => 'classe',
            8 => 'add',
            9 => 'edit',
            10 => 'view',
            11 => 'delete',
            12 => 'confirm',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Periodeval\\Controller\\PeriodevalController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'add',
            2 => 'edit',
            3 => 'view',
            4 => 'delete',
            5 => 'deleted',
            6 => 'confirm',
            7 => 'viewd',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Evaluation\\Controller\\EvaluationController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'palmaresbulletins',
            2 => 'imprimerPalmares',
            3 => 'modifierNote',
            4 => 'imprimerTous',
            5 => 'afficherPalmaresNotes',
            6 => 'eleveNonEvalue',
            7 => 'afficherEleveMatiereClasse',
            8 => 'afficherMatiereEvalueeClassePeriode',
            9 => 'afficherPalmaresBulletin',
            10 => 'palmaresnotes',
            11 => 'afficherTotalCoef',
            12 => 'afficherMatiereNotEvaluate',
            13 => 'printpdf',
            14 => 'palmares',
            15 => 'imprimer',
            16 => 'add',
            17 => 'edit',
            18 => 'view',
            19 => 'delete',
            20 => 'confirm',
            21 => 'afficherMatiereClassee',
            22 => 'desaffecter',
          ),
          'allow' => '+user.manage',
        ),
      ),
      'Test\\Controller\\TestController' => 
      array (
        0 => 
        array (
          'actions' => 
          array (
            0 => 'index',
            1 => 'addpersonne',
            2 => 'emprunter',
            3 => 'addlivre',
            4 => 'edit',
            5 => 'viewemprunt',
            6 => 'viewlivre',
            7 => 'viewpersonne',
            8 => 'delete',
            9 => 'confirm',
          ),
          'allow' => '+user.manage',
        ),
      ),
    ),
  ),
  'rbac_manager' => 
  array (
    'assertions' => 
    array (
      0 => 'Application\\Service\\RbacAssertionManager',
    ),
  ),
  'view_helper_config' => 
  array (
    'flashmessenger' => 
    array (
      'message_open_format' => '<div%s><ul><li>',
      'message_close_string' => '</li></ul></div>',
      'message_separator_string' => '</li><li>',
    ),
  ),
  'session_config' => 
  array (
    'cookie_lifetime' => 3600,
    'gc_maxlifetime' => 2592000,
  ),
  'session_manager' => 
  array (
    'validators' => 
    array (
      0 => 'Zend\\Session\\Validator\\RemoteAddr',
      1 => 'Zend\\Session\\Validator\\HttpUserAgent',
    ),
  ),
  'session_storage' => 
  array (
    'type' => 'Zend\\Session\\Storage\\SessionArrayStorage',
  ),
  'caches' => 
  array (
    'FilesystemCache' => 
    array (
      'adapter' => 
      array (
        'name' => 'Zend\\Cache\\Storage\\Adapter\\Filesystem',
        'options' => 
        array (
          'cache_dir' => './data/cache',
          'ttl' => 3600,
        ),
      ),
      'plugins' => 
      array (
        0 => 
        array (
          'name' => 'serializer',
          'options' => 
          array (
          ),
        ),
      ),
    ),
  ),
);