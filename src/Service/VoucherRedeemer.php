<?php // Service: VoucherRedeemer 

namespace App\Service;

use App\Entity\Voucher;
use App\Repository\VoucherRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\VoucherException;

class VoucherRedeemer
{
    private EntityManagerInterface $em;
    private VoucherRepository $voucherRepo;

    public function __construct(EntityManagerInterface $em, VoucherRepository $voucherRepo)
    {
        $this->em = $em;
        $this->voucherRepo = $voucherRepo;
    }

    /**
     * Gutschein einlösen
     *
     * @param string $code
     * @return Voucher
     * @throws VoucherException
     */
    public function redeem(string $code): Voucher
    {
        $voucher = $this->voucherRepo->findOneBy(['code' => $code]);

        if (!$voucher) {
            throw new VoucherException("Voucher not found.");
        }

        if (!$voucher->isValid()) {
            throw new VoucherException("Voucher is expired or not yet valid.");
        }

        if (!$voucher->canBeRedeemed()) {
            throw new VoucherException("Voucher cannot be redeemed (max redemptions reached).");
        }

        // idempotent: nur erhöhen, wenn noch nicht maximal
        if ($voucher->getCurrentRedemptions() < $voucher->getMaxRedemptions() || $voucher->isMultiUse()) {
            $voucher->incrementRedemptions();
            $this->em->persist($voucher);
            $this->em->flush();
        }

        return $voucher;
    }

    /**
     * Alle Gutscheine auflisten
     *
     * @return Voucher[]
     */
    public function listAll(): array
    {
        return $this->voucherRepo->findAll();
    }

    /**
     * Gutschein erstellen
     *
     * @param array $data
     * @return Voucher
     */
    public function create(array $data): Voucher
    {
        $voucher = new Voucher();
        $voucher->setCode($data['code']);
        $voucher->setType($data['type']);
        $voucher->setValue($data['value']);
        $voucher->setValidFrom($data['validFrom']);
        $voucher->setValidUntil($data['validUntil']);
        $voucher->setMultiUse($data['multiUse'] ?? false);
        $voucher->setMaxRedemptions($data['maxRedemptions'] ?? 1);

        $this->em->persist($voucher);
        $this->em->flush();

        return $voucher;
    }

    /**
     * Details eines Gutscheins abrufen
     */
    public function getVoucher(string $code): Voucher
    {
        $voucher = $this->voucherRepo->findOneBy(['code' => $code]);
        if (!$voucher) {
            throw new VoucherException("Voucher not found.");
        }
        return $voucher;
    }
}
