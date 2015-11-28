<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('role')->insert([
        'role_id' => 1,
        'name' => "registered",
        'description' => "Basic role",
    ]);

    DB::table('role')->insert([
        'role_id' => 2,
        'name' => "circle",
        'description' => "Circel role",
    ]);

    DB::table('role')->insert([
        'role_id' => 3,
        'name' => "square",
        'description' => "Square role",
    ]);

    DB::table('role')->insert([
        'role_id' => 4,
        'name' => "root",
        'description' => "Root role",
    ]);
  }

}