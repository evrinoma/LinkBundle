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

namespace Evrinoma\LinkBundle\Tests\Functional\Action;

use Evrinoma\LinkBundle\Dto\LinkApiDto;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Tests\Functional\Helper\BaseLinkTestTrait;
use Evrinoma\LinkBundle\Tests\Functional\ValueObject\Link\Active;
use Evrinoma\LinkBundle\Tests\Functional\ValueObject\Link\Id;
use Evrinoma\LinkBundle\Tests\Functional\ValueObject\Link\Name;
use Evrinoma\LinkBundle\Tests\Functional\ValueObject\Link\Position;
use Evrinoma\LinkBundle\Tests\Functional\ValueObject\Link\Url;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseLink extends AbstractServiceTest implements BaseLinkTestInterface
{
    use BaseLinkTestTrait;

    public const API_GET = 'evrinoma/api/link';
    public const API_CRITERIA = 'evrinoma/api/link/criteria';
    public const API_DELETE = 'evrinoma/api/link/delete';
    public const API_PUT = 'evrinoma/api/link/save';
    public const API_POST = 'evrinoma/api/link/create';

    protected static function getDtoClass(): string
    {
        return LinkApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            LinkApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            LinkApiDtoInterface::ID => Id::default(),
            LinkApiDtoInterface::NAME => Name::default(),
            LinkApiDtoInterface::ACTIVE => Active::value(),
            LinkApiDtoInterface::URL => Url::default(),
            LinkApiDtoInterface::POSITION => Position::value(),
        ];
    }

    public function actionPost(): void
    {
        $this->createLink();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([LinkApiDtoInterface::DTO_CLASS => static::getDtoClass(), LinkApiDtoInterface::ACTIVE => Active::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([LinkApiDtoInterface::DTO_CLASS => static::getDtoClass(), LinkApiDtoInterface::ID => Id::value(), LinkApiDtoInterface::ACTIVE => Active::block(), LinkApiDtoInterface::NAME => Name::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([LinkApiDtoInterface::DTO_CLASS => static::getDtoClass(), LinkApiDtoInterface::ACTIVE => Active::value(), LinkApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([LinkApiDtoInterface::DTO_CLASS => static::getDtoClass(), LinkApiDtoInterface::ACTIVE => Active::delete()]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([LinkApiDtoInterface::DTO_CLASS => static::getDtoClass(), LinkApiDtoInterface::ACTIVE => Active::delete(), LinkApiDtoInterface::NAME => Name::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $updated = $this->put(static::getDefault([LinkApiDtoInterface::ID => Id::value(), LinkApiDtoInterface::NAME => Name::value(), LinkApiDtoInterface::URL => Url::value(), LinkApiDtoInterface::POSITION => Position::value()]));
        $this->testResponseStatusOK();

        Assert::assertEquals($find[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ID], $updated[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ID]);
        Assert::assertEquals(Name::value(), $updated[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::NAME]);
        Assert::assertEquals(Url::value(), $updated[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::URL]);
        Assert::assertEquals(Position::value(), $updated[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::POSITION]);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            LinkApiDtoInterface::ID => Id::wrong(),
            LinkApiDtoInterface::NAME => Name::wrong(),
            LinkApiDtoInterface::URL => Url::wrong(),
            LinkApiDtoInterface::POSITION => Position::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createLink();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([LinkApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ID], LinkApiDtoInterface::NAME => Name::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([LinkApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ID], LinkApiDtoInterface::URL => URL::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([LinkApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][LinkApiDtoInterface::ID], LinkApiDtoInterface::POSITION => Position::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createLink();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankName();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankUrl();
        $this->testResponseStatusUnprocessable();
    }
}
