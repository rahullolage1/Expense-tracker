<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function createExpense(request $request)
    {
        $user_id = auth()->user()->id;
        // dd($user_id);
        $result = new Expense();
        $response = $result->addExpense($request, $user_id);
        // dd(gettype($response));
        if (gettype($response) == 'object') {
            return $response;
        } else {
            return response()->json([
                'status' => 'ok',
                'message' => 'Expense Created',
            ], 201);
        }

    }

    public function getExpense($id)
    {
        $findId = new Expense();
        $result = $findId->findRecord($id);
        // dd($result);
        if ($result) {
            return response()->json([$result]);
        } else {
            return response()->json([
                'status' => 'failed',
                'response' => 'Record not exist',
                'status_code' => 404
            ], 404);
        }

    }

    public function updateExpense(Request $request, $id)
    {
        $input = $request->all();
        $user_id = auth()->user()->id;
        $updateData = new Expense();
        $result = $updateData->store($input, $id, $user_id);
        // dd($result);
        if (gettype($result) == 'object') {
            // dd(1);
            return $result;
        } elseif ($result == false) {
            // dd(2);
            return response()->json([
                'status' => 'failed',
                'response' => 'Record not exist',
                'status_code' => 404
            ], 404);
        } else {
            // dd(3);
            return response()->json([
                'status' => 'success',
                'response' => 'Record updated successfully',
                'status_code' => 200
            ], 200);
        }
    }

    public function delete($id)
    {
        $data = new Expense();
        $result = $data->deleteData($id);
        // dd($result);
        if ($result) {
            return response()->json([
                'status' => 'success',
                'response' => 'Record deleted successfully',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'response' => 'Record not found',
                'status_code' => 404
            ], 404);
        }

    }
}
