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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    public function onUpdate(DtoInterface $dto, $entity): LinkInterface
    {
        /* @var $dto LinkApiDtoInterface */
        $entity
            ->setName($dto->getName())
            ->setUrl($dto->getUrl())
            ->setPosition($dto->getPosition())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): LinkInterface
    {
        /* @var $dto LinkApiDtoInterface */
        $entity
            ->setName($dto->getName())
            ->setUrl($dto->getUrl())
            ->setPosition($dto->getPosition())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $entity;
    }
}
