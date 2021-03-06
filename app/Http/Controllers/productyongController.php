<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;
use App\Productyong;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportProductyong;

class productyongController extends Controller
{
    public function ImportProductPage(){
        return view('productyong.importProductYSCPage');
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productyong.addProductYSCPage');
    }
    
    public function index(){

        $products = Productyong::get();
        return view('productyong.viewProductYSCPage', ['products' => $products]);
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Productyong $product)
    {
        return view('productyong.viewProductYSCPage',compact('product'));
    }

 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required',
            'name' => 'required',
            'type' => 'required',
            'purchase_price' => 'required',
            'available_amount' => 'required',
            'purchase_unit' => 'required',
            'packing_purchase' => 'required',
            'retail_price' => 'required',
            'retail_unit' => 'required',
            'retail_packing' => 'required',
        ]);
  
        Productyong::create($request->all());
   
        return redirect()->route('productsYSC.index')
                        ->with('success','Product created successfully.');
    }
   
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Productyong $product)
    {
        return view('productyong.editProductYSCPage',compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Productyong $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
  
        $product->update($request->all());
  
        return redirect()->route('productsYSC.index')
                        ->with('success','Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Productyong::findOrFail($id);
        $product->delete();
        $deleteSort = Productyong::withTrashed()->get();
  
        return redirect()->route('productsYSC.index')
                        ->with('success','Product deleted successfully');
    }

    public function import() 
    {
        Excel::import(new ImportProductyong, request()->file('file'));
             
        return redirect()->route('productsYSC.index')
                        ->with('success','Product Import successfully');
    }



}

