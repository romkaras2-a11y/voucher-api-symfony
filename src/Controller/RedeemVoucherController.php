<?php  //Controller: Gutschein einlosen


namespace App\Controller;

use App\Entity\Voucher;
use App\Service\VoucherRedeemer;
use Doctrine\ORM\EntityManagerInterface;

class RedeemVoucherController
{
    public function __construct(
        private VoucherRedeemer $redeemer,
        private EntityManagerInterface $em
    ) {}

    public function __invoke(Voucher $voucher): Voucher
    {
        $this->redeemer->redeem($voucher, new \DateTime());

        $this->em->flush();

        return $voucher;
    }
}

