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
            ['name' => 'ถุงมือขนหมีควาย','code' => '10','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'bear_glove'],
            ['name' => 'แส้หนามพริ้วสะบัด','code' => 'Q','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'thorn_whip'],
            ['name' => 'ชิลค์เบรกเกอร์','code' => '6','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'shield_breaker'],
            ['name' => 'สนับมือยางยืด','code' => 'Q','symbol' => 'club','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'elastic_knuckle'],
            ['name' => 'คฑาดาวตก','code' => '4','symbol' => 'club','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'meteor_staff'],
            ['name' => 'ไม้หน้าสาม','code' => '10','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'wooden_club'],
            ['name' => 'ไม้หน้าสาม','code' => '7','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'wooden_club'],
            ['name' => 'ดาบบินคู่หนวดเขี้ยว','code' => '8','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 4,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'flying_sword'],
            ['name' => 'ดาบผู้ล่ำซัม','code' => '6','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'richman_sword'],
            ['name' => 'ฉมวกล่าเนื้อ','code' => '2','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 5,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'hunting_harpoon'],
            //- Armor
            ['name' => 'เกราะโซ่อัศวิน','code' => '8','symbol' => 'club','type' => 'equipment','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'knight_chainmail'],
            ['name' => 'เกราะโซ่อัศวิน','code' => '13','symbol' => 'spade','type' => 'equipment','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'knight_chainmail'],
            ['name' => 'กระทะ','code' => 'J','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'frying_pan'],
            //- Mount
            ['name' => 'บิ๊กไบค์','code' => '7','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'bigbike'],
            ['name' => 'ซุปเปอร์คาร์ ','code' => '4','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'supercar'],
            ['name' => 'สปีดโบ๊ท','code' => '8','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'speedboat'],
            ['name' => 'จักรยาน','code' => '3','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'bicycle'],
            ['name' => 'รถถัง','code' => 'K','symbol' => 'club','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'tank'],
            ['name' => 'สิบล้อ','code' => '5','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'truck'],
            //Trick
            ['name' => 'กองโจรซุ่มตี','code' => 'K','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush'],
            ['name' => 'กองโจรซุ่มตี','code' => '10','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush'],
            ['name' => 'กองโจรซุ่มตี','code' => 'A','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush'],
            ['name' => 'ท้าดวล','code' => '8','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel'],
            ['name' => 'ท้าดวล','code' => '9','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel'],
            ['name' => 'ท้าดวล','code' => '6','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel'],
            ['name' => 'ยืมดาบฆ่าคน','code' => 'Q','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'hitman'],
            ['name' => 'ยืมดาบฆ่าคน','code' => '2','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'hitman'],
            ['name' => 'จิบชา','code' => '4','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'teatime'],
            ['name' => 'ตบทรัพย์','code' => '2','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal'],
            ['name' => 'ตบทรัพย์','code' => 'K','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal'],
            ['name' => 'ตบทรัพย์','code' => '3','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal'],
            ['name' => 'ตบทรัพย์','code' => '5','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal'],
            ['name' => 'ตบทรัพย์','code' => 'J','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '5','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '7','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => 'K','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '2','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '8','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '5','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter'],
            ['name' => 'แบล็ค คิง บาร์','code' => 'A','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb'],
            ['name' => 'แบล็ค คิง บาร์','code' => '10','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb'],
            ['name' => 'แบล็ค คิง บาร์','code' => '4','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb'],
            ['name' => 'แบล็ค คิง บาร์','code' => '2','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb'],
            ['name' => 'รัสเซียน รูเล็ต ','code' => '8','symbol' => 'diamond','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'russianroulette'],
            ['name' => 'รัสเซียน รูเล็ต ','code' => '10','symbol' => 'club','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'russianroulette'],
            ['name' => 'ห่าฝนธนูเพลิง','code' => '5','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'arrowshower'],
            ['name' => 'งานสังสรรค์ของผู้คน ','code' => '8','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'banquet'],
            ['name' => 'งานสังสรรค์ของผู้คน ','code' => '10','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'banquet'],
            ['name' => 'สอนเชิง ','code' => '5','symbol' => 'club','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching'],
            ['name' => 'สอนเชิง ','code' => '4','symbol' => 'heart','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching'],
            ['name' => 'สอนเชิง ','code' => '8','symbol' => 'diamond','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching'],
            ['name' => 'ไหจอมละโมบ','code' => 'K','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot'],
            ['name' => 'ไหจอมละโมบ','code' => '7','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot'],
            ['name' => 'ไหจอมละโมบ','code' => '5','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot'],
            ['name' => 'ไหจอมละโมบ','code' => 'J','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot'],
            //Active
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'A','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'J','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '7','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '2','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '6','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '10','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'K','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'Q','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '2','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '8','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '8','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '4','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '8','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => 'J','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'โจมตี','code' => '6','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack'],
            ['name' => 'ป้องกัน','code' => '8','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => 'A','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '2','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '2','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '8','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => 'K','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '10','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '5','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '10','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '6','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '3','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => 'J','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '4','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => '9','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ป้องกัน','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense'],
            ['name' => 'ฟื้นฟู','code' => '10','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => '3','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => 'K','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => '6','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => '2','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => '6','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
            ['name' => 'ฟื้นฟู','code' => 'A','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal'],
        ]);
    }
}
