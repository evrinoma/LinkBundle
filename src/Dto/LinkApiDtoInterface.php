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

namespace Evrinoma\LinkBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NameInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\PositionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\UrlInterface;

interface LinkApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, NameInterface, UrlInterface, PositionInterface
{
}
