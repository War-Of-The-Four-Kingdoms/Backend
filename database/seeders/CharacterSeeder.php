<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('characters')->insert([
            //Demon
            ['name' => 'เวตาล', 'tribe' => 'demon', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ปีศาจผีเสี่ยงโชค', 'tribe' => 'demon', 'hp' => 4,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'นินจากัปปะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'แม่มดนอกรีต', 'tribe' => 'demon', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ลูซิเฟอร์', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ผีอัศวินสีชาด', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ราชาปีศาจภูตะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png'],
            //Robot
            ['name' => 'หุ่นรบสนับสนุน โรเซ่', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'หุ่นรบสอดแนม ไซเฟอร์', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'หุ่นรบแฝงตัว เซฟีร่า', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'หุ่นรบปีนใหญ่ คราเคน', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'หุ่นรบเกราะหนัก จีเน็กซ์', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'หุ่นรบซามูไร กาม่อน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'หุ่นรบพิฆาต ไอร่อน ซี', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ไซบอร์กนักวางแผน คาร์ลเซน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png'],
            //Animal
            ['name' => 'ฟ๊อกเซีย', 'tribe' => 'animal', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'โอลลิเวอร์', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'แบริล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'สเนล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'พ็อคกี้', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'เมอกวิ้น', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ซีลกาเมซ', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png'],
            //Human
            ['name' => 'ไน้ เดอะ โจ๊กเกอร์', 'tribe' => 'human', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'โรเจอร์ คิง ออฟ ไพเรท', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ฟลอเรน ไนติงเกล', 'tribe' => 'human', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'มาติน สกอเปี้ยน', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png'],
            ['name' => 'ลีเจี้ยน คอมมานเดอร์', 'tribe' => 'human', 'hp' => 6,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png'],
        ]);
    }
}
