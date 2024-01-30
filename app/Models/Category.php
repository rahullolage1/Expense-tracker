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

    protected $fillable = [
        'name',
        'isActive',
        'created_by',
    ];

    protected $table = "category";

    public function addCategory($input, $user_id){
        
        $validator = validator::make($input, [
            "name"=> "required|string|unique:category|max:100",
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $data = Category::create([
                        "name" => $input["name"],
                        "isActive" => $input["isActive"],
                        'created_by' => $user_id,
        ]);
        
        return 'category created';
        
    }


    public function category_list($user_id){
                
        $list = Category::where([
            'created_by' => $user_id,
            'isActive' => '1',
        ])->limit(10)
          ->latest()
          ->get();

        $data = $list->toArray();

        return $data;
    }

}
