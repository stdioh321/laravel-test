<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class Utils
{
    static function replyJson($data = "", int $httpCode = 200, String $message = null,  $errors = null, String $code = '0')
    {

        return response()
            ->json([
                'data' => $data,
                'message' => $message,
                'errors' => $errors,
                'code' => $code
            ], $httpCode);
    }

    static  function defaultGet(Request $request, string $model = null, $id = null, $with = [])
    {


        $modelInstance = with(new $model);
        $columns = DB::getSchemaBuilder()->getColumnListing($modelInstance->getTable());
        $columns = array_map(function ($c) {
            return strtolower($c);
        }, $columns);
        // print_r($columns);

        $fields = explode(',', $request->input('fields'));
        $fields = array_map(function ($f) {
            return strtolower($f);
        }, $fields);

        $fieldsResult = array_filter($fields, function ($f) use ($columns) {
            $tmp =  array_search($f, $columns);
            return $tmp === false ? false : true;
        });

        if (empty($fieldsResult)) $fieldsResult = $columns;

        $result = $modelInstance::select($fieldsResult);

        if ($id || $request->input('id')) {
            $tmpId = ($id ? $id : $request->input('id'));
            $result = $result->where('id', '=', $tmpId)->first();
            return $result;
        }

        $q = $request->input("q");
        $q = isset($q) ? explode(',', $q) : $q;
        if (isset($q)) {
            $q = array_map(function ($tmpQ) {
                return strtolower($tmpQ);
            }, $q);


            $columnsToSearch = array_filter(array_slice($q, 1), function ($tmpC) use ($columns) {
                return array_search($tmpC, $columns) === false ? false : true;
            });

            if (empty($columnsToSearch)) $columnsToSearch = $columns;

            $class = new ReflectionClass($model);
            $h = $class->hasProperty('hidden');
            if ($h) {
                $h = $class->getProperty('hidden');
                $h->setAccessible(true);
                $h = $h->getValue($modelInstance);
                $columnsToSearch = array_filter($columnsToSearch, function ($c) use ($h) {
                    return array_search($c, $h) === false ? true : false;
                });
            }
            foreach ($columnsToSearch as $key => $value) {
                if ($key === 0)
                    $result = $result->where($value, 'LIKE', "%$q[0]%");
                else {
                    $result->orWhere($value, 'LIKE', "%$q[0]%");
                }
            }
        }
        if (isset($_GET['page'])) {
            $perPage = is_numeric($request->input('per_page')) ? $request->input('per_page') : 10;

            $result = empty($with) ? $result->paginate($perPage) : $result->with($with)->paginate($perPage);
        } else {
            $result = empty($with) ? $result  : $result->with($with)->get();
        }
        return $result;
    }
}
