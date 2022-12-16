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

namespace Evrinoma\LinkBundle\Manager;

use Evrinoma\LinkBundle\Dto\LinkApiDtoInterface;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Exception\LinkProxyException;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;
use Evrinoma\LinkBundle\Repository\Link\LinkQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private LinkQueryRepositoryInterface $repository;

    public function __construct(LinkQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return array
     *
     * @throws LinkNotFoundException
     */
    public function criteria(LinkApiDtoInterface $dto): array
    {
        try {
            $link = $this->repository->findByCriteria($dto);
        } catch (LinkNotFoundException $e) {
            throw $e;
        }

        return $link;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkProxyException
     */
    public function proxy(LinkApiDtoInterface $dto): LinkInterface
    {
        try {
            if ($dto->hasId()) {
                $link = $this->repository->proxy($dto->idToString());
            } else {
                throw new LinkProxyException('Id value is not set while trying get proxy object');
            }
        } catch (LinkProxyException $e) {
            throw $e;
        }

        return $link;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkNotFoundException
     */
    public function get(LinkApiDtoInterface $dto): LinkInterface
    {
        try {
            $link = $this->repository->find($dto->idToString());
        } catch (LinkNotFoundException $e) {
            throw $e;
        }

        return $link;
    }
}
