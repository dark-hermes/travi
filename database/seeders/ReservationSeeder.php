<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $start = 4;
        $end = 13;
        $statuses = ['pending', 'paid', 'canceled', 'finished'];

        for ($i = $start; $i <= $end; $i++) {
            $customer = Customer::findOrfail($i);
            $tourPackage = TourPackage::findOrfail($i);
            $status = $statuses[array_rand($statuses)];
            $reservation = Reservation::create([
                'customer_id' => $customer->id,
                'tour_package_id' => $tourPackage->id,
                // Random from now
                'date' => now()->addDays(random_int(1, 30)),
                'status' => $status,
                'payment_evidence' => $status === 'paid' || $status === 'finished' ? fake()->image() : null,
                'payment_date' =>  $status === 'paid' || $status === 'finished' ? now() : null,
                'price' => $tourPackage->price,
                'quantity' => random_int(1, 5),
                'discount' => $tourPackage->discount,
            ]);
        }
    }
}
