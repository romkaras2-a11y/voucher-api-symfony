<?php //Datenmodell  Entity: Voucher

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'vouchers')]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Patch(
            uriTemplate: '/vouchers/{id}/redeem',
            controller: App\Controller\RedeemVoucherController::class,
            name: 'redeem_voucher'
        )
    ]
)]



class Voucher
{
    #[ORM\Column(unique: true, length: 100)]
    #[Assert\NotBlank(message: "Code darf nicht leer sein.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "Code darf maximal {{ limit }} Zeichen lang sein."
    )]
    private string $code;

    #[ORM\Column(length: 10)]
    #[Assert\Choice(
        choices: ['amount', 'percent'],
        message: "Typ muss 'amount' oder 'percent' sein."
    )]
    private string $type;

    #[ORM\Column]
    #[Assert\Positive(message: "Wert muss gro?er als 0 sein.")]
    private float $value;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "validFrom muss gesetzt sein.")]
    private \DateTimeInterface $validFrom;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "validUntil muss gesetzt sein.")]
    private \DateTimeInterface $validUntil;

    #[ORM\Column]
    private bool $multiUse = false;

    #[ORM\Column]
    #[Assert\Positive(message: "maxRedemptions muss gro?er als 0 sein.")]
    private int $maxRedemptions = 1;

    #[ORM\Column]
    private int $redeemedCount = 0;

    // Getter & Setter
}


