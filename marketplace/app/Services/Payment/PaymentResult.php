<?php

namespace App\Services\Payment;

class PaymentResult
{
    public function __construct(
        public bool $successful,
        public ?string $transactionId = null,
        public ?string $message = null,
    ) {
    }

    public static function success(string $transactionId, ?string $message = null): self
    {
        return new self(true, $transactionId, $message);
    }

    public static function failure(?string $message = null): self
    {
        return new self(false, null, $message);
    }
}
