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

namespace Evrinoma\LinkBundle\Entity\Link;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\LinkBundle\Model\Link\AbstractLink;

/**
 * @ORM\Table(name="e_link")
 *
 * @ORM\Entity
 */
class BaseLink extends AbstractLink
{
}
