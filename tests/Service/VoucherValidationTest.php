<?php

namespace App\Tests\Service;

use App\Entity\Voucher;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VoucherValidationTest extends KernelTestCase
{
    public function testVoucherValidationFails(): void
    {
        self::bootKernel();
        $validator = self::$container->get('validator');

        $voucher = new Voucher();
        $voucher->setCode(''); // Fehler
        $voucher->setType('invalid'); // Fehler
        $voucher->setValue(-5); // Fehler
        $voucher->setValidFrom(new \DateTime('+1 day'));
        $voucher->setValidUntil(new \DateTime('-1 day'));
        $voucher->setMaxRedemptions(0);

        $errors = $validator->validate($voucher);

        $this->assertGreaterThan(0, count($errors));
    }
}
