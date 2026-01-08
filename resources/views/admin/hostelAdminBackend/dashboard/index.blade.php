@extends('admin.layouts.hostelAdminBackend')

@section('content')
    @php
        $hostelUser = Auth::user()->hostels()->withPivot('role_id')->first();
    @endphp
    @if (($hostelUser && $hostelUser->pivot->role_id == 2) || Auth::user()->role_id == 1)
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <a href="{{ route('hostelAdmin.user.index') }}">
                        <div class="card-body text-center"><i class="i-Add-User"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Users</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $totalUsers->count() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <a href="{{ route('hostelAdmin.block.index') }}">
                        <div class="card-body text-center"><i class="i-Home1"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Blocks</p>
                                <p class="text-primary text-24 line-height-1 mb-2">
                                    {{ $totalBlocks->where('is_deleted', 0)->count() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <a href="{{ route('hostelAdmin.resident.index') }}">
                        <div class="card-body text-center"><i class="i-Business-ManWoman"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Residents</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $totalResidents->count() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <a href="{{ route('hostelAdmin.staff.index') }}">
                        <div class="card-body text-center"><i class="i-Administrator"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Staffs</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $totalStaffs->count() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title text-center">Overall Income and Expenses</div>
                        <div id="echartBar" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div> --}}
    @endif
    @if ($hostelUser && $hostelUser->pivot->role_id == 3)
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <a href="{{ route('hostelAdmin.resident.index') }}">
                        <div class="card-body text-center"><i class="i-Business-ManWoman"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Residents</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $totalResidents->count() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <a href="{{ route('hostelAdmin.staff.index') }}">
                        <div class="card-body text-center"><i class="i-Administrator"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Staffs</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $totalStaffs->count() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Chart in Dashboard version 1
            var echartElemBar = document.getElementById("echartBar");

            if (echartElemBar) {
                var echartBar = echarts.init(echartElemBar);
                echartBar.setOption({
                    legend: {
                        borderRadius: 0,
                        orient: "horizontal",
                        x: "right",
                        data: ["Online", "Offline"],
                    },
                    grid: {
                        left: "8px",
                        right: "8px",
                        bottom: "0",
                        containLabel: true,
                    },
                    tooltip: {
                        show: true,
                        backgroundColor: "rgba(0, 0, 0, .8)",
                    },
                    xAxis: [{
                        type: "category",
                        data: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sept",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                        axisTick: {
                            alignWithLabel: true,
                        },
                        splitLine: {
                            show: false,
                        },
                        axisLine: {
                            show: true,
                        },
                    }, ],
                    yAxis: [{
                        type: "value",
                        axisLabel: {
                            formatter: "${value}",
                        },
                        min: 0,
                        max: 100000,
                        interval: 25000,
                        axisLine: {
                            show: false,
                        },
                        splitLine: {
                            show: true,
                            interval: "auto",
                        },
                    }, ],
                    series: [{
                            name: "Online",
                            data: [
                                35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000,
                                70000, 60000, 20000, 30005,
                            ],
                            label: {
                                show: false,
                                color: "#0168c1",
                            },
                            type: "bar",
                            barGap: 0,
                            color: "#bcbbdd",
                            smooth: true,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowOffsetY: -2,
                                    shadowColor: "rgba(0, 0, 0, 0.3)",
                                },
                            },
                        },
                        {
                            name: "Offline",
                            data: [
                                45000, 82000, 35000, 93000, 71000, 89000, 49000, 91000,
                                80200, 86000, 35000, 40050,
                            ],
                            label: {
                                show: false,
                                color: "#639",
                            },
                            type: "bar",
                            color: "#7569b3",
                            smooth: true,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowOffsetY: -2,
                                    shadowColor: "rgba(0, 0, 0, 0.3)",
                                },
                            },
                        },
                    ],
                });
                $(window).on("resize", function() {
                    setTimeout(function() {
                        echartBar.resize();
                    }, 500);
                });
            } // Chart in Dashboard version 1}
        });
    </script>
@endsection
