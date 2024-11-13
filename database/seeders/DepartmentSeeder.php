<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->delete();
        $departments = array(
          
            array(  'name' => "Vue" ,'team_id' => Team::first()->id,),
            array( 'name' => "Laravel",'team_id' => Team::first()->id),
        );
        DB::table('departments')->insert($departments);
    }
}
