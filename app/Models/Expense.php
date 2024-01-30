<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $dates = ['deleted_at'];

    protected $fillable = [
        'category_id',
        'amount',
        'remark',
        'user_id',
    ];

    public function addExpense($request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            "amount" => "required|regex:/^[0-9]*$/",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $data = Expense::create([
                'category_id' => $request['category'],
                'amount' => $request['amount'],
                'remark' => $request['remark'],
                'user_id' => $user_id,
            ]);
            // dd($data);
            return 'expense created';
        }
    }

    public function findRecord($id)
    {
        $expenseId = Expense::find($id);

        return $expenseId;
    }

    public function store($input, $id, $user_id)
    {
        $validator = Validator::make($input, [
            "amount" => "required|regex:/^[0-9]*$/",
        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {
            $user = Expense::where('id', $id)
                ->whereNull('deleted_at')
                ->first();
            // dd($user);
            if ($user) {
                // dd(1);
                $storeData = $user->update([
                    'amount' => $input['amount'],
                    'category_id' => $input['category'],
                    'remark' => $input['remark'],
                    'user_id' => $user_id,
                ]);
                return $storeData;
            } else {
                return 0;
            }
        }

    }

    public function expense_list($user_id)
    {
        
            $list = Expense::where([
                'user_id' => $user_id,
            ])->latest()
            ->get();
    
            $data = $list->toArray();
    
            return $data;

    }

    public function deleteData($id)
    {
        $destroyData = Expense::where('id', $id)->delete();

        return $destroyData;

    }


    public function getData($start_date,$end_date,$user_id)
    {
        
        $data = DB::table('expenses as e')
                ->leftjoin('category as c', 'e.category_id', '=', 'c.id')
                ->where('e.user_id', $user_id)
                ->select('e.amount', 'c.name as category', 'e.expense_date', 'e.remark');
                
        $data->where(function ($query) use ($start_date,$end_date) {
            if( $start_date != 'null' )
                {
                    $start_date = $start_date. " 00:00:00";
                    $query->where('expense_date', '>=', $start_date);
                }
            if( $end_date != 'null' )
                {
                    $end_date = $end_date. " 23:59:59";
                    $query->where('expense_date', '<=', $end_date);
                }
        });

        $result=$data->orderBy('expense_date','asc')->get();
        // dd($result);
        return $result;
    }

}
