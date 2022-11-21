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
            ['name' => 'เวตาล', 'tribe' => 'demon', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'vetala.png','char_name'=>'vetala'],
            ['name' => 'ปีศาจผีเสี่ยงโชค', 'tribe' => 'demon', 'hp' => 4,'gender' => 'female','is_leader' => false,'image_name' => 'luckyghost.png','char_name'=>'luckyghost'],
            ['name' => 'นินจากัปปะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'ninjakappa.png','char_name'=>'ninjakappa'],
            ['name' => 'แม่มดนอกรีต', 'tribe' => 'demon', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'witch.png','char_name'=>'witch'],
            ['name' => 'ลูซิเฟอร์', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'lucifer.png','char_name'=>'lucifer'],
            ['name' => 'ผีอัศวินสีชาด', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bloodyknight.png','char_name'=>'bloodyknight'],
            ['name' => 'ราชาปีศาจภูตะ', 'tribe' => 'demon', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'puta.png','char_name'=>'puta'],
            //Robot
            ['name' => 'หุ่นรบสนับสนุน โรเซ่', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'rose.png','char_name'=>'rose'],
            ['name' => 'หุ่นรบสอดแนม ไซเฟอร์', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'cipher.png','char_name'=>'cipher'],
            ['name' => 'หุ่นรบแฝงตัว เซฟีร่า', 'tribe' => 'robot', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'sephira.png','char_name'=>'sephira'],
            ['name' => 'หุ่นรบปีนใหญ่ คราเคน', 'tribe' => 'robot', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'kraken.png','char_name'=>'kraken'],
            ['name' => 'หุ่นรบเกราะหนัก จีเน็กซ์', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'genex.png','char_name'=>'genex'],
            ['name' => 'หุ่นรบซามูไร กาม่อน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'gamon.png','char_name'=>'gamon'],
            ['name' => 'หุ่นรบพิฆาต ไอร่อน ซี', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'ironc.png','char_name'=>'ironc'],
            ['name' => 'ไซบอร์กนักวางแผน คาร์ลเซน', 'tribe' => 'robot', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'carlsen.png','char_name'=>'carlsen'],
            //Animal
            ['name' => 'ฟ๊อกเซีย', 'tribe' => 'animal', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'foxia.png','char_name'=>'foxia'],
            ['name' => 'โอลลิเวอร์', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'owliver.png','char_name'=>'owliver'],
            ['name' => 'แบริล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'bearyl.png','char_name'=>'bearyl'],
            ['name' => 'สเนล', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'snale.png','char_name'=>'snale'],
            ['name' => 'พ็อคกี้', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'porcky.png','char_name'=>'porcky'],
            ['name' => 'เมอกวิ้น', 'tribe' => 'animal', 'hp' => 3,'gender' => 'male','is_leader' => false,'image_name' => 'merguin.png','char_name'=>'merguin'],
            ['name' => 'ซีลกาเมซ', 'tribe' => 'animal', 'hp' => 4,'gender' => 'male','is_leader' => true,'image_name' => 'sealgamesh.png','char_name'=>'sealgamesh'],
            //Human
            ['name' => 'โรเจอร์ คิง ออฟ ไพเรท', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'roger.png','char_name'=>'roger'],
            ['name' => 'อสรพิษ นายอนเน่ห์', 'tribe' => 'human', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'nayeon.png','char_name'=>'nayeon'],
            ['name' => 'ฟลอเรน ไนติงเกล', 'tribe' => 'human', 'hp' => 3,'gender' => 'female','is_leader' => false,'image_name' => 'nightingale.png','char_name'=>'nightingale'],
            ['name' => 'มาติน สกอเปี้ยน', 'tribe' => 'human', 'hp' => 4,'gender' => 'male','is_leader' => false,'image_name' => 'martin.png','char_name'=>'martin'],
            ['name' => 'ลีเจี้ยน คอมมานเดอร์', 'tribe' => 'human', 'hp' => 6,'gender' => 'male','is_leader' => true,'image_name' => 'legioncommander.png','char_name'=>'legioncommander'],
        ]);
    }
}
