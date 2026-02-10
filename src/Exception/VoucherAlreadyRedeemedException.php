<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VoucherAlreadyRedeemedException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct('Voucher already redeemed.');
    }
}
