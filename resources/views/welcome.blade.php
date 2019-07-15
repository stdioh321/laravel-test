<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>{{__('msg.title')}}</h1>
        <h2>
            Session -
            <?php

            use Illuminate\Support\Facades\Session;

            $uData = Session::get("userData");
            print_r($uData);
            // foreach ($uData as $key => $value) {
            //     echo "$key - $value<br />";
            // }
            Session::forget("userData");
            ?>

        </h2>
        <h2>
            Flash Session {{
                Session::get("userDataFlash")['user']
            }}
        </h2>
        <div class="row">
            <div class="col-12">
                <a href="/">Form</a>
                <!-- <a href="/">HOME</a> -->
            </div>
        </div>
    </div>

</body>

</html>