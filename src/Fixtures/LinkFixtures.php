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

namespace Evrinoma\LinkBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Entity\Link\BaseLink;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class LinkFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            LinkApiDtoInterface::NAME => 'ite',
            LinkApiDtoInterface::URL => 'http://ite',
            LinkApiDtoInterface::ACTIVE => 'a',
            LinkApiDtoInterface::POSITION => 1,
            'created_at' => '2008-10-23 10:21:50',
        ],
        [
            LinkApiDtoInterface::NAME => 'kzkt',
            LinkApiDtoInterface::URL => 'http://kzkt',
            LinkApiDtoInterface::ACTIVE => 'a',
            LinkApiDtoInterface::POSITION => 2,
            'created_at' => '2015-10-23 10:21:50',
        ],
        [
            LinkApiDtoInterface::NAME => 'c2m',
            LinkApiDtoInterface::URL => 'http://c2m',
            LinkApiDtoInterface::ACTIVE => 'a',
            LinkApiDtoInterface::POSITION => 3,
            'created_at' => '2020-10-23 10:21:50',
        ],
        [
            LinkApiDtoInterface::NAME => 'kzkt2',
            LinkApiDtoInterface::URL => 'http://kzkt2',
            LinkApiDtoInterface::ACTIVE => 'd',
            LinkApiDtoInterface::POSITION => 1,
            'created_at' => '2015-10-23 10:21:50',
            ],
        [
            LinkApiDtoInterface::NAME => 'nvr',
            LinkApiDtoInterface::URL => 'http://nvr',
            LinkApiDtoInterface::ACTIVE => 'b',
            LinkApiDtoInterface::POSITION => 2,
            'created_at' => '2010-10-23 10:21:50',
        ],
        [
            LinkApiDtoInterface::NAME => 'nvr2',
            LinkApiDtoInterface::URL => 'http://nvr2',
            LinkApiDtoInterface::ACTIVE => 'd',
            LinkApiDtoInterface::POSITION => 3,
            'created_at' => '2010-10-23 10:21:50',
            ],
        [
            LinkApiDtoInterface::NAME => 'nvr3',
            LinkApiDtoInterface::URL => 'http://nvr3',
            LinkApiDtoInterface::ACTIVE => 'd',
            LinkApiDtoInterface::POSITION => 1,
            'created_at' => '2011-10-23 10:21:50',
        ],
    ];

    protected static string $class = BaseLink::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = static::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setName($record[LinkApiDtoInterface::NAME])
                ->setUrl($record[LinkApiDtoInterface::URL])
                ->setPosition($record[LinkApiDtoInterface::POSITION])
                ->setCreatedAt(new \DateTimeImmutable($record['created_at']))
                ->setActive($record[LinkApiDtoInterface::ACTIVE]);

            $this->expandEntity($entity, $record);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::LINK_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
