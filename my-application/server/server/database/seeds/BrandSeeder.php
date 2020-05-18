<?php

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new Brand();
        $brand->name = 'Bic';
        $brand->save();
        // DB::table('brands')->insert([
        //     'name'=>'Bic',            
        // ]);
    }
}
