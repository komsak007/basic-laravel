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
                        <div class="card-header">ตารางข้อมูลบริการ</div>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ภาพประกอบ</th>
                                <th scope="col">ชื่อบริการ</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <th>{{$services->firstItem()+$loop->index}}</th>
                                    <td>
                                        <img src="{{asset($service->service_image)}}" alt="" width="100px" height="70px">
                                    </td>
                                    <td>{{$service->service_name}}</td>
                                    <td>
                                        @if ($service->created_at == null)
                                            ไม่มีข้อมูล
                                        @else 
                                            {{Carbon\Carbon::parse($service->created_at)->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/service/edit/'. $service->id)}}">แก้ไข</a>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('คุณต้องการลบข้อมูลบริการหรือไม่ ?')" href="{{url('/service/delete/'. $service->id)}}">ลบข้อมูล</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                          </table>
                          {{$services->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มบริการ</div>
                        <div class="card-body">
                            <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
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
