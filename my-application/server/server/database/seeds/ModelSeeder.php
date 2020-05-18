<?php

use App\Models\ModelM;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $brand = DB::table('brands')->first();
        $model = new ModelM();
        $model->name = 'Standard';
        $model->id_brand = $brand->id;
        $model->save();

        // DB::table('models')->insert([
        //     'name' => 'Standard',
        //     'id_brand' => $brand->id
        // ]);
    }
}
