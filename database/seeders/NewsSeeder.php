<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Cisande Sukabumi Tourism Village, Animal Husbandry Education-Based Tourism Village',
                'news_category_id' => NewsCategory::where('name', 'News')->first()->id,
                'images' => [],
                'content' => '
                    <p>Writer Ni Nyoman Wira Widyanti | KOMPAS.com Editor Ni Nyoman Wira Widyanti - Cisande Tourism Village is a tourist village in Sukabumi Regency, West Java, which has potential in terms of animal husbandry education. When visiting this tourist village, tourists can take part in various educational activities, some of which are cultivating ornamental fish and catfish. During his visit on Sunday (5/9/2021), the Minister of Tourism and Creative Economy Sandiaga Uno suggested that the livestock education tour be expanded. "There is already a fishery here, then there is also agro-tourism, but animal husbandry is not complete. Therefore, I donated a pair of sheep to the Cisande Tourism Village so that they become capital for livestock education tourism," said Sandiaga, quoted from an official statement received by Kompas.com, Monday (6/9/2021). Apart from participating in livestock education activities, tourists can also decorate kites, plant rice, and experience outbound activities in the form of flying fox, archery, river tubing, and camping at the camping ground.</p>
                    <p>For tourists who like culinary tours, they can stop by the culinary park which contains angkringan and coffee shops, as well as cooking class facilities for traditional Cisande dishes. After the culinary tour, they can see the handicrafts of the residents of Cisande Village by visiting a flip-flops craft production house, a traditional Cisande game production house, a woven bamboo production house, abon catfish production house, a batik production house typical of Cicantayan District in Sukabumi, and pangsi typical clothing. .</p>
                    <p>Cisande Tourism Village also has an Opa-Oma marching band which has been around since 2015. Uniquely, the members of the marching band are on average 50-70 years old and had no experience as marching band players when they were young. The marching band is also one of the attractions of Cisande Tourism Village.</p>
                    <p>Reporting from Kompas.com, Monday (23/8/2021), ADWI is a competition initiated by the Ministry of Tourism and Creative Economy. A total of 1,831 tourist villages participated in this year\'s competition. Currently the Ministry of Tourism and Creative Economy and the Jury are visiting the 50 tourist villages.</p>
                ',
            ],
            [
                'title' => 'Inaugurated by Sandiaga Uno, This is the Best Tourism Village from Dieng',
                'news_category_id' => NewsCategory::where('name', 'News')->first()->id,
                'images' => ['https://akcdn.detik.net.id/community/media/visual/2021/10/07/sandiaga-uno-di-desa-dieng-kulon_169.jpeg','https://www.dieng.desa.id/desa/upload/artikel/sedang_1629768890_shutterstock_1125749261_Rifki_Alfirahman_3a5e6b967a.jpg', 'https://3.bp.blogspot.com/-rji6SYaGcok/XB8zp9AIBaI/AAAAAAAAQ4A/6RlpfBdPCCkxbx_M1y1FYaaVL8Vn-Ev-gCLcBGAs/s1600/dieng%2Bkulon.jpg'],
                'content' => '
                    <p>Banjarnegara - One of the tourist villages in the Dieng plateau is included in the top 50 best tourist villages in Indonesia. The inauguration was carried out directly by Menparekraf Sandiaga Uno.</p>
                    <p>The best tourist village in Dieng is Dieng Kulon Village, Batur District, Banjarnegara. The Minister of Tourism and Creative Economy/Head of the Tourism and Economy Agency (Menparekraf) Sandiaga Uno came directly to the village which is known as the country above the clouds.</p>
                    <p>Sandiaga was greeted with the art of the Lengger dance and the rampak yakso dance before entering the cultural house in the area of the Arjuna Temple complex. He also took the time to look at Dieng&apos;s tourism potential, such as the typical Dieng food, Mie Ongklok and temple-shaped homestays.</p>
                    <p>&quot;Congratulations to Dieng Kulon Village for being included in the top 50 best villages in Indonesia,&quot; he said when met at Dieng Kulon Village, Wednesday (6/10/2021).</p>
                    <p>Sandiaga said that the natural, cultural and culinary potentials in Dieng Kulon Village are the main attraction for tourists. Even the tourist area in Dieng Kulon Village is called like in Switzerland.</p>
                    <p>Dieng Kulon Village is one of the 50 best tourist villages in Indonesia. The 50 tourist villages have been filtered out of a total of 1831 tourist villages throughout Indonesia.</p>
                    <p>&quot;The jury team has come directly to Dieng. Hopefully this Dieng Kulon tourist village can win. There are 7 criteria that are assessed. Such as the presence of toilets, homestays, creative content and others,&quot; he explained.</p>
                    <p>&quot;The tourism potential here is extraordinary. From the natural, cultural and culinary potentials. My wife even said that it was similar to even more than in Switzerland,&quot; he said.</p>
                ',
            ],
            [
                'title' => 'Carangsari Bali Tourism Village, a Village with 14 Tourist Attractions',
                'news_category_id' => NewsCategory::where('name', 'News')->first()->id,
                'images' => ['https://asset.kompas.com/crops/87GEOvnuUSW06-NzTaHcIXCu6Wk=/0x0:1280x853/750x500/data/photo/2021/09/27/6151d6356be15.jpeg', 'https://asset.kompas.com/crops/7AXCB3SPPnOtYie6DKbnmyfg1WE=/2x0:1280x852/750x500/data/photo/2021/09/27/6151d5a11cbfc.jpeg', 'https://asset.kompas.com/crops/qW9Q6fLsMMZ7GL2xgSh2MHs0ePk=/0x0:1280x853/750x500/data/photo/2021/09/27/6151d5a1047da.jpeg', 'https://desawisatacarangsari.com/images/wisata/bali_cycling.jpg', 'https://desawisatacarangsari.com/images/wisata/rafting-true-bali.jpg'],
                'content' => '
                    <p>KOMPAS.com - Carangsari Tourism Village in Petang District, Badung Regency, Bali, is one of the selected tourist villages in the top 50 Indonesian Tourism Village Awards (ADWI) 2021. ADWI 2021 is a competition held by the Ministry of Tourism and Creative Economy (Kemenparekraf) . A total of 50 of the best tourist villages from various provinces in Indonesia have been selected. The 50 tourist villages are also being visited by the Minister of Tourism and Creative Economy (Menparekraf) Sandiaga Uno and the Jury Council.</p>
                    <p>Carangsari Tourism Village has 14 attractions for tourists, especially millennials who love nature tourism. The 14 attractions include the Ayung River, Yeh Penet, coffee plantations, rafting, flying fox, cycling and glamping (glamour camping). Apart from that, this tourist village is also the birthplace of the Indonesian National Hero, I Gusti Ngurah Rai. He died fighting the Dutch colonialists in the Puputan Margarana war on November 20, 1946.</p>
                    <p>Not only that, there is acculturation of Balinese and Chinese culture in the Carangsari Tourism Village. Cultural arts that tourists should not miss when visiting the tourist village are Paruwe shadow puppets, Ramoyane puppets, barongsai, Hanoman dance, Barangket, Balinese gamelan, Barong Landung, and the Tugek Carangsari mask dance.</p>
                    <p>The Tugek Carangsari mask dance was created and popularized by maestro I Gusti Ngurah Widya who is now 75 years old. He has worked overseas since the 1970s. After visiting the Carangsari Tourism Village, it&apos;s incomplete if you don&apos;t bring home souvenirs typical of the tourist village.</p>
                    <p><br></p>
                '
            ]
        ];

        foreach ($news as $new) {
            $newCreate = News::create([
                'title' => $new['title'],
                'news_category_id' => $new['news_category_id'],
                'content' => $new['content'],
            ]);
            foreach ($new['images'] as $image) {
                $newCreate->images()->create([
                    'path' => $image,
                ]);
            }
        }
    }
}
