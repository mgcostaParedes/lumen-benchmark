<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

function binarySearch(Array $arr, $x)
{
    // check for empty array
    if (count($arr) === 0) return false;
    $low = 0;
    $high = count($arr) - 1;

    while ($low <= $high) {

        // compute middle index
        $mid = floor(($low + $high) / 2);

        // element found at mid
        if($arr[$mid] == $x) {
            return true;
        }

        if ($x < $arr[$mid]) {
            // search the left side of the array
            $high = $mid -1;
        }
        else {
            // search the right side of the array
            $low = $mid + 1;
        }
    }
    return false;
}

$router->get('/', function () use ($router) {
    return response()->json(['message' => 'hello world']);
});

$router->get('/compute', function() use($router) {
    $x = 0; $y = 1;
    $max = 10000 + rand(0, 500);

    for ($i = 0; $i <= $max; $i++) {
        $z = $x + $y;
        $x = $y;
        $y = $z;
    }
    return response()->json(['message' => 'done']);
});

$router->get('/search', function() use($router) {
    $array = [];
    for($i = 0; $i < 10000; $i++) {
            $array[] = $i;
    }
    $number = rand(1, 10000);
    $result = binarySearch($array, $number);
    return response()->json(['status' => 'done', 'numberSearched' => $number]);
});

$router->get('/country', function() use($router) {
    $results = app('db')->select("Select * from apps_countries where country_code='PT'");
    return response()->json(['data' => $results]);
});

$router->get('/countries', function() use($router) {
    $results = app('db')->select("Select * from apps_countries");
    return response()->json(['data' => $results]);
});

$router->get('/country', function() use($router) {
    $results = app('db')->select("Select * from apps_countries where country_code='PT'");
    return response()->json(['data' => $results]);
});

$router->get('/country-complex', function() use($router) {
    $results = app('db')->select("Select apps_countries.*, apps_countries_detailed.* from apps_countries left join apps_countries_detailed on apps_countries.country_code = apps_countries_detailed.countryCode order by apps_countries_detailed.geonameId desc");
    foreach($results as $key => $result) {
        $result->newValue = 'index_' . $key;
    }
    return response()->json(['data' => $results]);
});