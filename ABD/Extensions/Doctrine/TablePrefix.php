<?php namespace ABD\Extensions\Doctrine;
 
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;
 
class TablePrefix implements EventSubscriber
{
    
    protected $prefix = '';
 
    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }
     
    public function getSubscribedEvents()
    {
        return ['loadClassMetadata'];
    }
 
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
        
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping)
        {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY)
            {
                $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
            }
        }
    }
    
}