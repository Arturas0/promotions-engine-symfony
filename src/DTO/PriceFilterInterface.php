<?php

namespace App\DTO;

use App\Entity\Promotion;
use App\Filter\PromotionsFilterInterface;

interface PriceFilterInterface extends PromotionsFilterInterface
{
    public function apply(PriceEnquiryInterface $enquiry, Promotion ...$promotions): PriceEnquiryInterface;
}