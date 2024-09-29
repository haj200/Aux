<?php

namespace Database\Seeders;

use App\Models\Entiteterritorielle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntiteterritorielleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entiteterritorielles = [
        [
            'Nom_Ar' => 'تملوكت',
            'Nom' => 'Tamellouket',
            'type' => 'Caidat',
            'managed_by'=> 1,
        ],
        [
            'Nom_Ar' => 'تملوكت',
            'Nom' => 'Tamellouket',
            'type' => 'Province',
            'managed_by'=> 2,
        ],
        [
            'Nom_Ar' => 'دائرة تارودانت',
            'Nom' => 'Cercle Taroudant',
            'type' => 'Cercle',
            'managed_by'=> 3,
        ],
        [
            'Nom_Ar' => 'باشوية تارودانت',
            'Nom' => 'Pachalik Taroudant',
            'type' => 'Pachalik',
            'managed_by'=> 4,
        ],
        [
            'Nom_Ar' => 'إيمولاس',
            'Nom' => 'Imoulace',
            'type' => 'Province',
            'managed_by'=> 5,
        ],
        [
            'Nom_Ar' => 'باشوية اولاد تايمة',
            'Nom' => 'Pachalik Oulad Tayma',
            'type' => 'Pachalik',
            'managed_by'=> 6,
        ],
        [
            'Nom_Ar' => 'تافراوتن',
            'Nom' => 'Tafraoun',
            'type' => 'Province',
            'managed_by'=> 7,
        ],
        [
            'Nom_Ar' => 'باشوية ايغرم',
            'Nom' => 'Pachalik Ighrem',
            'type' => 'Pachalik',
            'managed_by'=> 8,
        ],
        [
            'Nom_Ar' => 'ايت مخلوف',
            'Nom' => 'Ayt Makhlouf',
            'type' => 'Province',
            'managed_by'=> 9,
        ],
        [
            'Nom_Ar' => 'باشوية الكردان',
            'Nom' => 'Pachalik El Guerdan',
            'type' => 'Pachalik',
            'managed_by'=> 10,
        ],
        [
            'Nom_Ar' => 'سيدي دحمان',
            'Nom' => 'Sidi Dehmane',
            'type' => 'Province',
            'managed_by'=> 11,
        ],
        [
            'Nom_Ar' => 'افريجة',
            'Nom' => 'Frija',
            'type' => 'Province',
            'managed_by'=> 12,
        ],
        [
            'Nom_Ar' => 'افريجة',
            'Nom' => 'Frija',
            'type' => 'Caidat',
            'managed_by'=> 13,
        ],
        [
            'Nom_Ar' => 'باشوية اولاد برحيل',
            'Nom' => 'Pachalik Oulad Berhil',
            'type' => 'Pachalik',
            'managed_by'=> 14,
        ],
        [
            'Nom_Ar' => 'تيوت',
            'Nom' => 'Tayout',
            'type' => 'Province',
            'managed_by'=> 15,
        ],
        
        [
            'Nom_Ar' => 'باشوية تالوين',
            'Nom' => 'Pachalik Taliouine',
            'type' => 'Pachalik',
            'managed_by'=> 16,
        ],
        [
            'Nom_Ar' => 'سيدي احمد اوعبد الله',
            'Nom' => 'Sidi Ahmed Ou Abdellah',
            'type' => 'Province',
            'managed_by'=> 17,
        ],
        [
            'Nom_Ar' => 'باشوية أولوز',
            'Nom' => 'Pachalik Aoulouz',
            'type' => 'Pachalik',
            'managed_by'=> 18,
        ],
        [
            'Nom_Ar' => 'ايت ايكاس',
            'Nom' => 'Ayti Gas',
            'type' => 'Province',
            'managed_by'=> 19,
        ],
        [
            'Nom_Ar' => 'اسيدي مزال',
            'Nom' => 'Sidi Mzal',
            'type' => 'Province',
            'managed_by'=>20,
        ],
        [
            'Nom_Ar' => 'ايت عبد الله',
            'Nom' => 'Ayt Abdellah',
            'type' => 'Province',
            'managed_by'=> 21,
        ],
        [
            'Nom_Ar' => 'دائرة ايغرم',
            'Nom' => 'Cercle Ighrem',
            'type' => 'Cercle',
            'managed_by'=> 22,
        ],
        [
            'Nom_Ar' => 'تزمورت',
            'Nom' => 'Tazmourt',
            'type' => 'Caidat',
            'managed_by'=> 23,
        ],
        [
            'Nom_Ar' => 'تزمورت',
            'Nom' => 'Tazmourt',
            'type' => 'Province',
            'managed_by'=> 24,
        ],
        [
            'Nom_Ar' => 'تزمورت',
            'Nom' => 'Tazmourt',
            'type' => 'Province',
            'managed_by'=> 24,
        ],
        [
            'Nom_Ar' => 'ايت عبد الله',
            'Nom' => 'Ayt Abdellah',
            'type' => 'Province',
            'managed_by'=> 25,
        ],
        [
            'Nom_Ar' => 'سيدي بورجا',
            'Nom' => 'Sidi Bourja',
            'type' => 'Province',
            'managed_by'=> 26,
        ],
        [
            'Nom_Ar' => 'بونرار',
            'Nom' => 'Bounrar',
            'type' => 'Province',
            'managed_by'=> 27,
        ],
        [
            'Nom_Ar' => 'توفلعزت',
            'Nom' => 'Touflaazt',
            'type' => 'Province',
            'managed_by'=> 28,
        ],
        [
            'Nom_Ar' => 'تابيا',
            'Nom' => 'Tabia',
            'type' => 'Province',
            'managed_by'=> 29,
        ],
        [
            'Nom_Ar' => 'اولاد عيسى',
            'Nom' => 'Oulad Aissa',
            'type' => 'Province',
            'managed_by'=> 30,
        ],
        [
            'Nom_Ar' => 'تومليلين',
            'Nom' => 'Toumiline',
            'type' => 'Province',
            'managed_by'=> 31,
            
        ],
        [
            'Nom_Ar' => 'اكلي',
            'Nom' => 'Igli',
            'type' => 'Caidat',
            'managed_by'=> 32,
        ],
        [
            'Nom_Ar' => 'اكلي',
            'Nom' => 'Igli',
            'type' => 'Province',
            'managed_by'=> 33,
        ],
        [
            'Nom_Ar' => 'دائرة أولاد برحيل',
            'Nom' => 'Cercle Oulald Berhil',
            'type' => 'Cercle',
            'managed_by'=> 34,
        ],
        [
            'Nom_Ar' => 'ايماون',
            'Nom' => 'Imaoun',
            'type' => 'Province',
            'managed_by'=> 35,
        ],
        [
            'Nom_Ar' => 'المكرث',
            'Nom' => 'El Mekret',
            'type' => 'Province',
            'managed_by'=> 36,
        ],
        [
            'Nom_Ar' => 'ادا وكيلال',
            'Nom' => 'Ida Ou Kilan',
            'type' => 'Province',
            'managed_by'=> 38,
        ],
        [
            'Nom_Ar' => 'تندين',
            'Nom' => 'Tetdin',
            'type' => 'Province',
            'managed_by'=> 39,
        ],
        [
            'Nom_Ar' => 'سيدي عبدالله اوسعيد',
            'Nom' => 'Sidi Abdellah Ou Saaid',
            'type' => 'Province',
            'managed_by'=> 40,
        ],
        [
            'Nom_Ar' => 'سيدي بوعل',
            'Nom' => 'Sidi Bouaal',
            'type' => 'Province',
            'managed_by'=> 41,
        ],
        [
            'Nom_Ar' => 'اكودار امنابها',
            'Nom' => 'Ougdar Imnabha',
            'type' => 'Province',
            'managed_by'=> 42,
        ],
        [
            'Nom_Ar' => 'سيدي عبد الله اوموسي',
            'Nom' => 'Sidi Abdellah Ou Moussa',
            'type' => 'Province',
            'managed_by'=> 43,
        ],
        [
            'Nom_Ar' => 'أملو',
            'Nom' => 'Amlou',
            'type' => 'Province',
            'managed_by'=> 44,
        ],
        [
            'Nom_Ar' => 'تنزرت',
            'Nom' => 'Tetzrt',
            'type' => 'Province',
            'managed_by'=> 45,
        ],
        [
            'Nom_Ar' => 'تتاوت',
            'Nom' => 'Tataout',
            'type' => 'Province',
            'managed_by'=> 46,
        ],
        [
            'Nom_Ar' => 'لمهارة',
            'Nom' => 'Lamhara',
            'type' => 'Province',
            'managed_by'=> 47,
        ],
        [
            'Nom_Ar' => 'ازغارنيرس',
            'Nom' => 'Azgharnis',
            'type' => 'Province',
            'managed_by'=> 48,
        ],
        [
            'Nom_Ar' => 'اضار',
            'Nom' => 'Addar',
            'type' => 'Province',
            'managed_by'=> 49,
        ],
        [
            'Nom_Ar' => 'تالكجونت',
            'Nom' => 'Talgjount',
            'type' => 'Province',
            'managed_by'=> 50,
        ],
        [
            'Nom_Ar' => 'تافنكولت',
            'Nom' => 'Tafnkoult',
            'type' => 'Province',
            'managed_by'=> 51,
        ],
        [
            'Nom_Ar' => 'امي نتيارت',
            'Nom' => 'Imi Ntyaret',
            'type' => 'Province',
            'managed_by'=> 52,
        ],
        [
            'Nom_Ar' => 'تيزي نتاست',
            'Nom' => 'Tizi Ntast',
            'type' => 'Province',
            'managed_by'=> 53,
        ],
        [
            'Nom_Ar' => 'اضار',
            'Nom' => 'Addar',
            'type' => 'Caidat',
            'managed_by'=> 54,
        ],
        [
            'Nom_Ar' => 'اوناين',
            'Nom' => 'Ounayen',
            'type' => 'Province',
            'managed_by'=> 55,
        ],
        [
            'Nom_Ar' => 'والقاضي',
            'Nom' => 'Oua EL Quadi',
            'type' => 'Caidat',
            'managed_by'=> 56,
        ],
        [
            'Nom_Ar' => 'والقاضي',
            'Nom' => 'Oua El Quadi',
            'type' => 'Province',
            'managed_by'=> 57,
        ],
        [
            'Nom_Ar' => 'تافنكولت',
            'Nom' => 'Tafnkoult',
            'type' => 'Caidat',
            'managed_by'=> 58,
        ],
        [
            'Nom_Ar' => 'تيسفان',
            'Nom' => 'Tisifane',
            'type' => 'Province',
            'managed_by'=> 59,
        ],
        [
            'Nom_Ar' => 'سيدي واعزيز',
            'Nom' => 'Sidi Oua Aziz',
            'type' => 'Province',
            'managed_by'=> 60,
        ],
        [
            'Nom_Ar' => 'النحيت',
            'Nom' => 'Ennahit',
            'type' => 'Province',
            'managed_by'=> 61,
        ],
        [
            'Nom_Ar' => 'تكوكة',
            'Nom' => 'Takouka',
            'type' => 'Province',
            'managed_by'=> 62,
        ],
        [
            'Nom_Ar' => 'أركانة',
            'Nom' => 'Argana',
            'type' => 'Caidat',
            'managed_by'=> 63,
        ],
        [
            'Nom_Ar' => 'أركانة',
            'Nom' => 'Argana',
            'type' => 'Province',
            'managed_by'=> 64,
        ],
        [
            'Nom_Ar' => 'سيدي موسي الحمري',
            'Nom' => 'Sidi Moussa El Hamri',
            'type' => 'Cercle',
            'managed_by'=> 65,
        ],
        [
            'Nom_Ar' => 'اداوكماض',
            'Nom' => 'Ida Ou Gemmas',
            'type' => 'Province',
            'managed_by'=> 66,
        ],
        [
            'Nom_Ar' => 'الفيض',
            'Nom' => 'El Fayd',
            'type' => 'Province',
            'managed_by'=> 67,
        ],
        [
            'Nom_Ar' => 'Bigoudin',
            'Nom' => 'Bigoudin',
            'type' => 'Province',
            'managed_by'=> 68,
        ],
        [
            'Nom_Ar' => 'الفيض',
            'Nom' => 'El Fayd',
            'type' => 'Caidat',
            'managed_by'=> 69,
        ],
        [
            'Nom_Ar' => 'تالمكانت',
            'Nom' => 'Talmgant',
            'type' => 'Province',
            'managed_by'=> 70,
        ],
        [
            'Nom_Ar' => 'ارزان',
            'Nom' => 'Irzan',
            'type' => 'Province',
            'managed_by'=> 71,
        ],
        [
            'Nom_Ar' => 'إميلمايس',
            'Nom' => 'Imilmacen',
            'type' => 'Province',
            'managed_by'=> 72,
        ],
        [
            'Nom_Ar' => 'توغمرت',
            'Nom' => 'Tougmaret',
            'type' => 'Province',
            'managed_by'=> 73,
        ],
        [
            'Nom_Ar' => 'أحمر لكلالشة',
            'Nom' => 'Ahmer Leklalcha',
            'type' => 'Province',
            'managed_by'=> 74,
        ],
        [
            'Nom_Ar' => 'احمر',
            'Nom' => 'Ahmer',
            'type' => 'Caidat',
            'managed_by'=> 75,
        ],
        [
            'Nom_Ar' => 'اوزيوة',
            'Nom' => 'Ouziouat',
            'type' => 'Caidat',
            'managed_by'=> 76,
        ],
        [
            'Nom_Ar' => 'اوزيوة',
            'Nom' => 'Ouziouat',
            'type' => 'Province',
            'managed_by'=> 77,
        ],
        [
            'Nom_Ar' => 'دائرة تالوين',
            'Nom' => 'Cercle Taliouine',
            'type' => 'Cercle',
            'managed_by'=> 78,
        ],
        [
            'Nom_Ar' => 'لمنيزلة',
            'Nom' => 'Lemnizla',
            'type' => 'Province',
            'managed_by'=> 79,
        ],
        [
            'Nom_Ar' => 'تيسراس',
            'Nom' => 'Tisras',
            'type' => 'Province',
            'managed_by'=> 80,
        ],
        [
            'Nom_Ar' => 'زاوية سيدي الطاهر',
            'Nom' => 'Zaouyat Sidi Ettaher',
            'type' => 'Province',
            'managed_by'=> 81,
        ],
        [
            'Nom_Ar' => 'تبقال',
            'Nom' => 'Toubqal',
            'type' => 'Province',
            'managed_by'=> 82 ,
        ],
        [
            'Nom_Ar' => 'ادا ومومن',
            'Nom' => 'Ida Ou Moumen',
            'type' => 'Province',
            'managed_by'=> 83,
        ],
        [
            'Nom_Ar' => 'اهل تفنوت',
            'Nom' => 'Ahel Tafnout',
            'type' => 'Province',
            'managed_by'=> 84,
        ],
        [
            'Nom_Ar' => 'اسن',
            'Nom' => 'Acen',
            'type' => 'Province',
            'managed_by'=> 85,
        ],
        [
            'Nom_Ar' => 'سيدي موسى الحمري',
            'Nom' => 'Sidi Moussa El Hamri',
            'type' => 'Caidat',
            'managed_by'=> 86,
        ],
        [
            'Nom_Ar' => 'إكيدي',
            'Nom' => 'Iguidi',
            'type' => 'Province',
            'managed_by'=> 87,
        ],
        [
            'Nom_Ar' => 'سيدي موسى الحمري',
            'Nom' => 'Sidi Moussa El Hamri',
            'type' => 'Province',
            'managed_by'=> 88,
        ],
        [
            'Nom_Ar' => 'تاويالت',
            'Nom' => 'Taouyalt',
            'type' => 'Province',
            'managed_by'=> 89,
        ],
        [
            'Nom_Ar' => 'اسكاون',
            'Nom' => 'Iskaoun',
            'type' => 'Province',
            'managed_by'=> 90,
        ],
        [
            'Nom_Ar' => 'الدير',
            'Nom' => 'Eddir',
            'type' => 'Province',
            'managed_by'=> 91,
        ],
        [
            'Nom_Ar' => 'أسكاون',
            'Nom' => 'Iskaoun',
            'type' => 'Caidat',
            'managed_by'=> 92,
        ],
        [
            'Nom_Ar' => 'سيدي بوموسى',
            'Nom' => 'Sidi Boumoussa',
            'type' => 'Province',
            'managed_by'=> 93,
        ],
        [
            'Nom_Ar' => 'عين شعيب',
            'Nom' => 'Ain Choaayeb',
            'type' => 'Province',
            'managed_by'=> 94,
        ],
        [
            'Nom_Ar' => 'دائرة أولاد تايمة',
            'Nom' => 'Cercle Oulad Tayma',
            'type' => 'Cercle',
            'managed_by'=> 95,
        ],
        [
            'Nom_Ar' => 'تسوسفي',
            'Nom' => 'Tsousfi',
            'type' => 'Province',
            'managed_by'=> 96,
        ],
        [
            'Nom_Ar' => 'سكتانة',
            'Nom' => 'Sktanat',
            'type' => 'Province',
            'managed_by'=> 97,
        ],
        [
            'Nom_Ar' => 'سيدي احمد اوعمر',
            'Nom' => 'Sidi Ahmed Ou Omar',
            'type' => 'Province',
            'managed_by'=> 98,
        ],
        [
            'Nom_Ar' => 'سيدي إحساين',
            'Nom' => 'Sidi Ihssayen',
            'type' => 'Province',
            'managed_by'=> 99,
        ],
        [
            'Nom_Ar' => 'الكفيفات',
            'Nom' => 'Legfifat',
            'type' => 'Province',
            'managed_by'=> 100,
        ],
        [
            'Nom_Ar' => 'اسايس',
            'Nom' => 'Assayes',
            'type' => 'Province',
            'managed_by'=> 101,
        ],
        [
            'Nom_Ar' => 'أهل الرمل',
            'Nom' => 'Ahel Errmel',
            'type' => 'Province',
            'managed_by'=> 102,
        ],
        [
            'Nom_Ar' => 'أكادير ملول',
            'Nom' => 'Agadir Melloul',
            'type' => 'Province',
            'managed_by'=> 103,
        ],
        [
            'Nom_Ar' => 'الكدية البيضاء',
            'Nom' => 'El Kodya El Hamra',
            'type' => 'Province',
            'managed_by'=> 104,
        ],
        [
            'Nom_Ar' => 'اولاد محلة',
            'Nom' => 'Oulad Mehlla',
            'type' => 'Province',
            'managed_by'=> 105,
        ],
        [
            'Nom_Ar' => 'اساكي',
            'Nom' => 'Asaki',
            'type' => 'Caidat',
            'managed_by'=> 106,
        ],
        [
            'Nom_Ar' => 'اساكي',
            'Nom' => 'Asaki',
            'type' => 'Province',
            'managed_by'=> 107,
        ],
        [
            'Nom_Ar' => 'الخنافيف',
            'Nom' => 'El Khnafif',
            'type' => 'Province',
            'managed_by'=> 108,
        ],
        [
            'Nom_Ar' => 'أزرار',
            'Nom' => 'Azrar',
            'type' => 'Province',
            'managed_by'=> 110,
        ],
        [
            'Nom_Ar' => 'لمهادي',
            'Nom' => 'Lemhadi',
            'type' => 'Province',
            'managed_by'=> 109,
        ],
        [
            'Nom_Ar' => 'تزكزاوين',
            'Nom' => 'Tezgzaouine',
            'type' => 'Province',
            'managed_by'=> 111,
        ],
        [
            'Nom_Ar' => 'تدسي نسندالن',
            'Nom' => 'Tdsi Nsndalen',
            'type' => 'Province',
            'managed_by'=> 112,
        ],
        [
            'Nom_Ar' => 'مشرع العين',
            'Nom' => 'Machroue El Ain',
            'type' => 'Province',
            'managed_by'=> 113,
        ],
        [
            'Nom_Ar' => 'زاكموزن',
            'Nom' => 'Zegmouzen',
            'type' => 'Province',
            'managed_by'=> 114,
        ],
        [
            'Nom_Ar' => 'اصادص',
            'Nom' => 'Asadess',
            'type' => 'Province',
            'managed_by'=> 115,
        ],
        [
            'Nom_Ar' => 'مشرع العين',
            'Nom' => 'Machroue El Ain',
            'type' => 'Caidat',
            'managed_by'=> 116,
        ],
        
        
        
        
        
        
        
        
        
        
        
    ];
    foreach ($entiteterritorielles as $entiteterritorielle) {
        Entiteterritorielle::create($entiteterritorielle);
    }
    }
}
