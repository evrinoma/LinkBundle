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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkUrl($dto)
            ->checkName($dto)
            ->checkPosition($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkUrl($dto)
            ->checkName($dto)
            ->checkActive($dto)
            ->checkPosition($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var LinkApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new LinkInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkUrl(DtoInterface $dto): self
    {
        /** @var LinkApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new LinkInvalidException('The Dto has\'t url');
        }

        return $this;
    }

    private function checkName(DtoInterface $dto): self
    {
        /** @var LinkApiDtoInterface $dto */
        if (!$dto->hasName()) {
            throw new LinkInvalidException('The Dto has\'t name');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var LinkApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new LinkInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var LinkApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new LinkInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
