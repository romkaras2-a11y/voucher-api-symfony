<?php  //Controller: Gutschein einlosen


namespace App\Controller;

use App\Service\VoucherRedeemer;
use App\Exception\VoucherException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

#[Route('/api/vouchers')]
class VoucherController extends AbstractController
{
    private VoucherRedeemer $redeemer;

    public function __construct(VoucherRedeemer $redeemer)
    {
        $this->redeemer = $redeemer;
    }

    /**
     * @OA\Post(
     *     path="/api/vouchers",
     *     summary="Erstellt einen neuen Gutschein",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="string"),
     *             @OA\Property(property="type", type="string", enum={"amount","percent"}),
     *             @OA\Property(property="value", type="number"),
     *             @OA\Property(property="validFrom", type="string", format="date-time"),
     *             @OA\Property(property="validUntil", type="string", format="date-time"),
     *             @OA\Property(property="multiUse", type="boolean"),
     *             @OA\Property(property="maxRedemptions", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Voucher erstellt"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    #[Route('', name: 'create_voucher', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $voucher = $this->redeemer->create([
                'code' => $data['code'],
                'type' => $data['type'],
                'value' => $data['value'],
                'validFrom' => new \DateTime($data['validFrom']),
                'validUntil' => new \DateTime($data['validUntil']),
                'multiUse' => $data['multiUse'] ?? false,
                'maxRedemptions' => $data['maxRedemptions'] ?? 1,
            ]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($voucher, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/vouchers",
     *     summary="Liste aller Gutscheine",
     *     @OA\Response(response=200, description="Liste der Gutscheine")
     * )
     */
    #[Route('', name: 'list_vouchers', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $vouchers = $this->redeemer->listAll();
        return $this->json($vouchers);
    }

    /**
     * @OA\Post(
     *     path="/api/vouchers/redeem",
     *     summary="Löst einen Gutschein ein",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Voucher eingelöst"),
     *     @OA\Response(response=400, description="Invalid voucher or already redeemed")
     * )
     */
    #[Route('/redeem', name: 'redeem_voucher', methods: ['POST'])]
    public function redeem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $voucher = $this->redeemer->redeem($data['code']);
        } catch (VoucherException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($voucher);
    }

    /**
     * @OA\Get(
     *     path="/api/vouchers/{code}",
     *     summary="Details eines Gutscheins abrufen",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Voucher Details"),
     *     @OA\Response(response=404, description="Voucher nicht gefunden")
     * )
     */
    #[Route('/{code}', name: 'get_voucher', methods: ['GET'])]
    public function getVoucher(string $code): JsonResponse
    {
        try {
            $voucher = $this->redeemer->getVoucher($code);
        } catch (VoucherException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json($voucher);
    }
}


