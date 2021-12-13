<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CustomerSale;
use App\Models\Branch;

class CustomersaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cs = CustomerSale::all();
        return view('Sales.cs')->with(["cs"=>$cs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        return "hello";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function addsaleinfo($saleinfo) {
        $seperate = explode('&&&', $saleinfo);
        $sale = new CustomerSale();
        $sale->name = $seperate[0];
        $sale->phoneno = $seperate[1];
        $sale->productQuantity = $seperate[2];
        // $products = explode('---', $seperate[2]);
        // // $quantity = 0;
        // $details = explode('**',$products[0]);
        // for ($i=0; $i < count($products)-2; $i++) { 
        //    $details = explode('**',$products[$i]);
        //    $barcode = strval($details[0]);
        //    $qtyfromuser = $details[1]; 
        // }
        $sale->billno = $seperate[3];
        $sale->amount = $seperate[4];
        $sale->discount = $seperate[5];
        $sale->journalno = $seperate[6];
        $sale->cashier = $seperate[7];
        $sale->branch = $seperate[8];
        $sale->save();
        return redirect('sale');
        
    }
    public function accounts(){
        $cs = CustomerSale::all();
        $branches = Branch::all();
        return view('Sales.accounts')->with(["cs"=>$cs, "branches"=>$branches]);
    }
    public function refund($product){
        $seperatebranch = explode("@",$product);
        $branchname = $seperatebranch[1];
        $data = explode('&', $seperatebranch[0]);
        $idproductqty = $data[0];
        $pamount = explode('!', $data[1])[0];
        $pdiscount = explode('!', $data[1])[1];
        $spid = explode('_',$idproductqty);
        $id = $spid[0];
        $pqty = $spid[1];
        $datafromdb = DB::table('customersales')->select('amount','productQuantity','discount')->where('id','=', $id)->first();
        $productQuantityfromdb = $datafromdb->productQuantity;
        $productQuantity = str_replace($pqty,"",$productQuantityfromdb);
        $replaceamount = ($datafromdb->amount) - $pamount;
        $barcode = explode('**', $pqty)[0];
        $quantity = explode('**', $pqty)[1];
        $quantity = str_replace("---","",$quantity);
        $qtyfromdb = DB::table('stocks')->select('quantity')->where('branch', $branchname)->where('barcode','=', $barcode)->first();
        $qtyreplace = $qtyfromdb->quantity + $quantity;
        $discountreplace = ($datafromdb->discount) - $pdiscount;
        DB::table('customersales')->where('id', $id)->update(['productQuantity' => $productQuantity, 'amount'=> $replaceamount, 'discount'=>$discountreplace]); 
        DB::table('stocks')->where('branch', $branchname)->where('barcode', $barcode)->update(['quantity' => $qtyreplace]); 
        $amountfromdb = DB::table('customersales')->select('amount')->where('id','=', $id)->first();
         

        return $data;
    }
}

