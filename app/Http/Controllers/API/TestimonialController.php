<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Testimonial;
use Image;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(5);
        return $testimonials;
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
            'photo' => 'required',
            'details' => 'required|min:10',
            'name' => 'required|min:4|max:25',
        ]);

        $strpos = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $strpos);
        $ex = explode('/', $sub)[1];
        $name = time() . '.' . $ex;
        $img = Image::make($request->photo)->resize(260, 260);
        $path = public_path() . '/assets/admin/image/upload/';
        $img->save($path . $name);

        $testimonials = new Testimonial();
        $testimonials->photo = $name;
        $testimonials->details = $request->details;
        $testimonials->name = $request->name;
        $testimonials->save();
        return $testimonials;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $testimonials = Testimonial::find($id);


        if ($request->photo != $testimonials->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . '.' . $ex;
            $img = Image::make($request->photo)->resize(260, 260);
            $path = public_path() . '/assets/admin/image/upload/';
            $image = $path . $testimonials->photo;
            $img->save($path . $name);

            if (file_exists($image)) {
                @unlink($image);
            }
        } else {
            $name = $testimonials->photo;
        }
        $testimonials->photo = $name;
        $testimonials->details = $request->details;
        $testimonials->name = $request->name;
        $testimonials->save();
        return $testimonials;
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
}
