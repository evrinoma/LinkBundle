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

namespace Evrinoma\LinkBundle\Factory\Link;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

interface FactoryInterface
{
    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     */
    public function create(LinkApiDtoInterface $dto): LinkInterface;
}
