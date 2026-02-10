<?php // Service: VoucherRedeemer 

namespace App\Service;

use App\Entity\Voucher;
use App\Exception\VoucherExpiredException;
use App\Exception\VoucherAlreadyRedeemedException;
use App\Exception\VoucherLimitReachedException;

class VoucherRedeemer
{
    public function redeem(Voucher $voucher, \DateTimeInterface $now): void
    {
        if ($voucher->getValidFrom() > $now || $voucher->getValidUntil() < $now) {
            throw new VoucherExpiredException();
        }

        if (!$voucher->isMultiUse() && $voucher->getRedeemedCount() > 0) {
            throw new VoucherAlreadyRedeemedException();
        }

        if ($voucher->getRedeemedCount() >= $voucher->getMaxRedemptions()) {
            throw new VoucherLimitReachedException();
        }

        $voucher->setRedeemedCount(
            $voucher->getRedeemedCount() + 1
        );
    }
}
