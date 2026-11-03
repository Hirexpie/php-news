<?php
namespace App\Http\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostValidator {
    public function CRUDValidate(Request $req) {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return null;
    }
}