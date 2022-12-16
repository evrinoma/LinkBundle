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

use Evrinoma\LinkBundle\Exception\LinkCannotBeRemovedException;
use Evrinoma\LinkBundle\Exception\LinkCannotBeSavedException;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

interface LinkCommandRepositoryInterface
{
    /**
     * @param LinkInterface $link
     *
     * @return bool
     *
     * @throws LinkCannotBeSavedException
     */
    public function save(LinkInterface $link): bool;

    /**
     * @param LinkInterface $link
     *
     * @return bool
     *
     * @throws LinkCannotBeRemovedException
     */
    public function remove(LinkInterface $link): bool;
}
