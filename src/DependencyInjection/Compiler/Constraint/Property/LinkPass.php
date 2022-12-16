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

namespace Evrinoma\LinkBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\LinkBundle\Validator\LinkValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class LinkPass extends AbstractConstraint implements CompilerPassInterface
{
    public const LINK_CONSTRAINT = 'evrinoma.link.constraint.property';

    protected static string $alias = self::LINK_CONSTRAINT;
    protected static string $class = LinkValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}
