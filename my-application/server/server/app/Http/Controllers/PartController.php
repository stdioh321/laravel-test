<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PartController extends Controller
{
    //
    function getPart(Request $request, $id = null)
    {
        try {
            if (!$id) {
                $parts = Part::with('item')->get();
                return response($parts, 200);
            }

            $part = Part::where('id', $id)->with('item')->first();
            if (!$part) {
                return response("Nothing found", 406);
            }

            return response($part, 200);
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }


    function putPart(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $part = Part::where('id', $id)->first();
            if (!$part) {
                return response("Nothing Found", 406);
            }

            $validator = Validator::make($request->all(), [
                'name' => [
                    Rule::unique('parts', 'name')->ignore($id, 'id'),
                    'alpha_num',
                    'max:255'
                ],
                'description' =>  'max:255|string|nullable',
                'id_item' => 'exists:items,id'
            ]);

            if ($validator->fails()) {
                return $this->replyJson('', 422, $validator->errors(), $validator->failed());
            }
            $all = $request->all();
            foreach ($all as $key => $value) {
                // if (!$all[$key]) unset($all[$key]);
            }
            $part->update($all);
            $part->save();
            DB::commit();
            return response($part, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function postPart(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:parts,name',
                'description' =>  'max:255|string|nullable',
                'id_item' => 'required|exists:items,id'
            ]);

            if ($validator->fails()) {
                return $this->replyJson('', 422, $validator->errors(), $validator->failed());
            }
            $all = $request->all();
            foreach ($all as $key => $value) {
                // if (!$all[$key]) unset($all[$key]);
            }
            $part = Part::create($all);
            $part->save();
            DB::commit();
            return response($part, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }

    function deletePart(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $part = Part::where('id', $id)->first();
            if (!$part) return response("Nothing found", 406);

            $part->delete();
            DB::commit();
            return response($part, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
}
