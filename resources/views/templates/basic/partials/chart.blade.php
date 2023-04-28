@php


$rates = App\Models\CoinRate::select('id', 'price', 'created_at')
->whereRaw("id IN (SELECT MAX(id) FROM coin_rates GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d') )")
->where('created_at', '>=', now()->subDays(30))
->get();

if($rates->count()<7){
    $rates = App\Models\CoinRate::select('id', 'price', 'created_at')->latest()->take(30)->get();
    $rates = $rates->sortBy('id');
}


$currentRate = App\Models\CoinRate::latest()->first();
@endphp

<canvas id="myChart"></canvas>

@push('script-lib')
<script src="{{ asset($activeTemplateTrue.'js/lib/chart.min.js') }}"></script>
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        const ctx = document.getElementById("myChart").getContext("2d");
        let delayed;
        const labels = [@foreach($rates as $rate) "{{ $rate->created_at->format('d M H:i') }}", @endforeach ];
        const data = {
            labels,
            datasets:[
                {
                    data:[@foreach($rates as $rate) {{ getAmount($rate->price,8) }}, @endforeach],
                    label:"{{ $general->coin_name }} Rate",
                    fill:false,
                    borderColor:"#{{ $general->base_color }}",
                    pointBackgroundColor:"rgb(189,195,199)",
                }

            ],
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                radius:5,
                hitRadius:30,
                hoverRadius:12,
                responsive:true,
                scales:{
                    y:{
                        ticks:{
                            color: '#ffffff',
                            callback:function(value){
                                return "$"+value;
                            },
                        },
                    },
                    x:{
                        ticks:{ color: '#ffffff'}
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                }
            },
        };
        const myChart = new Chart(ctx,config);
    })(jQuery)
</script>
@endpush
