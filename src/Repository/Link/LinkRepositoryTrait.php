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

namespace Evrinoma\LinkBundle\Repository\Link;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkCannotBeSavedException;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Exception\LinkProxyException;
use Evrinoma\LinkBundle\Mediator\QueryMediatorInterface;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;

trait LinkRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param LinkInterface $link
     *
     * @return bool
     *
     * @throws LinkCannotBeSavedException
     * @throws ORMException
     */
    public function save(LinkInterface $link): bool
    {
        try {
            $this->persistWrapped($link);
        } catch (ORMInvalidArgumentException $e) {
            throw new LinkCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param LinkInterface $link
     *
     * @return bool
     */
    public function remove(LinkInterface $link): bool
    {
        return true;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return array
     *
     * @throws LinkNotFoundException
     */
    public function findByCriteria(LinkApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $links = $this->mediator->getResult($dto, $builder);

        if (0 === \count($links)) {
            throw new LinkNotFoundException('Cannot find link by findByCriteria');
        }

        return $links;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws LinkNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): LinkInterface
    {
        /** @var LinkInterface $link */
        $link = $this->findWrapped($id);

        if (null === $link) {
            throw new LinkNotFoundException("Cannot find link with id $id");
        }

        return $link;
    }

    /**
     * @param string $id
     *
     * @return LinkInterface
     *
     * @throws LinkProxyException
     * @throws ORMException
     */
    public function proxy(string $id): LinkInterface
    {
        $link = $this->referenceWrapped($id);

        if (!$this->containsWrapped($link)) {
            throw new LinkProxyException("Proxy doesn't exist with $id");
        }

        return $link;
    }
}
