<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">ตารางข้อมูล</div>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ชื่อแผนก</th>
                                <th scope="col">พนักงาน</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <th>{{$departments->firstItem()+$loop->index}}</th>
                                    <td>{{$department->department_name}}</td>
                                    <td>{{$department->user->name}}</td>
                                    <td>
                                        @if ($department->created_at == null)
                                            ไม่มีข้อมูล
                                        @else 
                                            {{Carbon\Carbon::parse($department->created_at)->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/department/edit/'. $department->id)}}">แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/department/softdelete/'. $department->id)}}">ลบข้อมูล</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                          </table>
                          {{$departments->links()}}
                    </div>
                    @if (count($trashDepartments) > 0)
                        <div class="card my-2">
                            <div class="card-header">ถังขยะ</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อแผนก</th>
                                    <th scope="col">พนักงาน</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">กู้คืนข้อมูล</th>
                                    <th scope="col">ลบข้อมูลถาวร</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($trashDepartments as $trashDepartment)
                                    <tr>
                                        <th>{{$trashDepartments->firstItem()+$loop->index}}</th>
                                        <td>{{$trashDepartment->department_name}}</td>
                                        <td>{{$trashDepartment->user->name}}</td>
                                        <td>
                                            @if ($trashDepartment->created_at == null)
                                                ไม่มีข้อมูล
                                            @else 
                                                {{Carbon\Carbon::parse($trashDepartment->created_at)->diffForHumans()}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/department/restore/'. $trashDepartment->id)}}">กู้คืนข้อมูล</a>
                                        </td>
                                        <td>
                                            <a href="{{url('/department/delete/'. $trashDepartment->id)}}">ลบถาวร</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </table>
                                {{$trashDepartments->links()}}
                        </div>
                    @endif
                    
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์ม</div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-outline-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
