<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VoucherExpiredException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct('Voucher is expired or not valid.');
    }
}
