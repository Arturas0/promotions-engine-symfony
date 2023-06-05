<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class EvenItemsMultiplier implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        $minimumQuantity = $promotion->getCriteria()['minimum_quantity'];

        if ($quantity < $minimumQuantity) {
            return $price * $quantity;
        }

        $oddCount = $quantity % 2;

        $eventCount = $quantity - $oddCount;

        return ($eventCount * $price) * $promotion->getAdjustment() + ($oddCount * $price);
    }
}