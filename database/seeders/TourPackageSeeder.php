<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tourPackages = [
            [
                'name' => 'Geyser Cisolok',
                'price' => 500000,
                'discount' => 0,
                'images' => ['https://th.bing.com/th/id/OIP.kvvku6j9KPWRPqlTKXoEKQHaFj?pid=ImgDet&rs=1','https://th.bing.com/th/id/R.88dd9b3f366a6e9d5827a2eedb8af012?rik=AoljlBJiX8Bdig&riu=http%3a%2f%2fsaig.upi.edu%2fwp-content%2fuploads%2f2018%2f11%2fWhatsApp-Image-2018-11-25-at-14.40.00-1.jpeg&ehk=gCLUC7GEtB9MWEBBjOP3gmj8QOplv1xlHuqeqhQNMjM%3d&risl=&pid=ImgRaw&r=0'],
                'facility' => '
                <ul>
                <li>Mini bus transportation</li>
                <li>Free toll</li>
                <li>Free snack</li>
                </ul>
                ',
                'description' => '
                The Cipanas Geyser tourist attraction, Cisolok District, Sukabumi Regency implements non-cash entry ticket payments. Now the entrance ticket payment of IDR 5,000 per person applies the Quick Response Code Indonesian Standard (QIRS).

                Geyser Cipanas tollgate coordinator Feby said the Qris system was used to make the transaction process easier and faster. The most important thing is that this system is connected directly to the regional treasury.

                According to Feby, the price of admission to the Cisolok Geyser is IDR 5,000 per person for various facilities including hot spring pools.
                '
            ],
            [
                'name' => 'Broken Beach',
                'price' => 4000000,
                'discount' => 8,
                'images' => ['https://1.bp.blogspot.com/-RKWtOdM67RQ/YGXzflr5COI/AAAAAAAABKQ/wq5FBddwo9kCqAKMsx1q5RyBiZ2E094rgCLcBGAsYHQ/s0/Fasilitas-Wisata-di-Nusa-Penida-Bali.jpg', 'https://tourbalimurah.id/wp-content/uploads/2022/03/serawan.-broken-beach.-eka-kusmawan-1024x683.jpg', 'https://tourbalimurah.id/wp-content/uploads/2022/03/broken-beach-nusa-penida-1-1024x767.jpg'],
                'facility' => '
                <ul>
                <li>Toilet</li>
                <li>Parking Area</li>
                <li>Local food</li>
                <li>Include Homestay</li>
                </ul>
                ',
                'description' => '
                <p>Broken Beach is about hollow corals that may have been created by centuries of abrasion. From above, this beach looks like a natural pool fortified by exotic cliffs. In one part of the cliff as high as 50-200 meters, there is a kind of tunnel for the sea water that floods it.

                For photography or selfie lovers, this is the best place to capture yourself. For those of you who like landscape photography, it\'s easy to find beautiful landscapes. Exotic describes its charm more, because the term "beach" here refers more to the natural boundary with steep cliffs that stretch.</p>
                '
            ],
            [
                'name' => 'Dieng Plateau',
                'price' => 2000000,
                'discount' => 10,
                'images' => ['https://2.bp.blogspot.com/_MavpjI2K-6Q/TFpUbcBgZ_I/AAAAAAAAACM/gmH7oLAWbQU/s1600/candi-dieng.jpg', 'https://th.bing.com/th/id/OIP.d6HMeOWFzdF3cy_fycgN1QHaFj?pid=ImgDet&w=1024&h=768&rs=1', 'https://th.bing.com/th/id/R.91873456662eeadc6f077ab44582c33e?rik=HLfWZ3s8tu2Xng&riu=http%3a%2f%2fwww.wisatadanhotelmurah.com%2fwp-content%2fuploads%2f2016%2f05%2fkawah-sikidang-obyek-wisata-dieng.jpg&ehk=HIjFEQNQ%2fwRtx8N5xOcX5TxwtU%2byG3HAQBCT9UdcaZk%3d&risl=&pid=ImgRaw&r=0'],
                'facility' => '
                <ul>
                <li>Toilet</li>
                <li>Parking Area</li>
                <li>Local food</li>
                <li>Include Homestay</li>
                </ul>
                ',
                'description' => '
                <p>Not only natural beauty, Dieng also offers historical tourist destinations that are no less interesting. Located in Dieng Kulon, Banjarnegara, Toppers can visit Arjuna Temple, an ancient relic from the Mataram Kingdom which was once built to worship Lord Shiva.

                There are five temples in the Arjuna Temple complex which are surrounded by beautiful grass and gardens.</p>
                '
            ]
        ];

        $repeat = 6;
        for ($i = 0; $i < $repeat; $i++) {
            foreach ($tourPackages as $tourPackage) {
                $tourPackageCreate = TourPackage::create([
                    'name' => $tourPackage['name'] . ' ' . $i,
                    'price' => $tourPackage['price'],
                    'discount' => $tourPackage['discount'],
                    'tourpackage-trixFields' => [
                        'content' => $tourPackage['description'],
                    ]
                ]);
                $tourPackageCreate->facility()->create([
                    'facility-trixFields' => [
                        'content' => $tourPackage['facility'],
                    ],
                ]);

                foreach ($tourPackage['images'] as $image) {
                    $tourPackageCreate->images()->create([
                        'path' => $image,
                    ]);
                }
            }
        }
    }
}
