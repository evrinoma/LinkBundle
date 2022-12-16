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
use Evrinoma\LinkBundle\Exception\LinkCannotBeRemovedException;
use Evrinoma\LinkBundle\Exception\LinkInvalidException;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

interface CommandManagerInterface
{
    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkInvalidException
     */
    public function post(LinkApiDtoInterface $dto): LinkInterface;

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkInvalidException
     * @throws LinkNotFoundException
     */
    public function put(LinkApiDtoInterface $dto): LinkInterface;

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @throws LinkCannotBeRemovedException
     * @throws LinkNotFoundException
     */
    public function delete(LinkApiDtoInterface $dto): void;
}
