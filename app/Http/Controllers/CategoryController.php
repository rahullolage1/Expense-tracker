<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function createCategory(Request $request){
            $input = $request->all();
            // dd($input);
            $user_id = auth()->user()->id;
            // dd($user_id);
            $newData = new Category();
            $result = $newData->addCategory($input, $user_id);
                if(gettype($result) == 'object'){
                    return $result;
                }
                else{
                    return response()->json([
                        'status' => 'ok',
                        'message'=> 'Category Created',
                        ], 201);
                }
    }


    public function listCategory(){
        
        $user_id = auth()->user()->id;
        
        $result = new Category();
        $response = $result->category_list($user_id);
        // dd($response);
            return response()->json([
                'status' => 'success',
                'response' => $response,
                'status_code' => 200
            ], 200);
    }
}
