<?php

namespace App\Http\Controllers;

use App\Models\ModelM;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ModelController extends Controller
{
    function getModel(Request $request, $id = null)
    {
        try {

            $models = Utils::defaultGet($request, ModelM::class, $id, ['brand']);
            // $models = $models->get();
            if ($id && empty($models)) return response('Nothing Found', 406);
            return response($models, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function postModel(Request $request)
    {
        try {
            DB::beginTransaction();
            $validation = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255|unique:models,name',
                    'id_brand' => 'required|numeric|exists:brands,id'
                ]
            );
            if ($validation->fails()) {
                return $this->replyJson('', 422, 'Fields validations.', $validation->errors());
            }
            $model = new ModelM($request->all());
            $model->save();
            DB::commit();
            return response($model, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function putModel(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $model = ModelM::where('id', $id)->first();
            if (empty($model)) {
                return response('Nothing Found', 406);
            }
            $validation = Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        'alpha',
                        'max:255',
                        Rule::unique('models', 'name')->ignore($model->id, 'id')
                    ],
                    'id_brand' => 'required|numeric|exists:brands,id'
                ]
            );
            if ($validation->fails()) {
                return $this->replyJson('', 422, 'Fields validations.', $validation->errors());
            }
            $model->update($request->all());
            $model->save();
            DB::commit();
            return response($model, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
}
