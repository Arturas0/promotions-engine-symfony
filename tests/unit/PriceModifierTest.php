<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\EvenItemsMultiplier;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Tests\ServiceTestCase;

class PriceModifierTest extends ServiceTestCase
{
    /** @test */
    public function DateRangeMultiplier_return_a_correctly_modified_price(): void
    {
        // Given
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setRequestDate('2022-11-28');

        $promotion = new Promotion();
        $promotion->setName('Black Friday half price sale');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria([
            'from' => '2022-11-25',
            'to' => '2022-11-28'
        ]);
        $promotion->setType('date_range_multiplier');

        $dateRangeModifier = new DateRangeMultiplier();

            // When
        $modifiedPrice = $dateRangeModifier->modify(100, 5, $promotion, $enquiry);

            // Then
        $this->assertEquals(250, $modifiedPrice);
    }

    /** @test */
    public function FixedPriceVoucher_return_a_correctly_modified_price(): void
    {
        $promotion = new Promotion();
        $promotion->setName('Voucher OU812');
        $promotion->setAdjustment(100);
        $promotion->setCriteria([
            'code' => 'OU812',
        ]);
        $promotion->setType('fixed_price_voucher');

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setVoucherCode('OU812');

        $fixedPriceVoucher = new FixedPriceVoucher();

        // When
        $modifiedPrice = $fixedPriceVoucher->modify(150, 5, $promotion, $enquiry);

        // Then
        $this->assertEquals(500, $modifiedPrice);
    }

    /** @test */
    public function EventItemsMultiplier_return_a_correctly_modified_price(): void
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);

        $promotion = new Promotion();
        $promotion->setName('Buy one get one free');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria([
            'minimum_quantity' => 2,
        ]);
        $promotion->setType('event_items_multiplier');

        $eventItemsMultiplier = new EvenItemsMultiplier();

        // When
        $modifiedPrice = $eventItemsMultiplier->modify(100, 5, $promotion, $enquiry);

        // Then
        $this->assertEquals(300, $modifiedPrice);
    }

    /** @test */
    public function EventItemsMultiplier_correctly_calculated_alternatives(): void
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);

        $promotion = new Promotion();
        $promotion->setName('Buy one get one half free');
        $promotion->setAdjustment(0.75);
        $promotion->setCriteria([
            'minimum_quantity' => 2,
        ]);
        $promotion->setType('event_items_multiplier');

        $eventItemsMultiplier = new EvenItemsMultiplier();

        // When
        $modifiedPrice = $eventItemsMultiplier->modify(100, 5, $promotion, $enquiry);

        // Then
        $this->assertEquals(400, $modifiedPrice);
    }
}