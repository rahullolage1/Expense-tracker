<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $table = "category";

    public function addCategory($input, $user_id){
        // dd($input['isActive']);
        // dd($user_id);
        $validator = validator::make($input, [
            "name"=> "required|string|unique:category|max:100",
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $data = DB::table('category')
                    ->insert([
                        "name" => $input["name"],
                        "isActive" => $input["isActive"],
                        'created_by' => $user_id,
                    ]);

        return 'category created';
        
    }


    public function category_list($request, $user_id){
        $list = DB::table('category as c')
                    ->where('c.created_by', $user_id); 
                
               
        if($request->sort == 'name_desc'){  
            $list->orderBy('c.name','desc');
        }

        if($request->sort == 'name_asc'){  
            $list->orderBy('c.name','asc');
        }

        $data = $list
                ->limit(20)
                ->orderBy('c.name','asc')
                ->get();

        // dd($data);
        return $data;
    }

}
