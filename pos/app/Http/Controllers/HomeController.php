<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CustomerSale;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sales = CustomerSale::all();
        $categories = Category::all();
        $users = User::all();
        $branch = Branch::all();
        $highestincome =CustomerSale::all()->max('amount');
        $lowestincome = CustomerSale::all()->min('amount');
        $averageincome = CustomerSale::all()->avg('amount');
        $topbranch = CustomerSale::select('branch',DB::raw('COUNT(id) as numbers'))
            ->groupBy('branch')
            ->orderByRaw('COUNT(*) DESC')
            ->take(5)
            ->get();
        $newUser = User::select('name','branch','department','contact_no','email')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('home')->with([
            "categories"=>$categories, 
            "sales"=>$sales, 
            "users"=>$users, 
            "branch"=>$branch,
            "highestincome"=>$highestincome, 
            "lowestincome"=>$lowestincome,
            "averageincome"=>$averageincome,
            "topbranch"=>$topbranch,
            "newUser"=>$newUser,
        ]);
    }
}
