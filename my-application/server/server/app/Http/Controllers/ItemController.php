<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Exceptions\CustomException;
use App\Models\Brand;
use App\Models\Item;
use DateTime;
use Exception;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JsonException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ItemController extends Controller
{
    function getItems(Request $request)
    {


        try {
            if ($request->exists('p')) {
                $p = is_numeric($request->input('p')) ? $request->input('p') : 10;
                $items = Item::paginate($p);
                // error_log($items);
                return $items;
            }
            return Item::get();
        } catch (\Throwable $th) {
            // error_log('CATCH');
            return $this->replyJson('', 500, $th->getMessage());
        }
    }

    function postItem(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255|unique:items,name',
            'price'     => 'required|numeric|min:0',
            'id_brand'  => 'required|numeric|exists:brands,id',
            'id_model'  => 'required|numeric|exists:models,id',
            'color'     => 'nullable',
        ]);
        if ($validator->fails()) {
            $code = 400;
            $msgs = $validator->getMessageBag();
            if ($msgs->has('name')) $code = 409;
            return $this->replyJson('', $code, 'Fields validation failed.', $validator->errors());
            // return $this->replyJson("", 400, , $validator->errors());
        }

        $item = new Item($request->all());
        try {
            DB::beginTransaction();
            $item->save();
            DB::commit();
            return $item;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function getItem(Request $request, $id = null)
    {
        // error_log('getItem');
        try {
            $item = Item::where('id', $id)->with('brand')->with('model')->first();
            if (empty($item)) {
                return response('Nothing found.', 406);
            }
            return response($item, 200);
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function deleteItem(Request $request, $id = null)
    {
        // error_log('getItem');
        try {
            $item = Item::where('id', $id)->first();

            if (empty($item)) {
                return response('Nothing found.', 406);
            }

            $item->delete();
            return response($item, 200);
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
    function restoreItem(Request $request, $id = null)
    {
        // error_log('getItem');
        try {
            $item = Item::onlyTrashed()->where('id', $id)->first();

            if (empty($item)) {
                return response('Nothing found.', 406);
            }

            $item->restore();
            return response($item, 200);
        } catch (\Throwable $th) {
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }


    function putItem(Request $request, $id = null)
    {
        try {
            DB::beginTransaction();
            $item = Item::where('id', $id)->first();


            if (!$item) {
                return response('Nothing found.', 406);
            }
            $validator = Validator::make($request->all(), [
                'name'      => [
                    'string',
                    'max:255',
                    Rule::unique('items', 'name')->ignore($item->id, 'id')
                ],
                'price'     => 'numeric|min:0',
                'id_brand'  => 'numeric|exists:brands,id',
                'id_model'  => 'numeric|exists:models,id',
                'color'     => '',
            ]);
            if ($validator->fails()) {
                $code = 400;
                $msgs = $validator->getMessageBag();
                if ($msgs->has('name')) $code = 409;

                return $this->replyJson('', $code, null, $validator->errors());
            }

            $item->update($request->all());
            $item->save();
            DB::commit();
            return response($item, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->replyJson('', 500, null, $th->getMessage(), $th->getCode());
        }
    }
}
