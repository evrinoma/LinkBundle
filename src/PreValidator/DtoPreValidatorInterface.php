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

namespace Evrinoma\LinkBundle\PreValidator;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param LinkApiDtoInterface $dto
     *
     * @throws LinkInvalidException
     */
    public function onPost(LinkApiDtoInterface $dto): void;

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @throws LinkInvalidException
     */
    public function onPut(LinkApiDtoInterface $dto): void;

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @throws LinkInvalidException
     */
    public function onDelete(LinkApiDtoInterface $dto): void;
}
