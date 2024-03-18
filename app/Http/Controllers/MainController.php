<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class MainController extends Controller
{
    protected $filePath;

    function __construct()
    {
        $this -> filePath = public_path('data/data.json');
    }
    function index()  
    {
         $filePath = public_path('data/data.json');
         if (file_exists($filePath)) {
             $jsonContent = file_get_contents($filePath);
             $dataArray = json_decode($jsonContent, true);
             if (count($dataArray['dishes']) > 0) {
                 return view('manage.index', ['data' => $dataArray['dishes'] ]);
             } else {
                 return "Failed to decode JSON data";
             }
         } else {
             return "File not found";
         }
    }

    function getData(Request $request) {
       $file = $this->filePath;
       $meal = $request->input('meal');
        
       try {
            if (file_exists($file)) {
                $jsonContent = file_get_contents($file);
                $dataArray = json_decode($jsonContent, true);
                $arr = [];
                
                foreach ($dataArray['dishes'] as $dataRestaurant) {
                    if (in_array($meal, $dataRestaurant['availableMeals']) && !in_array($dataRestaurant['restaurant'],$arr)) {
                        $arr[] = $dataRestaurant['restaurant'];
                    }
                }
                if(!empty($arr)) {
                    return response()->json($arr, Response::HTTP_OK);
                }
                else {
                    return response()->json('Not Restaurant', Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function  getDataDish(Request $request){
        $file = $this->filePath;
        $restaurant = $request->input('restaurant');
        try {
            if (file_exists($file)) {
                $jsonContent = file_get_contents($file);
                $dataArray = json_decode($jsonContent, true);
                $arr = [];
                
                foreach ($dataArray['dishes'] as $dataRestaurant) {
                    if ($restaurant == $dataRestaurant['restaurant'] && !in_array($dataRestaurant['name'],$arr)) {
                        $arr[$dataRestaurant['id']] = $dataRestaurant['name'];
                    }
                }
                if(!empty($arr)) {
                    return response()->json($arr, Response::HTTP_OK);
                }
                else {
                    return response()->json('Not Restaurant', Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function getDataReview(Request $request){
        $file = $this->filePath;
        $restaurant = $request->input('restaurant');
        $meal = $request->input('meal');
        $dish = $request->input('dish');
        $number_people = $request->input('number_people');
        $number_dish = $request->input('number_dish');
        try {
            if (file_exists($file)) {
                $jsonContent = file_get_contents($file);
                $dataArray = json_decode($jsonContent, true);
                $arr = [];
                
                foreach ($dataArray['dishes'] as $dataRestaurant) {
                    if ($restaurant == $dataRestaurant['restaurant'] && !in_array($dataRestaurant['name'],$arr)) {
                        $arr[$dataRestaurant['id']] = $dataRestaurant['name'];
                    }
                    if ($restaurant == $dataRestaurant['restaurant'] && !in_array($dataRestaurant['name'],$arr)) {
                        $arr[$dataRestaurant['id']] = $dataRestaurant['name'];
                    }
                }
                if(!empty($arr)) {
                    return response()->json($arr, Response::HTTP_OK);
                }
                else {
                    return response()->json('Not Restaurant', Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        $formData = $request->all();
       
        unset($formData['_token']);
        Log::info(json_encode($formData));
        return redirect('/');
    }
}
