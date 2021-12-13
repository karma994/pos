<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Unitofmeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $uoms = Unitofmeasurement::all();
        $branches = Branch::all();
        $categories = Category::all();
        $stocks = Stock::all();
        return view('Stocks.stock')->with(['stocks'=>$stocks, 'categories'=>$categories,'branches'=>$branches,'uoms'=>$uoms]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if($request->id == null){
            $stock = new Stock();
            $stock->name = $request->name;
            $stock->quantity = $request->quantity;
            $stock->category = $request->category;
            $stock->cost_price = $request->cost_price;
            $stock->selling_price = $request->selling_price;
            $stock->barcode = $request->barcode;
            $stock->branch = $request->branch;
            $stock->unit_of_measurement = $request->unit_of_measurement;
            $stock->save();
        }
        else{
            Stock::where('id', $request->id)->update([
                'name'=>$request->name,
                'quantity'=>$request->quantity,
                'category'=>$request->category,
                'cost_price'=>$request->cost_price,
                'selling_price'=>$request->selling_price,
                'barcode'=>$request->barcode,
                'branch'=>$request->branch,
                'unit_of_measurement'=>$request->unit_of_measurement,
             ]);
        }
        return redirect('stocks');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($productList)
    {
        $seperatewithbranch = explode('&&', $productList);
        $products = explode('---', $seperatewithbranch[0]);
        $branchname = $seperatewithbranch[1];
        // $quantity = 0;
        $details = explode('**',$products[0]);
        for ($i=0; $i < count($products)-2; $i++) { 
           $details = explode('**',$products[$i]);
           $barcode = strval($details[0]);
           $qtyfromuser = $details[1];
           $quantity = DB::table('stocks')->select('quantity')->where('barcode','=', $barcode)->where('branch','=', $branchname)->first();
           $qty = ($quantity->quantity) - $qtyfromuser;
           DB::table('stocks')->where('barcode', $barcode)->where('branch', $branchname)->update(['quantity' => $qty]);   
        }
        return "success";
    }

    public function destroy($id)
    {
        Stock::where('id',$id)->delete();
        return redirect('stocks');
    }
}
