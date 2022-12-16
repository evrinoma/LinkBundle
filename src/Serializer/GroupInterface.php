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

namespace Evrinoma\LinkBundle\Serializer;

interface GroupInterface
{
    public const API_POST_LINK = 'API_POST_LINK';
    public const API_PUT_LINK = 'API_PUT_LINK';
    public const API_GET_LINK = 'API_GET_LINK';
    public const API_CRITERIA_LINK = self::API_GET_LINK;
    public const APP_GET_BASIC_LINK = 'APP_GET_BASIC_LINK';
}
