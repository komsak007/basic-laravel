<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(3);
        $trashDepartments = Department::onlyTrashed()->paginate(3);
        return view('admin.department.index', compact('departments', 'trashDepartments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required' => "กรุณาป้อนชื่อแผนก",
            'department_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            'department_name.unique' => "มีข้อมูลแผนกนี้อยู่แล้ว"
        ]
        );

        $department = new Department;
        $department->department_name = $request->department_name;
        $department->user_id = Auth::user()->id;
        
        $department->save();

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        $department = Department::find($id);

        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|unique:departments|max:255'
        ],
        [
            'department_name.required' => "กรุณาป้อนชื่อแผนก",
            'department_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            'department_name.unique' => "มีข้อมูลแผนกนี้อยู่แล้ว"
        ]
        );
        $update = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('department')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function softdelete($id)
    {
        $delete = Department::find($id)->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');
    }

    public function restore($id)
    {
        $restore = Department::withTrashed()->find($id)->restore();

        return redirect()->back()->with('success', 'กู้คืนข้อมูลสำเร็จ');
    }

    public function delete($id)
    {
        $delete = Department::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back()->with('success', 'ลบข้อมูลถาวรสำเร็จ');
    }
}
