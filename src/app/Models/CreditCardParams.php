<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Carbon\Carbon;

class CreditCardParams
{
    private $number;
    private $expiration;
    private $cvc;

    public function __construct(string $number, Carbon $expiration, string $cvc)
    {
        $this->number = $number;
        $this->expiration = $expiration;
        $this->cvc = $cvc;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getExpirationDate(): Carbon
    {
        return $this->expiration;
    }

    public function getExpirationMonth(): int
    {
        return $this->expiration->month;
    }

    public function getExpirationYear(): int
    {
        return $this->expiration->year;
    }

    public function getCVC(): string
    {
        return $this->cvc;
    }
}
