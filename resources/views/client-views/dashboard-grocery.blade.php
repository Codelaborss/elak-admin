@extends('layouts.client.app')
@section('title',"Client Dashboard")

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center py-2">
            <div class="col-sm mb-2 mb-sm-0">
                <div class="d-flex align-items-center">
                    <img src="{{asset('/public/assets/admin/img/grocery.svg')}}" alt="img">
                    <div class="w-0 flex-grow pl-2">
                        <h1 class="page-header-title mb-0">Welcome, Client.</h1>
                        <p class="page-header-text m-0">This is your client dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Stats -->
    <div class="card mb-3">
        <div class="card-body pt-0">
            <div class="row g-2" id="order_stats">
                <div class="col-sm-6 col-lg-3">
                    <div class="__dashboard-card-2">
                        <img src="{{asset('/public/assets/admin/img/dashboard/grocery/items.svg')}}" alt="dashboard/grocery">
                        <h6 class="name">Items</h6>
                        <h3 class="count">150</h3>
                        <div class="subtxt">10 newly added</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="__dashboard-card-2">
                        <img src="{{asset('/public/assets/admin/img/dashboard/grocery/orders.svg')}}" alt="dashboard/grocery">
                        <h6 class="name">Orders</h6>
                        <h3 class="count">230</h3>
                        <div class="subtxt">15 newly added</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="__dashboard-card-2">
                        <img src="{{asset('/public/assets/admin/img/dashboard/grocery/stores.svg')}}" alt="dashboard/grocery">
                        <h6 class="name">Stores</h6>
                        <h3 class="count">25</h3>
                        <div class="subtxt">2 newly added</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="__dashboard-card-2">
                        <img src="{{asset('/public/assets/admin/img/dashboard/grocery/customers.svg')}}" alt="dashboard/grocery">
                        <h6 class="name">Customers</h6>
                        <h3 class="count">500</h3>
                        <div class="subtxt">20 newly added</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Stats -->

    <div class="row g-2">
        <div class="col-lg-8 col--xl-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center __gap-12px">
                        <div class="__gross-amount" id="gross_sale">
                            <h6>$12,500</h6>
                            <span>Gross Sale</span>
                        </div>
                        <div class="chart--label __chart-label p-0 move-left-100 ml-auto">
                            <span class="indicator chart-bg-2"></span>
                            <span class="info">
                                Sale (2025)
                            </span>
                        </div>
                        <select class="custom-select border-0 text-center w-auto ml-auto">
                            <option selected>This year</option>
                            <option>This month</option>
                            <option>This week</option>
                        </select>
                    </div>
                    <div id="commission-overview-board">
                        <div id="grow-sale-chart" style="height:200px; background:#f7f7f7; display:flex; align-items:center; justify-content:center;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col--xl-4">
            <!-- Card -->
            <div class="card h-100">
                <div class="card-header border-0">
                    <h5 class="card-header-title">User Statistics</h5>
                    <select class="custom-select border-0 text-center w-auto">
                        <option selected>This year</option>
                        <option>This month</option>
                        <option>This week</option>
                        <option>Overall</option>
                    </select>
                </div>
                <div class="card-body">
                    <div class="position-relative pie-chart">
                        <div id="dognut-pie" style="height:200px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                        </div>
                        <div class="total--orders">
                            <h3 class="text-uppercase mb-xxl-2">750</h3>
                            <span class="text-capitalize">Total Users</span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center mt-4">
                        <div class="chart--label">
                            <span class="indicator chart-bg-1"></span>
                            <span class="info">Customers: 500</span>
                        </div>
                        <div class="chart--label">
                            <span class="indicator chart-bg-2"></span>
                            <span class="info">Stores: 25</span>
                        </div>
                        <div class="chart--label">
                            <span class="indicator chart-bg-3"></span>
                            <span class="info">Delivery Men: 225</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@push('script')
    <script src="{{asset('public/assets/admin')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script src="{{asset('public/assets/admin')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>

    <!-- Apex Charts -->
    <script src="{{asset('/public/assets/admin/js/apex-charts/apexcharts.js')}}"></script>
    <!-- Apex Charts -->

@endpush


@push('script_2')

    <!-- Dognut Pie Chart -->
    <script>
        "use strict";
        let options;
        let chart;
        options = {
            series: [{{ $data['customer']}}, {{$data['stores']}}, {{$data['delivery_man']}}],
            chart: {
                width: 320,
                type: 'donut',
            },
            labels: ['{{ translate('Customer') }}', '{{ translate('Store') }}', '{{ translate('Delivery man') }}'],
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#005555', '#00aa96', '#b9e0e0',]
                }
            },
            responsive: [{
                breakpoint: 1650,
                options: {
                    chart: {
                        width: 250
                    },
                }
            }],
            colors: ['#005555','#00aa96', '#111'],
            fill: {
                colors: ['#005555','#00aa96', '#b9e0e0']
            },
            legend: {
                show: false
            },
        };

        chart = new ApexCharts(document.querySelector("#dognut-pie"), options);
        chart.render();


        options = {
            series: [{
                name: '{{ translate('Gross Sale') }}',
                data: [{{ implode(",",$total_sell) }}]
            },{
                name: '{{ translate('Admin Comission') }}',
                data: [{{ implode(",",$commission) }}]
            },{
                name: '{{ translate('Delivery Comission') }}',
                data: [{{ implode(",",$delivery_commission) }}]
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show:false
                },
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            colors: ['#76ffcd','#ff6d6d', '#005555'],
            dataLabels: {
                enabled: false,
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            fill: {
                type: 'gradient',
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            xaxis: {
                //   type: 'datetime',
                categories: [{!! implode(",",$label) !!}]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        chart = new ApexCharts(document.querySelector("#grow-sale-chart"), options);
        chart.render();


    <!-- Dognut Pie Chart -->

        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        let updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));


        $('.order_stats_update').on('change', function (){
            let type = $(this).val();
            order_stats_update(type);
        })

        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard-stats.order')}}',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('statistics_type',type);
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        $('.fetch_data_zone_wise').on('change', function (){
            let zone_id = $(this).val();
            fetch_data_zone_wise(zone_id);
        })


        function fetch_data_zone_wise(zone_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard-stats.zone')}}',
                data: {
                    zone_id: zone_id
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('zone_id', zone_id);
                    $('#order_stats').html(data.order_stats);
                    $('#user-overview-boarde').html(data.user_overview);
                    $('#monthly-earning-graph').html(data.monthly_graph);
                    $('#popular-restaurants-view').html(data.popular_restaurants);
                    $('#top-deliveryman-view').html(data.top_deliveryman);
                    $('#top-rated-foods-view').html(data.top_rated_foods);
                    $('#top-restaurants-view').html(data.top_restaurants);
                    $('#top-selling-foods-view').html(data.top_selling_foods);
                    $('#stat_zone').html(data.stat_zone);
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        $('.user_overview_stats_update').on('change', function (){
            let type = $(this).val();
            user_overview_stats_update(type);
        })


        function user_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard-stats.user-overview')}}',
                data: {
                    user_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('user_overview',type);
                    $('#user-overview-board').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        $('.commission_overview_stats_update').on('change', function (){
            let type = $(this).val();
            commission_overview_stats_update(type);
        })


        function commission_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard-stats.commission-overview')}}',
                data: {
                    commission_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('commission_overview',type);
                    $('#commission-overview-board').html(data.view)
                    $('#gross_sale').html(data.gross_sale)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        function insert_param(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            let kvp = document.location.search.substr(1).split('&');
            let i = 0;

            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            // change url page with new params
            window.history.pushState('page2', 'Title', '{{url()->current()}}?' + params);
        }
    </script>
@endpush
