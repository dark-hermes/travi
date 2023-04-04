<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = [
            [
                'name' => 'Geyser Cisolok',
                'tour_category_id' => TourCategory::where('name', 'Family')->first()->id,
                'images' => ['https://akcdn.detik.net.id/community/media/visual/2017/10/12/df33d1c6-68e3-4d29-ab0f-e05cfa004b79.jpg'],
                'facility' => '
                <ul>
                <li>Hot water</li>
                <li>Waterfall</li>
                </ul>
                ',
                'description' => '
                Based on research by geologists, Cisolok Geyser is one of the few tourist attractions that has bursts of hot water and steam into the air directly from geothermal energy. The word Geyser itself comes from the Icelandic language geyser which means to spray.<br /><br />"Cisolok geyser is a hot spring located in the Ciletuh-Palabuhanratu UNESCO Global Geopark area which is enjoyed by the local people of Sukabumi and outside Sukabumi, with affordable prices. affordable and an increasingly comfortable place after the revitalization, making Geyser Cisolok the top choice for tourists who bring their families while soaking in natural hot springs," explained Sigit.</p>
                <p><br />Also read: Exciting, There\'s Instagramable Extreme Tourism in Kampung Awi<br />Ridwan Kamil\'s Vacation in Cisolok Photo: Instagram<br /><br />Read detikTravel\'s article, "5 Tourist Attractions in Sukabumi that makes the soul cool" in full&nbsp;<a href="https://travel.detik.com/domestic-destination/d-6002348/5-places-tourism-in-sukabumi-which-makes-soul-sejuk"> https://travel.detik.com/domestic-destination/d-6002348/5-place-wisata-di-sukabumi-yang-bikin-jiwa-sejuk</a>.<br /><br />Download Apps Detikcom Now https://apps.detik.com/detik/</p>
                '
            ],
            [
                'name' => 'Broken Beach',
                'tour_category_id' => TourCategory::where('name', 'Beach')->first()->id,
                'images' => ['https://nusapenida.org/wp-content/uploads/2018/06/Broken-Beach-Nusa-Penida-Bali.jpg', 'https://img.locationscout.net/images/2017-05/broken-beach-pasih-uug-nusa-penida-indonesia_l.jpeg'],
                'facility' => '',
                'description' => '
                <p>Broken Beach was formed due to the collapse of some of the cliffs. The collapsed part has a rounded shape. Then form an arch at the narrowest part of the sea. Overall, it looks like a circular bay with an arch leading to the sea. Bottom line, please look at the photos, it will be easier than trying to explain! The beach (which is very small) is not accessible. But maybe you can see the manta rays from the cliff.</p>
                '
            ],
            [
                'name' => 'Prau Mountain',
                'tour_category_id' => TourCategory::where('name', 'Mountain')->first()->id,
                'images' => ['https://th.bing.com/th/id/OIP.S8WcRQeXH99r6EIwYMVEJwHaFi?pid=ImgDet&rs=1'],
                'facility' => '',
                'description' => '
                <p>If Toppers likes to climb or have an adventurous spirit, Dieng has one of the most popular climbing destinations, namely Mount Prau.</p>
                <p>Having a peak at an altitude of 2,565 meters above sea level, this tourist destination in Dieng does not only offer fresh mountain air, but also beautiful natural panoramas from a height.</p>
                <p>Toppers can also enjoy the beauty of a romantic sunset moment at the top of Mount Prau, spend the night and get a view of the sunrise that is no less fantastic at this Dieng tourist spot.</p>
                '
            ]
        ];

        $repeat = 5;
        for ($i = 0; $i < $repeat; $i++) {
            foreach ($tours as $tour) {
                $tourCreate = Tour::create([
                    'name' => $tour['name'] . ' ' . $i,
                    'tour_category_id' => $tour['tour_category_id'],
                    'tour-trixFields' => [
                        'content' => $tour['description'],
                    ]
                ]);
                $tourCreate->facility()->create([
                    'facility-trixFields' => [
                        'content' => $tour['facility'],
                    ],
                ]);

                foreach ($tour['images'] as $image) {
                    $tourCreate->images()->create([
                        'path' => $image,
                    ]);
                }
            }
        }
    }
}
