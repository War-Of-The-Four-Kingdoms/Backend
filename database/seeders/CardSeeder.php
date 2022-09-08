<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cards')->insert([
            //Equipment
            //- Weapon
            ['name' => 'ถุงมือขนหมีควาย','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'bear_glove'],
            ['name' => 'แส้หนามพริ้วสะบัด','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'thorn_whip'],
            ['name' => 'ชิลค์เบรกเกอร์','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'shield_breaker'],
            ['name' => 'สนับมือยางยืด','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'elastic_knuckle'],
            ['name' => 'คฑาดาวตก','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'meteor_staff'],
            ['name' => 'ไม้หน้าสาม','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'wooden_club'],
            ['name' => 'ดาบบินคู่หนวดเขี้ยว','type' => 'equipment','decision' => false,'distance' => 4,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'flying_sword'],
            ['name' => 'ดาบผู้ล่ำซัม','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'richman_sword'],
            ['name' => 'ฉมวกล่าเนื้อ','type' => 'equipment','decision' => false,'distance' => 5,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'hunting_harpoon'],
            //- Armor
            ['name' => 'เกราะโซ่อัศวิน','type' => 'equipment','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'knight_chainmail'],
            ['name' => 'กระทะ','type' => 'equipment','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'frying_pan'],
            //- Mount
            ['name' => 'บิ๊กไบค์','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'bigbike'],
            ['name' => 'ซุปเปอร์คาร์ ','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'supercar'],
            ['name' => 'สปีดโบ๊ท','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'speedboat'],
            ['name' => 'จักรยาน','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'bicycle'],
            ['name' => 'รถถัง','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'tank'],
            ['name' => 'สิบล้อ','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'truck'],
            //Trick
            ['name' => 'กองโจรซุ่มตี','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush'],
            ['name' => 'ท้าดวล','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel'],
            ['name' => 'ยืมดาบฆ่าคน','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'hitman'],
            ['name' => 'จิบชา','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'teatime'],
            ['name' => 'ตบทรัพย์','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แบล็ค คิง บาร์','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb'],
            ['name' => 'รัสเซียน รูเล็ต ','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'russianroulette'],
            ['name' => 'ห่าฝนธนูเพลิง','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'arrowshower'],
            ['name' => 'งานสังสรรค์ของผู้คน ','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'banquet'],
            ['name' => 'สอนเชิง ','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching'],
            ['name' => 'ไหจอมละโมบ','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot'],
            //Active
            ['name' => 'โจมตี','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'ป้องกัน','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ฟื้นฟู','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
        ]);
    }
}
