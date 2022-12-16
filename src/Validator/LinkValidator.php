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

namespace Evrinoma\LinkBundle\Validator;

use Evrinoma\LinkBundle\Entity\Link\BaseLink;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class LinkValidator extends AbstractValidator
{
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseLink::class;

    /**
     * @param ValidatorInterface $validator
     * @param string             $entityClass
     */
    public function __construct(ValidatorInterface $validator, string $entityClass)
    {
        parent::__construct($validator, $entityClass);
    }
}
