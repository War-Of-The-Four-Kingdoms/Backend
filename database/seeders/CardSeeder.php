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
            ['name' => 'ถุงมือขนหมีควาย','code' => '10','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'bear_glove', 'image' => 'bear_glove.png'],
            ['name' => 'แส้หนามพริ้วสะบัด','code' => 'Q','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'thorn_whip', 'image' => 'thorn_whip.png'],
            ['name' => 'ชิลค์เบรกเกอร์','code' => '6','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'shield_breaker', 'image' => 'shield_breaker.png'],
            ['name' => 'สนับมือยางยืด','code' => 'Q','symbol' => 'club','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'elastic_knuckle', 'image' => 'elastic_knuckle.png'],
            ['name' => 'คฑาดาวตก','code' => '4','symbol' => 'club','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'meteor_staff', 'image' => 'meteor_staff.png'],
            ['name' => 'ไม้หน้าสาม','code' => '10','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'wooden_club', 'image' => 'wooden_club1.png'],
            ['name' => 'ไม้หน้าสาม','code' => '7','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'wooden_club', 'image' => 'wooden_club2.png'],
            ['name' => 'ดาบบินคู่หนวดเขี้ยว','code' => '8','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'flying_sword', 'image' => 'flying_sword.png'],
            ['name' => 'ดาบผู้ล่ำซัม','code' => '6','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 2,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'richman_sword', 'image' => 'richman_sword.png'],
            ['name' => 'ฉมวกล่าเนื้อ','code' => '2','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 3,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'weapon','item_name' => 'hunting_harpoon', 'image' => 'hunting_harpoon.png'],
            //- Armor
            ['name' => 'เกราะโซ่อัศวิน','code' => '8','symbol' => 'club','type' => 'equipment','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'knight_chainmail', 'image' => 'knight_chainmail.png'],
            ['name' => 'เกราะโซ่อัศวิน','code' => '13','symbol' => 'spade','type' => 'equipment','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'knight_chainmail', 'image' => 'knight_chainmail1.png'],
            ['name' => 'กระทะ','code' => 'J','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'armor','item_name' => 'frying_pan', 'image' => 'frying_pan.png'],
            //- Mount
            ['name' => 'บิ๊กไบค์','code' => '7','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'bigbike', 'image' => 'bigbike.png'],
            ['name' => 'ซุปเปอร์คาร์ ','code' => '4','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'supercar', 'image' => 'supercar.png'],
            ['name' => 'สปีดโบ๊ท','code' => '8','symbol' => 'diamond','type' => 'equipment','decision' => false,'distance' => 1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'speedboat', 'image' => 'speedboat.png'],
            ['name' => 'จักรยาน','code' => '3','symbol' => 'spade','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'bicycle', 'image' => 'bicycle.png'],
            ['name' => 'รถถัง','code' => 'K','symbol' => 'club','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'tank', 'image' => 'tank.png'],
            ['name' => 'สิบล้อ','code' => '5','symbol' => 'heart','type' => 'equipment','decision' => false,'distance' => -1,'affected_gender' => 'all','immediately' => false,'equipment_type' => 'mount','item_name' => 'truck', 'image' => 'truck.png'],
            //Trick
            ['name' => 'กองโจรซุ่มตี','code' => 'K','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush', 'image' => 'ambush1.png'],
            ['name' => 'กองโจรซุ่มตี','code' => '10','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush', 'image' => 'ambush2.png'],
            ['name' => 'กองโจรซุ่มตี','code' => 'A','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'ambush', 'image' => 'ambush3.png'],
            ['name' => 'ท้าดวล','code' => '8','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel', 'image' => 'duel1.png'],
            ['name' => 'ท้าดวล','code' => '9','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel', 'image' => 'duel2.png'],
            ['name' => 'ท้าดวล','code' => '6','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'duel', 'image' => 'duel3.png'],
            ['name' => 'ยืมดาบฆ่าคน','code' => 'Q','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'hitman', 'image' => 'hitman1.png'],
            ['name' => 'ยืมดาบฆ่าคน','code' => '2','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'hitman', 'image' => 'hitman2.png'],
            ['name' => 'จิบชา','code' => '4','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'teatime', 'image' => 'teatime.png'],
            ['name' => 'ตบทรัพย์','code' => '2','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal', 'image' => 'steal1.png'],
            ['name' => 'ตบทรัพย์','code' => 'K','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal', 'image' => 'steal2.png'],
            ['name' => 'ตบทรัพย์','code' => '3','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal', 'image' => 'steal3.png'],
            ['name' => 'ตบทรัพย์','code' => '5','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal', 'image' => 'steal4.png'],
            ['name' => 'ตบทรัพย์','code' => 'J','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'steal', 'image' => 'steal5.png'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '5','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter', 'image' => 'callcenter1.png'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '7','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter', 'image' => 'callcenter2.png'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => 'K','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter', 'image' => 'callcenter3.png'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '2','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter', 'image' => 'callcenter4.png'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '8','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter', 'image' => 'callcenter5.png'],
            ['name' => 'แก๊งคอลเซ็นเตอร์','code' => '5','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'callcenter', 'image' => 'callcenter6.png'],
            ['name' => 'แบล็ค คิง บาร์','code' => 'A','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb', 'image' => 'bkb1.png'],
            ['name' => 'แบล็ค คิง บาร์','code' => '10','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb', 'image' => 'bkb2.png'],
            ['name' => 'แบล็ค คิง บาร์','code' => '4','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb', 'image' => 'bkb3.png'],
            ['name' => 'แบล็ค คิง บาร์','code' => '2','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'bkb', 'image' => 'bkb4.png'],
            ['name' => 'รัสเซียน รูเล็ต ','code' => '8','symbol' => 'diamond','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'russianroulette', 'image' => 'russianroulette1.png'],
            ['name' => 'รัสเซียน รูเล็ต ','code' => '10','symbol' => 'club','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'russianroulette', 'image' => 'russianroulette2.png'],
            ['name' => 'ห่าฝนธนูเพลิง','code' => '5','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'arrowshower', 'image' => 'arrowshower.png'],
            ['name' => 'งานสังสรรค์ของผู้คน ','code' => '8','symbol' => 'diamond','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'banquet', 'image' => 'banquet1.png'],
            ['name' => 'งานสังสรรค์ของผู้คน ','code' => '10','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'banquet', 'image' => 'banquet2.png'],
            ['name' => 'สอนเชิง ','code' => '5','symbol' => 'club','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching', 'image' => 'coaching1.png'],
            ['name' => 'สอนเชิง ','code' => '4','symbol' => 'heart','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching', 'image' => 'coaching2.png'],
            ['name' => 'สอนเชิง ','code' => '8','symbol' => 'diamond','type' => 'trick','decision' => true,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'coaching', 'image' => 'coaching3.png'],
            ['name' => 'ไหจอมละโมบ','code' => 'K','symbol' => 'club','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot', 'image' => 'greedypot1.png'],
            ['name' => 'ไหจอมละโมบ','code' => '7','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot', 'image' => 'greedypot2.png'],
            ['name' => 'ไหจอมละโมบ','code' => '5','symbol' => 'spade','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot', 'image' => 'greedypot3.png'],
            ['name' => 'ไหจอมละโมบ','code' => 'J','symbol' => 'heart','type' => 'trick','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'greedypot', 'image' => 'greedypot4.png'],
            //Active
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack1.png'],
            ['name' => 'โจมตี','code' => 'A','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack2.png'],
            ['name' => 'โจมตี','code' => 'J','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack3.png'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack4.png'],
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack5.png'],
            ['name' => 'โจมตี','code' => '7','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack6.png'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack7.png'],
            ['name' => 'โจมตี','code' => '2','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack8.png'],
            ['name' => 'โจมตี','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack9.png'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack10.png'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack11.png'],
            ['name' => 'โจมตี','code' => '6','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack12.png'],
            ['name' => 'โจมตี','code' => '10','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack13.png'],
            ['name' => 'โจมตี','code' => 'K','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack14.png'],
            ['name' => 'โจมตี','code' => 'Q','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack15.png'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack16.png'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack17.png'],
            ['name' => 'โจมตี','code' => '2','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack18.png'],
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack19.png'],
            ['name' => 'โจมตี','code' => '9','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack20.png'],
            ['name' => 'โจมตี','code' => '8','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack21.png'],
            ['name' => 'โจมตี','code' => '8','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack22.png'],
            ['name' => 'โจมตี','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack23.png'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack24.png'],
            ['name' => 'โจมตี','code' => '5','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack25.png'],
            ['name' => 'โจมตี','code' => '3','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack26.png'],
            ['name' => 'โจมตี','code' => '4','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack27.png'],
            ['name' => 'โจมตี','code' => '8','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack28.png'],
            ['name' => 'โจมตี','code' => 'J','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack29.png'],
            ['name' => 'โจมตี','code' => '6','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => false,'equipment_type' => null,'item_name' => 'attack', 'image' => 'attack30.png'],
            ['name' => 'ป้องกัน','code' => '8','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense1.png'],
            ['name' => 'ป้องกัน','code' => 'A','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense2.png'],
            ['name' => 'ป้องกัน','code' => '2','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense3.png'],
            ['name' => 'ป้องกัน','code' => '2','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense4.png'],
            ['name' => 'ป้องกัน','code' => '8','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense5.png'],
            ['name' => 'ป้องกัน','code' => 'K','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense6.png'],
            ['name' => 'ป้องกัน','code' => '10','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense7.png'],
            ['name' => 'ป้องกัน','code' => '5','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense8.png'],
            ['name' => 'ป้องกัน','code' => '10','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense9.png'],
            ['name' => 'ป้องกัน','code' => '6','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense10.png'],
            ['name' => 'ป้องกัน','code' => '3','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense11.png'],
            ['name' => 'ป้องกัน','code' => 'J','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense12.png'],
            ['name' => 'ป้องกัน','code' => '4','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense13.png'],
            ['name' => 'ป้องกัน','code' => '9','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense14.png'],
            ['name' => 'ป้องกัน','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'defense', 'image' => 'defense15.png'],
            ['name' => 'ฟื้นฟู','code' => '10','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal1.png'],
            ['name' => 'ฟื้นฟู','code' => 'Q','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal2.png'],
            ['name' => 'ฟื้นฟู','code' => '3','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal3.png'],
            ['name' => 'ฟื้นฟู','code' => 'K','symbol' => 'club','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal4.png'],
            ['name' => 'ฟื้นฟู','code' => '6','symbol' => 'heart','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal5.png'],
            ['name' => 'ฟื้นฟู','code' => '2','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal6.png'],
            ['name' => 'ฟื้นฟู','code' => '6','symbol' => 'diamond','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal7.png'],
            ['name' => 'ฟื้นฟู','code' => 'A','symbol' => 'spade','type' => 'active','decision' => false,'distance' => 0,'affected_gender' => 'all','immediately' => true,'equipment_type' => null,'item_name' => 'heal', 'image' => 'heal8.png'],
        ]);
    }
}
