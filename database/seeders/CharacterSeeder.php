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
            ['name' => 'เวตาล', 'tribe' => 'demon', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ปีศาจผีเสี่ยงโชค', 'tribe' => 'demon', 'hp' => 4,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'นินจากัปปะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'แม่มดนอกรีต', 'tribe' => 'demon', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ลูซิเฟอร์', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ผีอัศวินสีชาด', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ราชาปีศาจภูตะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            //Robot
            ['name' => 'หุ่นรบสนับสนุน โรเซ่', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'หุ่นรบสอดแนม ไซเฟอร์', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'หุ่นรบแฝงตัว เซฟีร่า', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'หุ่นรบปีนใหญ่ คราเคน', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'หุ่นรบเกราะหนัก จีเน็กซ์', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'หุ่นรบซามูไร กาม่อน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'หุ่นรบพิฆาต ไอร่อน ซี', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ไซบอร์กนักวางแผน คาร์ลเซน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            //Animal
            ['name' => 'ฟ๊อกเซีย', 'tribe' => 'animal', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'โอลลิเวอร์', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'แบริล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'สเนล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'พ็อคกี้', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'เมอกวิ้น', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ซีลกาเมซ', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            //Human
            ['name' => 'ไน้ เดอะ โจ๊กเกอร์', 'tribe' => 'human', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'โรเจอร์ คิง ออฟ ไพเรท', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ฟลอเรน ไนติงเกล', 'tribe' => 'human', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'มาติน สกอเปี้ยน', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
            ['name' => 'ลีเจี้ยน คอมมานเดอร์', 'tribe' => 'human', 'hp' => 6,'gender' => 'male','is_leader' => true,'image_name' => 'bearfighter.png','method_name'=>'vetala'],
        ]);
    }
}
