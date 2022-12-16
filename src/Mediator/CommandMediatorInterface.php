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

namespace Evrinoma\LinkBundle\Mediator;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkCannotBeCreatedException;
use Evrinoma\LinkBundle\Exception\LinkCannotBeRemovedException;
use Evrinoma\LinkBundle\Exception\LinkCannotBeSavedException;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

interface CommandMediatorInterface
{
    /**
     * @param LinkApiDtoInterface $dto
     * @param LinkInterface       $entity
     *
     * @return LinkInterface
     *
     * @throws LinkCannotBeSavedException
     */
    public function onUpdate(LinkApiDtoInterface $dto, LinkInterface $entity): LinkInterface;

    /**
     * @param LinkApiDtoInterface $dto
     * @param LinkInterface       $entity
     *
     * @throws LinkCannotBeRemovedException
     */
    public function onDelete(LinkApiDtoInterface $dto, LinkInterface $entity): void;

    /**
     * @param LinkApiDtoInterface $dto
     * @param LinkInterface       $entity
     *
     * @return LinkInterface
     *
     * @throws LinkCannotBeSavedException
     * @throws LinkCannotBeCreatedException
     */
    public function onCreate(LinkApiDtoInterface $dto, LinkInterface $entity): LinkInterface;
}
