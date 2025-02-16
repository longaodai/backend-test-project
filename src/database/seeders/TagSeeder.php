<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listTag = ['BTP', 'BtoB'];

        foreach ($listTag as $tag) {
            Tag::updateOrCreate(
                ['name' => $tag],
                [
                    'name' => $tag,
                ]
            );
        }
    }
}
