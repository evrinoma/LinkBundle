<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\LinkBundle;

use Evrinoma\LinkBundle\DependencyInjection\Compiler\Constraint\Property\LinkPass;
use Evrinoma\LinkBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\LinkBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\LinkBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\LinkBundle\DependencyInjection\EvrinomaLinkExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaLinkBundle extends Bundle
{
    public const BUNDLE = 'link';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new LinkPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaLinkExtension();
        }

        return $this->extension;
    }
}
