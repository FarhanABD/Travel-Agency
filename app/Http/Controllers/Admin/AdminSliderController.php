<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class AdminSliderController extends Controller
{
    public function index(){
        $sliders = Slider::all();
        return view('admin.slider.index',compact('sliders'));
    }

    public function create(){
        return view('admin.slider.create');
    }

  public function create_submit(){
    request()->validate([
        'photo' => 'required|image',
        'heading' => 'required',
        'text' => 'required',
        'button_text' => 'nullable',
        'button_url' => 'nullable',
    ]);

    $slider = new Slider();

    if(request()->hasFile('photo')){
        $photo = request()->file('photo');
        $photo_name = time().'.'.$photo->getClientOriginalExtension();
        $photo->move(public_path('uploads/sliders/'), $photo_name);
        $slider->photo = $photo_name;
    }

    $slider->heading = request('heading');
    $slider->text = request('text');
    $slider->button_text = request('button_text');
    $slider->button_url = request('button_url');

    $slider->save();

    return redirect()->route('admin_slider_index')
                     ->with('success','Slider created successfully.');
}

    public function edit($id)
    {
        $slider = Slider::where('id',$id)->first();
        return view('admin.slider.edit',compact('slider'));
    }
    
    public function edit_submit(Request $request, $id)
    {
        $slider = Slider::where('id',$id)->first();
        
        $request->validate([
            'heading' => 'required',
            'text' => 'required',
        ]);

        if($request->hasFile('photo'))
        {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            unlink(public_path('uploads/sliders/'.$slider->photo));

            $final_name = 'slider_'.time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads/sliders'), $final_name);
            $slider->photo = $final_name;
        }
        
        $slider->heading = $request->heading;
        $slider->text = $request->text;
        $slider->button_text = $request->button_text;
        $slider->button_url = $request->button_url;
        $slider->save();

        return redirect()->route('admin_slider_index')->with('success','Slider Updated Successfully');
    }

     public function delete($id)
    {
        $slider = Slider::where('id',$id)->first();
        unlink(public_path('uploads/'.$slider->photo));
        $slider->delete();
        return redirect()->route('admin_slider_index')->with('success','Slider Deleted Successfully');
    }

}