<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public $itemList = array();

    public function index()
    {
        $products = Stock::all();
        return view('Sales.sale')->with('products',$products);
    }


    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function show()
    {
        // $details = DB::table('stocks')->select('id','name', 'selling_price','barcode')
        //     ->where('barcode','=', $request->barcode)
        //     ->first();
        
        // if ($details) {
        //     return view('Sales.sale')->with('details',$details);
        // }
        // else{
        //     $details = new Stock();
        //     return view('Sales.sale')->with('details',$details);
        // }

        // $getPrice = $_GET['id'];
      // $price  = DB::table('orders')->where('id', $getPrice)->get();
      // return Response::json($price);
        return "dDDd";
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
        //
    }
    public function details($barcode){
        $details = DB::table('stocks')->select('id','name', 'selling_price','barcode','branch')
            ->where('barcode','=', $barcode)
            ->first();
        
        return $details;
    }
}
