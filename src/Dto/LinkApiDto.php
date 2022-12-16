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

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\UrlTrait;
use Symfony\Component\HttpFoundation\Request;

class LinkApiDto extends AbstractDto implements LinkApiDtoInterface
{
    use ActiveTrait;
    use IdTrait;
    use NameTrait;
    use PositionTrait;
    use UrlTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(LinkApiDtoInterface::ACTIVE);
            $id = $request->get(LinkApiDtoInterface::ID);
            $name = $request->get(LinkApiDtoInterface::NAME);
            $url = $request->get(LinkApiDtoInterface::URL);
            $position = $request->get(LinkApiDtoInterface::POSITION);

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($position) {
                $this->setPosition($position);
            }
            if ($name) {
                $this->setName($name);
            }
            if ($url) {
                $this->setUrl($url);
            }
        }

        return $this;
    }
}
