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

namespace Evrinoma\LinkBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Preserve\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\NameTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\UrlTrait;

trait LinkApiDtoTrait
{
    use ActiveTrait;
    use IdTrait;
    use NameTrait;
    use PositionTrait;
    use UrlTrait;
}
