<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VoucherLimitReachedException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct('Voucher redemption limit reached.');
    }
}
