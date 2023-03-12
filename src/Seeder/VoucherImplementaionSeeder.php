<?php

namespace Khaleds\Voucher\Seeder;

use Illuminate\Database\Seeder;
use Khaleds\Voucher\Models\VoucherImplementation;

class VoucherImplementaionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'id' => 1,
                'name' => "Default",
                'class' => 'Khaleds\Voucher\Services\DefaultVoucher',
                'value' => [
                    "key" => [
                        [
                            "name" => "user",
                            "usable_type" => "App/Model/User"
                        ]
                    ]

                ]
            ]
        ];
        foreach ($rows as $item) {
            $model = VoucherImplementation::find(1);
            if ($model) {
                $model->update($item);
            } else {
                VoucherImplementation::create($item);
            }
        }
    }
}
