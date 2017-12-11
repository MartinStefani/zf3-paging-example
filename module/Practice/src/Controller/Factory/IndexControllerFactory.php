<?php
declare(strict_types=1);

namespace Practice\Controller\Factory;

use Interop\Container\ContainerInterface;
use Practice\Controller\IndexController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        try {
            /** @var \Doctrine\ORM\EntityManager $entityManger */
            $entityManger = $container->get('doctrine.entitymanager.orm_default');
        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }

        return new IndexController($entityManger);
    }
}