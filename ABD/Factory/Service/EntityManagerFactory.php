<?php namespace ABD\Factory\Service;

use ABD\Extensions\Doctrine\TablePrefix;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Service\AbstractFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntityManagerFactory extends AbstractFactory {
    
    /**
     * Create Table Prefix Service
     * 
     * @return EntityManager
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        /* @var $options \DoctrineORMModule\Options\EntityManager */
        $options    = $this->getOptions($sl, 'entitymanager');
        $connection = $sl->get($options->getConnection());
        $config     = $sl->get($options->getConfiguration());

        // initializing the resolver
        // @todo should actually attach it to a fetched event manager here, and not
        //       rely on its factory code
        $sl->get($options->getEntityResolver());

        // Table Prefix
        $tablePrefix = new TablePrefix($sl->get('Config')['doctrine']['connection']['orm_default']['params']['prefix']);
        $evm = $connection->getEventManager();
        $evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

        return EntityManager::create($connection, $config, $evm);
    }

    /**
     * Get Options Class
     * 
     * @return string
     */
    public function getOptionsClass()
    {
        return 'DoctrineORMModule\Options\EntityManager';
    }

}