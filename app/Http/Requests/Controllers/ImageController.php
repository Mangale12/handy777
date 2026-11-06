<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->hasFile('image'))
        {
            foreach($request->file('image') as $img)
            {
                $name = time().'.'.$img->extension();
                $img->storeAs('uploads/image',$name);
                $images[] = $name;
            }
           
            // $image->image = $request->image->store('uploads/image');
            
        }
            $image = new Image();
            $image->image = json_encode($images);
            $image->position = 1;
            $image->status = 0;
            $image->save();
            return redirect()->to('home/image-upload');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
         return redirect()->to('home/image-upload');
    }
    
    public function updateStatus(Request $request)
    {
        
        $image = Image::find($request->id);
        $image->status = $request->status;
        if($request->status == 1){
            if(count(Image::where('status', 1)->get()) < 4)
            {
                if($image->save()){
                    return '1';
                }
                else {
                    return '0';
                }
            }
        }
        else{
            if($image->save()){
                return '1';
            }
            else {
                return '0';
            }
        }

        return '0';
    }
}
