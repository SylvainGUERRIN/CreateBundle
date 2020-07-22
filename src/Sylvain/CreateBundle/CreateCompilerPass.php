<?php


namespace App\Sylvain\CreateBundle;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CreateCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container): void
    {
        if($container->hasParameter('twig.form.resources')){
            $resources = $container->getParameter('twig.form.resources') ? : [];
            array_unshift($resources, '@Create/fields.html.twig' );
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
