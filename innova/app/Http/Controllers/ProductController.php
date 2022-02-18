<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Image;
use App\Models\Provisoire;
use App\Models\Specification;
use Hamcrest\Core\IsNot;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;
use Spatie\QueryBuilder\QueryBuilder;

use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $products = Product::paginate(20);
        return view('admin/products-indoor/main', compact('products'));
    }
    public function outdoor()
    {
        
        $products = Product::paginate(20);
        return view('admin/products-indoor/outdoor', compact('products'));
    }


    public function search(Request $request)
    {
        $value = array_values(request()->filter)[0];
        if ($value) {
            $products = QueryBuilder::for(Product::class)
                ->allowedFilters('name')
                ->get();
            return view('admin/products-indoor/search', compact('products', 'value'));
        } else {
            return redirect()->back()->with('warning', 'champs vide...');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Categories::all();
        $provisoire = Provisoire::first();
        $page = "product";
        return view('admin/products-indoor/create', compact('cat', "page", "provisoire"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $page = request()->page;
        $cat_array = $request->cat;

        if ($page === "product") {   // ETAPE 1
            $page = "images";
            //Stocke toutes les données dans une table provisoire 
            // verifie si la table est vide pour le rollback
            if (Provisoire::count() === 0) {
                $provisoire = new Provisoire();
                $provisoire->name = $request->name;
                $provisoire->type = $request->type;
                $provisoire->popular = $request->popular;
                $provisoire->price = $request->price;
                $provisoire->description = $request->description;
                $provisoire->description_fr = $request->description_fr;
                $provisoire->description_en = $request->description_en;
                // $cat = json_encode($request->cat);
                $provisoire->cat = json_encode($request->cat);
                $provisoire->save();
                # code...
            } else {
                $provisoire = Provisoire::first();
                $provisoire->name = $request->name;
                $provisoire->type = $request->type;
                $provisoire->popular = $request->popular;
                $provisoire->price = $request->price;
                $provisoire->description = $request->description;
                $provisoire->save();
            }

            return view('admin/products-indoor/create', compact("page"));
        } elseif ($page === 'images') {   // ETAPE 2
            $productImg =  DB::table('provisoires')->select('img1', 'img2', 'img3' ,'img4', 'img5')->get();
            // dd(gettype($test[0]));
            $arrayImg = (array) $productImg[0];
            $compt = 0;
            foreach ($arrayImg as $value) {
                if(is_null($value)) {
                    $compt++;
                }
            }
            if ($compt == 5) {
                return redirect()->back()->with("warning", 'Oups, forgotten images  ');
            } else {
                $page = "speci";
                return view('admin/products-indoor/create', compact("page"));
                # code...
            }
            
            // dump($compt);
            // dd($arrayImg);

        } elseif ($page === "speci") {    // ETAPE 3
            // //récupere les données dans la tablea provisoire et les palces dans chacun de ses table respective
            $provisoire = Provisoire::first();

            // // $product mis à jour
            $product = new Product();
            $product->name = $provisoire->name;
            $product->type = $provisoire->type;
            $product->popular = $provisoire->popular;
            $product->price = $provisoire->price;
            $product->description = $provisoire->description;
            $product->description_fr = $provisoire->description_fr;
            $product->description_en = $provisoire->description_en;
            // dd(json_decode($provisoire->cat));
            $product->save();
            $product->categories()->attach(json_decode($provisoire->cat));

            // $images mis à jour
            $productImg =  DB::table('provisoires')->select('img1', 'img2', 'img3' ,'img4', 'img5')->get();
            // chope les données des img en sql
            //transforme en tableau
            $arrayImg = (array) $productImg[0];
            //boucle sur le tableau avec les données et utilise la $key pour faire référence
            foreach ($arrayImg as $key => $value) {
                if ($value != null) {
                    $images = new Image();
                    $images->product_id = $product->id;
                    $images->img = $provisoire->$key;
                    $images->save();
                }
            }
   
            // Nettoyage de la tablea provisoire
            $provisoire->delete();


            // Logique JSON pour les spécifications 
            // récup les input et enelve les deux 1er input qui me sert à rien
            $input = $request->input();
            $input_slice = array_slice($input, 2);
 
            //recup les donnée speci et stock dans un tableau
            $arraySpeci = [];
            for ($i = 0; $i < count($input_slice); $i += 2) {  // chop les données pair
                $repSpeci = array_values($input_slice)[$i];
                array_push($arraySpeci, $repSpeci);
            }

            //recup les donnée rep aux speci et stock dans un tableau
            $arrayRep = [];
            for ($i = 0; $i < count($input_slice); $i++) {  // chop les données impair
                if ($i % 2) {
                    $rep = array_values($input_slice)[$i];
                    array_push($arrayRep, $rep);
                }
            }
            // dd($arraySpeci, $arrayRep);

            // //Créer le tableau final qui va stock les donne traité en : "spec => rep" 
            $jsonData = array();
            for ($i = 0; $i < count($input_slice) / 2; $i++) {
                $jsonData[$arraySpeci[$i]] =$arrayRep[$i] ;
            }

            //Transforme en JSON
            $jsonData = json_encode($jsonData);
            //Save d'une manière classique
            $speci = new Specification();
            $speci->data = $jsonData; 
            $speci->product_id = $product->id; 
            $speci->save();
            if ($product->type ==  "indoor") {
                return redirect()->to('admin/products-indoor')->with("success", "product indoor create");
            }else if ($product->type ==  "outdoor"){
                return redirect()->to('admin/products-outdoor')->with("success", "product outdoor create");
            }
        }
    }
    public function store_image(Request $request)  // ETAPE 2 IMG librarie
    {

        $provisoire = Provisoire::first();
        // dd('test');
        $productImg =  DB::table('provisoires')->select('img1', 'img2', 'img3' ,'img4', 'img5')->get();
        // dd(gettype($test[0]));
        $arrayImg = (array) $productImg[0];
        // dd($array);

        $path = 'img/productUpload/';
        $file = $request->file('image');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $upload = $file->move(public_path($path), $new_image_name);

        foreach ($arrayImg as $key => $value) {
            if ($value == null) {
                $provisoire->$key = $new_image_name;
                break;
            }
        }
        $provisoire->save();
        if ($request->notcrop) {
            $page = "images";
            return view('admin/products-indoor/create', compact('page'));
        }else {
            if($upload){
                return response()->json(['status'=>1, 'msg'=>'Image has been cropped successfully.', 'name'=>$new_image_name]);
            }else{
                  return response()->json(['status'=>0, 'msg'=>'Something went wrong, try again later']);
            }

        }

    }
    public function getimage()  // ETAPE 2 IMG librairie suite
    {
        // $imgAll = Provisoire::first();
        // dd($imgAll->img1);
        $img = Provisoire::first()->select(array('img1', 'img2', 'img3', 'img4', 'img5'))->get();
        return $img;
    }
    public function destroy_img($id)
    {
        $provisoire = Provisoire::first();
        //récupère les jsutes les img
        $productImg =  DB::table('provisoires')->select('img1', 'img2', 'img3' ,'img4', 'img5')->get();
        $arrayImg = (array) $productImg[0];
        //transforme l 'id en nbr 
        $nbr = intval($id);
        // ajout +1 pour se calcler sur les noms des columns (img1, img2) car le 'id commence pas 0
        $nbr_img = $nbr +1;

        //boucle sur tableau avec selection des images
        foreach ($arrayImg as $key => $value) {
            //utilise le bon nbr pour verifier si == à la bonne key afin de choper la bonne colum à traiter
            if ("img" . $nbr_img == $key) {
                //delete storage
                $destination = "/img/productUpload/".$value;
                Storage::disk('public')->delete($destination);
                //delete DB
                $arrayImg[$key] = null;
                $provisoire->$key = null;
                $provisoire->save();

            } 
        }        
        $page = "images";
        return view('admin/products-indoor/create', compact("page"));
    }
    public function rollback($name)
    {
        if ($name === 'product') {

            $page = "product";
            // return view('admin/products-indoor/create', compact("page"));
            return redirect()->to('admin/product/create')->with([ 0 => $page]);

        } else if ($name == 'images'){
            $page = "images";
            return view('admin/products-indoor/create', compact("page"));
            // return redirect()->to('/admin/product/store-product')->with([0 => $page]);

        }
    }
    public function cancel()
    {
        if (Provisoire::count() === 0) {
            return redirect()->to('/admin/products-indoor');
            
        } else {
            $provisoire = Provisoire::first();
            
            //supp image dans le storage
            $productImg =  DB::table('provisoires')->select('img1', 'img2', 'img3' ,'img4', 'img5')->get();
            $arrayImg = (array) $productImg[0];
            foreach ($arrayImg as $key => $value) {
                //verifie pour traiter les données ajouter pour le produit en cours
                if ($value != null) {
                    $destination = "img/productUpload/".$value;
                    Storage::disk('public')->delete($destination);
                }
            }
            //supp dans la db
            $provisoire->delete();
            return redirect()->to('/admin/products-indoor');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $cat = Categories::all();
        return view('admin/products-indoor/show', compact('product', "cat"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request);
        $product = Product::find($request->route('id'));
        if ($request->info == "info") {
            $product->name = $request->name;
            $product->type = $request->type;
            $product->popular = $request->popular;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->description_fr = $request->description_fr;
            $product->description_en = $request->description_en;
            $product->categories()->sync($request->cat);
            // dd($request->reduce);
            if ($product->reduce == "null") {
               $product->price_reduce = null;
            }else {
                $product->price_reduce = $request->reduce;
            }

            $product->save();
            return redirect()->back()->with('success', 'Product update !');
            
        } else if($request->specifi == "specifi"){
            $speci = Specification::find($request->id);
                        // coupe   request transdo to array
            $new_speci = array_slice($request->all(),3);

               //recup les donnée speci et stock dans un tableau
               $arraySpeci = [];
               for ($i = 0; $i < count($new_speci); $i += 2) {  // chop les données pair
                   $repSpeci = array_values($new_speci)[$i];
                   array_push($arraySpeci, $repSpeci);
               }
            //    dump($arraySpeci);
               //recup les donnée rep aux speci et stock dans un tableau
               $arrayRep = [];
               for ($i = 0; $i < count($new_speci); $i++) {  // chop les données impair
                   if ($i % 2) {
                       $rep = array_values($new_speci)[$i];
                       array_push($arrayRep, $rep);
                   }
               }
               $jsonData = array();
               for ($i = 0; $i < count($new_speci) / 2; $i++) {
                   $jsonData[$arraySpeci[$i]] =$arrayRep[$i] ;
               }

                //Transforme en JSON
                $jsonData = json_encode($jsonData);
                $speci->data = $jsonData; 
                // dd($product->specification);
                $speci->save();
                return redirect()->back()->with('success', 'details product update');
            // dump($speci_current);
            // dd($new_speci);

        } else if($request->delnocheck == "delnocheck"){

            $comment = Comment::find($request->id);
            $comment->delete();
            return redirect()->back()->with('warning', 'comment delete');
            
        } else if($request->validate == "validate"){
            $comment = Comment::find($request->id);
            $comment->validate = 1;
            $comment->save();
            return redirect()->back()->with('success', 'comment validate');

        } else if ($request->editImage= "editImage"){
            $images = Image::find($request->id);
            $destination = "/img/productUpload/".$images->img;
            Storage::disk('public')->delete($destination);
            $images->delete();
            return redirect()->back()->with('warning', "image delete");
        }
        
    }

    public function image_update(Request $request)
    {
        $path = 'img/productUpload/';
        $file = $request->file('image');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $file->move(public_path($path), $new_image_name);

        $images = new Image();
        $images->product_id = $request->id;
        $images->img = $new_image_name;
        $images->save();
        return redirect()->back()->with('success', "new image add");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = Product::find($product);
        $previous = $product->type;
        foreach ($product->images as $value) {
            $destination = "/img/productUpload/".$value->img;
            Storage::disk('public')->delete($destination);
            # code...
        }



        $product->delete();
        if ($previous == "indoor") {
            return redirect()->to('/admin/products-indoor')->with('warning', "product delete");
            # code...
        }else if($previous == 'outdoor'){
            return redirect()->to('/admin/products-outdoor')->with('warning', "product delete");
        }

    }

}
