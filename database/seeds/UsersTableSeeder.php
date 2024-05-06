<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users') -> insert(
        [
            'over_name' =>'姓',
            'under_name' =>'名',
            'over_name_kana' =>'セイ',
            'under_name_kana' =>'メイ',
            'mail_address' =>'test21@gmail.com',
            'sex' =>'1',
            'birth_day' =>'2000-01-01',
            'role' =>'1',
            'password' => bcrypt ('testtest1'),
            'created_at' =>'2000-01-01 00:00:01',
            'updated_at' =>'2000-01-01 00:00:02',
        ],
    );
    }
}
