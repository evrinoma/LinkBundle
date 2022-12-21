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
use Evrinoma\LinkBundle\Exception\LinkCannotBeCreatedException;
use Evrinoma\LinkBundle\Exception\LinkCannotBeRemovedException;
use Evrinoma\LinkBundle\Exception\LinkCannotBeSavedException;
use Evrinoma\LinkBundle\Exception\LinkInvalidException;
use Evrinoma\LinkBundle\Exception\LinkNotFoundException;
use Evrinoma\LinkBundle\Factory\Link\FactoryInterface;
use Evrinoma\LinkBundle\Mediator\CommandMediatorInterface;
use Evrinoma\LinkBundle\Model\Link\LinkInterface;
use Evrinoma\LinkBundle\Repository\Link\LinkRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private LinkRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface       $validator
     * @param LinkRepositoryInterface  $repository
     * @param FactoryInterface         $factory
     * @param CommandMediatorInterface $mediator
     */
    public function __construct(ValidatorInterface $validator, LinkRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkInvalidException
     * @throws LinkCannotBeCreatedException
     * @throws LinkCannotBeSavedException
     */
    public function post(LinkApiDtoInterface $dto): LinkInterface
    {
        $link = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $link);

        $errors = $this->validator->validate($link);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new LinkInvalidException($errorsString);
        }

        $this->repository->save($link);

        return $link;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @return LinkInterface
     *
     * @throws LinkInvalidException
     * @throws LinkNotFoundException
     * @throws LinkCannotBeSavedException
     */
    public function put(LinkApiDtoInterface $dto): LinkInterface
    {
        try {
            $link = $this->repository->find($dto->idToString());
        } catch (LinkNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $link);

        $errors = $this->validator->validate($link);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new LinkInvalidException($errorsString);
        }

        $this->repository->save($link);

        return $link;
    }

    /**
     * @param LinkApiDtoInterface $dto
     *
     * @throws LinkCannotBeRemovedException
     * @throws LinkNotFoundException
     */
    public function delete(LinkApiDtoInterface $dto): void
    {
        try {
            $link = $this->repository->find($dto->idToString());
        } catch (LinkNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $link);
        try {
            $this->repository->remove($link);
        } catch (LinkCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
