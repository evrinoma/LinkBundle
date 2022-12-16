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

namespace Evrinoma\LinkBundle\Manager;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Exception\LinkProxyException;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

interface QueryManagerInterface
{
    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return array
     *
     * @throws LinkNotFoundException
     */
    public function criteria(LinkApiDtoInterface $dto): array;

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkNotFoundException
     */
    public function get(LinkApiDtoInterface $dto): LinkInterface;

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkProxyException
     */
    public function proxy(LinkApiDtoInterface $dto): LinkInterface;
}
