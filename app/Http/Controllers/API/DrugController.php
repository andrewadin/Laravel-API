<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use App\Models\Drug;
use App\Http\Resources\Drug as DrugResource;

class DrugController extends BaseController
{
    public function index(){
        $drugs = Drug::all();
        return response()->json($drugs, 200);
    }

    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'stocks' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $drugs = Drug::create($input);
        return $this->sendResponse(new DrugResource($drugs), 'Drug saved successfully');
    }
    
    public function show($id){
        $drug = Drug::find($id);
        if(is_null($drug)){
            return $this->sendError('Drug does not exist');
        }
        return response()->json($drug, 200);
    }

    public function update(Request $request, Drug $drug){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'stocks' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $drug->name = $input['name'];
        $drug->brand = $input['brand'];
        $drug->price = $input['price'];
        $drug->stocks = $input['stocks'];
        $drug->save();

        return $this->sendResponse(new DrugResource($drugs), 'Drug updated successfully');
    }

    public function destroy(Drug $drug){
        $drug->delete();
        return $this->sendResponse([], 'Drug deleted');
    }
}
