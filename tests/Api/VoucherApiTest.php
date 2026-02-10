<?php  
//  API-Test: Gutschein anlegen
class VoucherApiTest extends ApiTestCase
{
    public function testCreateVoucher(): void
    {
        static::createClient()->request('POST', '/api/vouchers', [
            'json' => [
                'code' => 'TEST10',
                'type' => 'percent',
                'value' => 10,
                'validFrom' => '2026-01-01T00:00:00',
                'validUntil' => '2026-12-31T23:59:59',
                'multiUse' => false,
                'maxRedemptions' => 1
            ],
            'headers' => [
                'Authorization' => 'Bearer test-token'
            ]
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertJsonContains(['code' => 'TEST10']);
    }
}

//API-Test: Gutschein einlosen

public function testRedeemVoucher(): void
{
    $client = static::createClient();

    $client->request('PATCH', '/api/vouchers/1/redeem', [
        'headers' => ['Authorization' => 'Bearer test-token']
    ]);

    self::assertResponseIsSuccessful();
}
