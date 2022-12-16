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

namespace Evrinoma\LinkBundle\Tests\Functional\Helper;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

trait BaseLinkTestTrait
{
    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createLink(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankName(): array
    {
        $query = static::getDefault([LinkApiDtoInterface::NAME => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankUrl(): array
    {
        $query = static::getDefault([LinkApiDtoInterface::URL => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkLink($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkLink($entity): void
    {
        Assert::assertArrayHasKey(LinkApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(LinkApiDtoInterface::NAME, $entity);
        Assert::assertArrayHasKey(LinkApiDtoInterface::URL, $entity);
        Assert::assertArrayHasKey(LinkApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(LinkApiDtoInterface::POSITION, $entity);
    }
}
