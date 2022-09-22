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
            ['name' => 'เวตาล', 'tribe' => 'demon', 'hp' => 3,'gender' => 'male','is_leader' => false],
            ['name' => 'ปีศาจผีเสี่ยงโชค', 'tribe' => 'demon', 'hp' => 4,'gender' => 'female','is_leader' => false],
            ['name' => 'นินจากัปปะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'แม่มดนอกรีต', 'tribe' => 'demon', 'hp' => 3,'gender' => 'female','is_leader' => false],
            ['name' => 'ลูซิเฟอร์', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'ผีอัศวินสีชาด', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'ราชาปีศาจภูตะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => true],
            //Robot
            ['name' => 'หุ่นรบสนับสนุน โรเซ่', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false],
            ['name' => 'หุ่นรบสอดแนม ไซเฟอร์', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false],
            ['name' => 'หุ่นรบแฝงตัว เซฟีร่า', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false],
            ['name' => 'หุ่นรบปีนใหญ่ คราเคน', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false],
            ['name' => 'หุ่นรบเกราะหนัก จีเน็กซ์', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'หุ่นรบซามูไร กาม่อน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'หุ่นรบพิฆาต ไอร่อน ซี', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'ไซบอร์กนักวางแผน คาร์ลเซน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => true],
            //Animal
            ['name' => 'ฟ๊อกเซีย', 'tribe' => 'animal', 'hp' => 3,'gender' => 'female','is_leader' => false],
            ['name' => 'โอลลิเวอร์', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false],
            ['name' => 'แบริล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'สเนล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'พ็อคกี้', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'เมอกวิ้น', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false],
            ['name' => 'ซีลกาเมซ', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => true],
            //Human
            ['name' => 'ไน้ เดอะ โจ๊กเกอร์', 'tribe' => 'human', 'hp' => 3,'gender' => 'male','is_leader' => false],
            ['name' => 'โรเจอร์ คิง ออฟ ไพเรท', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'ฟลอเรน ไนติงเกล', 'tribe' => 'human', 'hp' => 3,'gender' => 'female','is_leader' => false],
            ['name' => 'มาติน สกอเปี้ยน', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false],
            ['name' => 'ลีเจี้ยน คอมมานเดอร์', 'tribe' => 'human', 'hp' => 6,'gender' => 'male','is_leader' => true],
        ]);
    }
}
