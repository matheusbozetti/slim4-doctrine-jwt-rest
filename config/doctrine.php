<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\{EntityManager, EntityManagerInterface};
use Psr\Container\ContainerInterface;

function getEntityManager (ContainerInterface $container): EntityManagerInterface {
    $doctrineSettings = $container->get('settings')['doctrine'];

    $config = Setup::createAnnotationMetadataConfiguration(
        $doctrineSettings['metadata_dirs'],
        $doctrineSettings['dev_mode']
    );

    return EntityManager::create($doctrineSettings['connection'], $config);
};
