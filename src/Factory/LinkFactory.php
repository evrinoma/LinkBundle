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

namespace Evrinoma\LinkBundle\Factory;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Entity\Link\BaseLink;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

class LinkFactory implements LinkFactoryInterface
{
    private static string $entityClass = BaseLink::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     */
    public function create(LinkApiDtoInterface $dto): LinkInterface
    {
        /* @var BaseLink $link */
        return new self::$entityClass();
    }
}
