<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Repository\ProductReviewRepositoryInterface;
use Sylius\Component\Review\Model\ReviewInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ProductReviewRepository extends EntityRepository implements ProductReviewRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findLatestByProduct($productId, $count)
    {
        return $this->createQueryBuilder('o')
            ->where('o.reviewSubject = :productId')
            ->andWhere('o.status = :status')
            ->setParameter('productId', $productId)
            ->setParameter('status', ReviewInterface::STATUS_ACCEPTED)
            ->orderBy('o.createdAt', 'desc')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }
}
