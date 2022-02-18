<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\CategoEn;
use App\Models\CategoFr;
use App\Models\Categories;
use App\Models\Faq;
use App\Models\Insta;
use App\Models\Partener;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;


class AllController extends Controller
{
    //Home
    public function home()
    {
        $spec = Specification::all();
        $testi = Testimonial::all();
        $products = Product::all();
        $popular = DB::table('products')->where('popular', 1)->get();
        $parteners = Partener::all();
        $cat = Categories::all();
        $cat_fr = CategoFr::all();
        $cat_en = CategoEn::all();
        $instas = Insta::all();
        return view('home', compact('products', 'spec', "testi", "parteners", 'cat', 'cat_fr', "cat_en", "instas", 'popular'));
    }
    //Product
    public function productIndoor()
    {
        $products = Product::all();
        $count_product = count(DB::table('products')->where('type', 'indoor')->get());
        $cat = Categories::all();
        $cat_fr = CategoFr::all();
        $cat_en = CategoEn::all();
        $parteners = Partener::all();
        $data = null;
        return view('product-indoor', compact('products', 'cat','data', 'parteners', 'count_product', "cat_fr", "cat_en"));
    }
    public function range(Request $request)
    {
        $cat = Categories::all();
        if ($request->select != null) {
            $productss = Product::all();
            $data = $request->select;
            //string to array via le "-"
            $data2 = explode("-", $data);
            //creation d'un new collect pour les products filter
            $products = collect([]);
            for ($i = 0; $i < count($productss); $i++) {
                if ($productss[$i]->price >= $data2[0] && $productss[$i]->price <= $data2[1]) {
                    $products->push($productss[$i]);
                }
            }
        }else {
            $products = Product::all();
            $data = null ;
        }
        //return meme page que indoor avec le meme compact pour eviter du code en plus
        return view('product-indoor', compact('products', 'cat', 'data'));
    }

    public function productOutdoor()
    {
        $products = Product::all();
        $count_product = count(DB::table('products')->where('type', 'outdoor')->get());
        $parteners = Partener::all();
        $cat = Categories::all();
        $cat_fr = CategoFr::all();
        $cat_en = CategoEn::all();
        return view('product-outdoor', compact('products',"parteners", "cat", "count_product", "cat_fr", "cat_en"));
    }
    public function productShow($slug)
    {
        $cat = Categories::all();
        $cat_fr = CategoFr::all();
        $cat_en = CategoEn::all();
        $product = Product::where('name', $slug)->firstOrfail();
        $parteners = Partener::all();

        return view('product-details', compact("product", "parteners", "cat", "cat_fr", "cat_en"));
    }
    public function search(Request $request)
    {

        // request()->validate([
        //     "filter[name]" => "required",
        // ]);

        //valeur de l'input
        $parteners = Partener::all();
        $value = array_values(request()->filter)[0];
        //product trouvé avec package spatie-querybuilder
        if ($value) {
            $products = QueryBuilder::for(Product::class)
                ->allowedFilters('name')
                ->get();
            return view('search', compact('products', 'value', "parteners"));
        } else {
            return redirect()->back()->with('warning', 'champs vide...');
        }
    }


    //About
    public function about()
    {
        $abouts = About::all();
        $parteners = Partener::all();
        return view('about', compact('abouts', "parteners"));
    }
    //Contact
    public function contact()
    {
        $parteners = Partener::all();
        return view('contact', compact("parteners"));
    }
    //Faq
    public function faq()
    {
        $parteners = Partener::all();
        $faqs = Faq::all();
        return view('faq', compact('faqs', "parteners"));
    }
    public function moving()
    {
        $parteners = Partener::all();
        return view('moving', compact("parteners"));
    }

    public function catalogue()
    {
        $parteners = Partener::all();
        return view('catalogue', compact("parteners"));
    }
}
