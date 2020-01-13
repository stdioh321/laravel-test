<?php

namespace App\Http\Controllers;


use App\CustomClass\Conexao;
use App\CustomClass\Utils;
use Validator;

use App\Messages;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use PDO;
use PDOException;

use function App\CustomClass\doSomething;

// use App\Utils\CustomMessages;

class HelloController extends Controller
{
    //
    function index(Request $request)
    {
        // $this->log('tmp');
        // echo "I'm INDEX";
        $messages = Messages::all();
        // foreach ($messages as $message) {
        //     echo $message->title;
        // }
        // die;
        // $validator = Validator::make($request->all(),[
        //     'a'=>'required|max:5'
        // ]);
        // $validator = $request->validate([
        //     'a' => 'required|max:5'
        // ]);
        $validator = Validator::make(
            $request->all(),
            [
                'a' => 'required|max:4',
                'bbbb' => 'required|max:5',
                'c' => 'required|max:5'
            ],
            customMessage()
            // \App\Utils\CustomMessages->custoMessage()
        );
        return view('/home', ['messages' => $messages, 'errors' => $validator->errors()]);
        // return view('/home', ['messages' => $messages]);
    }

    function temp()
    {
        return Carbon::now()->timestamp * 1000;
        // return \DB::select('SELECT * FROM messages WHERE DAY(created_at) = 9');
        // return Messages::get();

    }

    function messageAdd(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'content' => 'required|max:500'
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }
            $msg = new Messages();

            \DB::beginTransaction();
            $msg->title = $request->get('title');
            $msg->content = $request->get('content');

            $msg->save();
            // throw new Exception("Error Processing Request", 1);

            \DB::commit();
            return $msg;
            return 'Success';
        } catch (\Exception $e) {
            //throw $th;
            return response($e->getMessage(), 500, []);
        }
    }

    function messages(Request $request, $id = null)
    {
        // $dsn = "mysql:host=localhost;dbname=test";
        // $user = "root";
        // $passwd = "root";
        // echo  doSomething();
        // foreach (array(1, 2, 3) as $value) {
        //     echo Utils::getInstance()->doSomething();
        //     echo "<br />";
        // }
        $pdo = Conexao::getInstance();

        $stm = $pdo->query("SELECT * FROM messages");
        $json = json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
        error_log($json);
        return $json;
        // $all = $stm->fetch(PDO::FETCH_ASSOC);
        // foreach ($all as $key => $value) {
        //     echo $all[$key];
        //     echo '<br />';
        // }
        // foreach ($all as $key => $value) {
        //     print_r($key);
        // }
        // return '123';
        // $messages = \DB::table('messages')->select();
        // if ($id && !empty($id)) {
        //     $tmp = $messages->where('id', $id)->get();
        //     if($tmp->isEmpty()){
        //         error_log('isEmpty');
        //     }
        //     return response($messages->where('id', $id)->get(),200);
        // }
        // if ($request->has('id') && !empty($request->id)) {
        //     $messages = $messages->where('id', "$request->id");
        // }

        // if ($request->has('page') && !empty($request->page)) {
        //     return $messages->paginate(5);
        // }
        // return $messages->get();
    }
    function pdoSqlite()
    {
        try {
            $memory_db = new PDO('sqlite::memory:');
            $memory_db->exec("CREATE TABLE messages (
                      id INTEGER PRIMARY KEY, 
                      title TEXT, 
                      message TEXT, 
                      time TEXT)");
            $memory_db->exec("INSERT INTO messages (title, message, time) VALUES ('aaa', 'bbb', 123)");
            $memory_db->exec("INSERT INTO messages (title, message, time) VALUES ('aaa', 'bbb', 123)");
            $memory_db->exec("INSERT INTO messages (title, message, time) VALUES ('aaa', 'bbb', 123)");
            $q = $memory_db->query("SELECT * FROM messages");
            foreach ($q->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
                print_r($value);
            }
            // echo 'SUCCESS';
        } catch (\Throwable $th) {
            echo 'ERROR';
        }
    }
}
