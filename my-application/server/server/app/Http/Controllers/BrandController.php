<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    function getBrand(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            if (!$id) {
                $brands = Brand::get();
                return response($brands, 200);
            }
            if (!is_numeric($id)) {
                return response('Invalid id', 400);
            }
            $brand = Brand::where('id', $id)->first();
            if (empty($brand)) return response("Nothing found", 406);
            return $brand;
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function postBrand(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:brands,name'
            ]);
            if ($validator->fails()) {
                $code = 400;
                $msgs = $validator->getMessageBag();
                if ($msgs->has('name'))
                    $code = 409;
                return $this->replyJson('', $code, 'Fields validations fail', $validator->errors());
            }
            $brand = new Brand($request->all());
            $brand->save();
            DB::commit();
            return response($brand, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function putBrand(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $brand = Brand::where('id', $id)->first();
            if (!$brand) return response('Nothing found', 406);

            $validator = Validator::make($request->all(), [
                'name' => [
                    'max:255',
                    'string',
                    Rule::unique('brands', 'name')->ignore($brand->id, 'id')
                ]
            ]);
            if ($validator->fails()) {
                $code = 400;
                $msgs = $validator->getMessageBag();
                if ($msgs->has('name'))
                    $code = 409;
                return $this->replyJson('', $code, 'Fields validations fail', $validator->errors());
            }
            $brand->update($request->all());
            $brand->save();
            DB::commit();
            return response($brand, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }

    function deleteBrand(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $brand = Brand::where('id', $id)->first();
            if (empty($brand)) {
                return response('Nothing found.', 406);
            }
            $brand->delete();
            DB::commit();
            return response($brand, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
}
