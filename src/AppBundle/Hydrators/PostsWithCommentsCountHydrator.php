<?php

namespace AppBundle\Hydrators;

use AppBundle\Entity\Post;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Internal\Hydration\SimpleObjectHydrator;

class PostsWithCommentsCountHydrator extends SimpleObjectHydrator
{
    const PROPERTY_NAME = 'commentsCount';

    private $reflField;

    protected function prepare()
    {
        foreach ($this->_rsm->scalarMappings as $columnName => $fieldName) {
            if (self::PROPERTY_NAME !== $fieldName) {
                continue;
            }

            $this->_rsm->addMetaResult(key($this->_rsm->entityMappings), 'sclr7', self::PROPERTY_NAME, false, 'integer');
            unset($this->_rsm->scalarMappings[$columnName]);
        }
        $this->_rsm->isMixed = count($this->_rsm->scalarMappings) !== 0;
        parent::prepare();

        $this->reflField = new \ReflectionProperty(Post::class, self::PROPERTY_NAME);
        $this->reflField->setAccessible(true);
    }

    protected function hydrateRowData(array $sqlResult, array &$cache, array &$results)
    {
        $resultsCount = count($results);

        parent::hydrateRowData($sqlResult, $cache, $results);

        // a new object has been created
        if (count($results) != $resultsCount) {
            $entity = end($results);

            foreach ($sqlResult as $column => $value) {
                if (!isset($cache[$column])) {
                    continue;
                }

                if (self::PROPERTY_NAME !== $cache[$column]['name']) {
                    continue;
                }

                if (isset($cache[$column]['type'])) {
                    $value = Type::getType($cache[$column]['type'])->convertToPHPValue($value, $this->_platform);
                }

                $this->reflField->setValue($entity, $value);
            }
        }
    }
}
