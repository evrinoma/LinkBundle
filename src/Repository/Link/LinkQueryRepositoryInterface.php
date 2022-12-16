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

namespace Evrinoma\LinkBundle\Repository\Link;

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Exception\LinkProxyException;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

interface LinkQueryRepositoryInterface
{
    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return array
     *
     * @throws LinkNotFoundException
     */
    public function findByCriteria(LinkApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return LinkInterface
     *
     * @throws LinkNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): LinkInterface;

    /**
     * @param string $id
     *
     * @return LinkInterface
     *
     * @throws LinkProxyException
     * @throws ORMException
     */
    public function proxy(string $id): LinkInterface;
}
