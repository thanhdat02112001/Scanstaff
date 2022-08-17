<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if table is empty
        if (Language::count() == 0) {
            $languages = [
                [
                    'name' => 'JavaScript',
                    'mode' => 'javascript'

                ],
                [
                    'name' => 'PHP',
                    'mode' => 'application/x-httpd-php'
                ],
                [
                    'name' => 'Ruby',
                    'mode' => 'text/x-ruby'
                ],
                [
                    'name' => 'Python',
                    'mode' => 'text/x-python'
                ],
                [
                    'name' => 'Python3',
                    'mode' => 'text/x-python'
                ],
                [
                    'name' => 'Java',
                    'mode' => 'text/x-java'
                ],
            ];

            foreach ($languages as $language) {
                Language::create($language);
            }
        }
    }
}
