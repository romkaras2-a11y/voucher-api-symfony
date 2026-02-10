<?php  //Unit-Test: Erfolgreiche Einlosung

namespace App\Tests\Service;

use App\Entity\Voucher;
use App\Service\VoucherRedeemer;
use PHPUnit\Framework\TestCase;

class VoucherRedeemerTest extends TestCase
{
    public function testVoucherCanBeRedeemed(): void
    {
        $voucher = new Voucher();
        $voucher->setValidFrom(new \DateTime('-1 day'));
        $voucher->setValidUntil(new \DateTime('+1 day'));
        $voucher->setMaxRedemptions(1);

        $redeemer = new VoucherRedeemer();
        $redeemer->redeem($voucher, new \DateTime());

        $this->assertSame(1, $voucher->getRedeemedCount());
    }
}
