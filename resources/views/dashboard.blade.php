<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี {{Auth::user()->name}}

            <b class="float-right">จำนวนผู้ใช้ระบบ <span>{{count($users)}}</span> คน</b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">อีเมล</th>
                        <th scope="col">เข้าสู่ระบบ</th>
                      </tr>
                    </thead>
                    <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($users as $row)
                        <tr>
                            <th>{{$i++}}</th>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
</x-app-layout>
