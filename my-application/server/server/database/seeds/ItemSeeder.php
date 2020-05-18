<?php

use App\Models\Brand;
use App\Models\Item;
use App\Models\ModelM;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = DB::table('brands')->first();
        $model = DB::table('models')->first();

        $item = new Item();
        $item->name = "Pen";
        $item->price = 2.5;
        $item->color = 'Blue';
        $item->id_brand = $brand->id;
        $item->id_model = $model->id;

        $item->save();
    }
}
