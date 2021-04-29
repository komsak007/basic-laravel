<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5);
        return view('admin.service.index', compact('services'));
    }

    public function edit($id)
    {
        $services = Service::find($id);

        return view('admin.service.edit', compact('services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|max:255',
        ],
        [
            'service_name.required' => "กรุณาป้อนชื่อบริการ",
            'service_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
        ]
        );
        $service_image = $request->file('service_image');

        if($service_image) {
            $name_generate = hexdec(uniqid());
        $image_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_generate . '.' . $image_ext;

        $upload_location = 'image/services/';
        $full_path = $upload_location.$img_name;

        Service::find($id)->update([
            'service_name'=>$request->service_name,
            'service_image'=>$full_path,
        ]);

        $old_image = $request->old_image;
        unlink($old_image);

        $service_image->move($upload_location,$img_name);

        return redirect()->route('services')->with('success', 'แก้ไขภาพบริการสำเร็จ');

        } else {
            Service::find($id)->update([
                'service_name'=>$request->service_name,
            ]);
            return redirect()->route('services')->with('success',"อัพเดตชื่อบริการเรียบร้อย");
        }

        return redirect()->route('department')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|unique:services|max:255',
            'service_image' => 'required|mimes:jpg,jpeg,png'
        ],
        [
            'service_name.required' => "กรุณาป้อนชื่อบริการ",
            'service_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            'service_name.unique' => "มีข้อมูลบริการนี้อยู่แล้ว",
            'service_image.required' => "กรุณาใส่ภาพประกอบการบริการ",
        ]
        );

        $service_image = $request->file('service_image');

        $name_generate = hexdec(uniqid());
        $image_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_generate . '.' . $image_ext;

        $upload_location = 'image/services/';
        $full_path = $upload_location.$img_name;

        Service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now()
        ]);

        $service_image->move($upload_location,$img_name);

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function delete($id)
    {
        $img = Service::find($id)->service_image;
        unlink($img);

        $delete = Service::find($id)->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
