<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todolist;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Todolist::class);
    }
}
