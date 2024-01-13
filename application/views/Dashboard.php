<div class="theme-body" data-simplebar>
    <div class="custom-container common-dash">
        <div class="row">
            <div class="col-xxl-12 col-sm-12 cdx-xxl-50">
                <div class="card visitor-performance">
                    <div class="card-header">
                        <h4>Visitors Performance</h4>
                        <div class="setting-card action-menu">
                            <div class="action-toggle"><i class="codeCopy" data-feather="more-horizontal"></i></div>
                            <ul class="action-dropdown">
                                <li><a href="javascript:void(0);"><i class="fa fa-calendar-o"></i>weekly</a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o"></i>monthly</a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-calendar"></i>yearly</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="visitor-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //***  Visitors Performance start  ***/
        $.when(getPerformLabor()).done(function() {});

        function getPerformLabor() {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getPerformLabor/') ?>`,
                'type': 'get',
                // data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataChartPerformLabor = json['data'];
                    renderPerform(dataChartPerformLabor);
                },
                error: function(e) {}
            });
        }

        function renderPerform(data) {

            var options = {
                series: [{
                    name: 'Jumlah Komputer',
                    data: data['komputer']
                }, {
                    name: 'Jumlah Peminjaman',
                    data: data['peminjaman']
                }],
                chart: {
                    height: 330,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                grid: {
                    strokeDashArray: 2,
                },
                stroke: {
                    width: [4, 4],
                    curve: 'smooth',
                    dashArray: [6]
                },
                legend: {
                    show: false,
                },
                colors: [Codexdmeki.themeprimary, Codexdmeki.themesecondary],
                yaxis: {
                    labels: {
                        formatter: function(y) {
                            return y.toFixed(0) + "k";
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#262626',
                            fontSize: '14px',
                            fontWeight: 500,
                            fontFamily: 'Roboto, sans-serif'
                        },
                    },
                },
                xaxis: {
                    categories: data['nama_labor'],
                    labels: {
                        style: {
                            colors: '#262626',
                            fontSize: '14px',
                            fontWeight: 500,
                            fontFamily: 'Roboto, sans-serif'
                        },
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                responsive: [{
                        breakpoint: 1441,
                        options: {
                            chart: {
                                height: 320
                            }
                        },
                    },
                    {
                        breakpoint: 420,
                        options: {
                            legend: {
                                position: 'bottom',
                            },
                        },
                    },
                ]
            };
            var chart = new ApexCharts(document.querySelector("#visitor-chart"), options);
            chart.render();
        }
        //**** Visitors Performance end  ***//

    });
</script>