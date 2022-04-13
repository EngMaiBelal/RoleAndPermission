<?php

namespace App\Http\Controllers;

use App\traits\generalTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;



class ProductController extends Controller
{
    use generalTrait;
    public function index(){
        $products = DB::table('products')->get();
        return view ('products.index',compact('products'));
    }


    public function create(){

        return view ('products.create');
    }

    public function store (StoreProductRequest $request){

        $data =  $request->except('_token','index','return');
        DB::table('products')->insert($data);

        // Redirect Page
        return $this->redirectAccordingToRequest($request);
    }

        public function edit(Request $request,$id){
            $product = DB::table('products')->where('id',$id)->first();
            return view ('products.edit',compact('product'));
        }


        public function update (UpdateProductRequest $request){

            $data =  $request->except('_token','index','return','_method');
            // Insert Data
            DB::table('products')->where('id',$request->id)->update($data);

            // Redirect Page
            return $this->redirectAccordingToRequest($request);
        }




        public function destroy (Request $request,$id){

            DB::table('products')->where('id',$id)->delete();
            return $this->redirectAccordingToRequest($request);
        }

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    public function redirectAccordingToRequest($request)
    {
      if($request->index){
        return redirect()->route('products.index')->with('message','success operation');
      }else{
        return redirect()->back()->with('message','success operation');
      }
    }


}
