<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\UnitofMeasurement;
use Illuminate\Http\Request;

class UnitofMeasurementController extends Controller
{

    public function index()
    {
        $uoms = UnitofMeasurement::all();
        return view('Stocks.uom')->with('uoms',$uoms);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if($request->id == null){
            $uom = new UnitofMeasurement();
            $uom->name = $request->name;
            $uom->save();
        }
        else{
            Unitofmeasurement::where('id', $request->id)->update([
                'name'=>$request->name,
             ]);
        }
        return redirect('uom');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Unitofmeasurement::where('id',$id)->delete();
        return redirect('uom');
    }

    public function checkuname($unit) {
        if (Unitofmeasurement::where('name',$unit )->exists()) {
            return "yes";
        }
        return "no";
    }
}
