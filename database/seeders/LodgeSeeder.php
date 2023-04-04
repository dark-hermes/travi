<?php

namespace Database\Seeders;

use App\Models\Lodge;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LodgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lodges = [
            [
                'name' => 'Homestay Geopark Ciletuh',
                'images' => ['https://cf.bstatic.com/xdata/images/hotel/max1024x768/327290000.jpg?k=403a6e2f2fb008a700902e8ab9081ef2c0d05204709cc28d016671804bb5328c&o=&hp=1', 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/327290101.jpg?k=66927b4cbf7f7610c6471d421b8df42ea8bb2198d4c9108a38b1eb0c79e1b51b&o=&hp=1', 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/327290081.jpg?k=65342fbbcfd89f3e17184083a16e9b586e1b0621412bf71f4adffef734d3007b&o=&hp=1', 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/327290220.jpg?k=1518af7e6b60f1659df9f6aac5e425381cf55c3bac49cc7051d20f4ae4573362&o=&hp=1', 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/327290195.jpg?k=4c8ceaaa367bd14f297a9cb14b6b949c95d7ae2e9f13be22018ce8d0fb89790c&o=&hp=1'],
                'facility' => '
                <ul>
                <li>Free private parking</li>
                </ul>
                ',
                'description' => '
                Homestay Geopark Ciletuh is located in Cilowa. Set less than 1 km from Geopark Ciletuh White Sand Beach, the property offers a terrace and free private parking.
                '
            ],
            [
                'name' => 'Homestay Sopiah',
                'images' => ['https://cf.bstatic.com/xdata/images/hotel/max1024x768/442074983.jpg?k=5771734c9cc88d92e60ede337642d2303a30b20133a38f70346d9722d79f90bf&o=&hp=1', 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/442075031.jpg?k=ba622d33ada6e4130e995cf765a693c20ab95224817ed9d1244cf12330ff91d7&o=&hp=1'],
                'facility' => '
                <ul>
                <li>Free private parking</li>
                <li>Family Room</li>
                </ul>
                ',
                'description' => '
                <p>Homestay sopiah is set in Cilowa. Located 700 metres from Geopark Ciletuh White Sand Beach, the property provides a terrace and free private parking.
                <br>
                The air-conditioned holiday home consists of 1 bedroom, a kitchenette and 2 bathrooms. The holiday home also offers a seating area and 2 bathrooms.
                <br>
                The nearest airport is Halim Perdanakusuma International Airport, 169 km from the holiday home.</p>
                '
            ],
            [
                'name' => 'Kenanga Homestay Syariah',
                'images' => ['https://q-xx.bstatic.com/xdata/images/hotel/max1024x768/260061858.jpg?k=497bb9e46eb07eaeb88102795e2000addf1968ec449cb5eb8dfa3a1d3d497dbb&o=', 'https://q-xx.bstatic.com/xdata/images/hotel/max1024x768/260061591.jpg?k=2c6534f790f65ba929482708f955544a1442714a78f4a3045c1c2197d72cea1c&o='],
                'facility' => '
                <ul>
                <li>Free private parking</li>
                <li>Family Room</li>
                <li>Wifi</li>
                <li>Laundry</li>
                </ul>
                ',
                'description' => '
                <p>If Toppers likes to climb or have an adventurous spirit, Dieng has one of the most popular climbing destinations, namely Mount Prau.</p>
                <p>Having a peak at an altitude of 2,565 meters above sea level, this tourist destination in Dieng does not only offer fresh mountain air, but also beautiful natural panoramas from a height.</p>
                <p>Toppers can also enjoy the beauty of a romantic sunset moment at the top of Mount Prau, spend the night and get a view of the sunrise that is no less fantastic at this Dieng tourist spot.</p>
                '
            ]
        ];

        $repeat = 5;
        for ($i = 0; $i < $repeat; $i++) {
            foreach ($lodges as $lodge) {
                $lodgeCreate = Lodge::create([
                    'name' => $lodge['name'] . ' ' . $i,
                    'lodge-trixFields' => [
                        'content' => $lodge['description'],
                    ]
                ]);
                $lodgeCreate->facility()->create([
                    'facility-trixFields' => [
                        'content' => $lodge['facility'],
                    ],
                ]);

                foreach ($lodge['images'] as $image) {
                    $lodgeCreate->images()->create([
                        'path' => $image,
                    ]);
                }
            }
        }
    }
}
