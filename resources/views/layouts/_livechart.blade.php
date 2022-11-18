<div class="grid grid-cols-2">
    <div class="bg-white rounded-lg p-4 m-2">
        <div>
            <div id="chart1">

            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 m-2">
        <div>
            <div id="chart2">

            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 m-2">
        <div>
            <div id="chart3">

            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 m-2">
        <div>
            <div id="chart4">

            </div>
        </div>
    </div>
</div>
<script>
            
        var options = {
          series: [{
              name: "Temperature",
              data: []
          }],
          chart: {
            height: 300,
            type: 'line',
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'straight'
          },
          grid: {
            row: {
              colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
              opacity: 0.5
            },
          },
          xaxis: {
            categories: [],
          }
        };
        options.title = {
          text: 'Temperature 1',
          align: 'center'
        }
        var chart1 = new ApexCharts(document.querySelector("#chart1"), options);
        chart1.render();
        
        options.title = {
          text: 'Temperature 2',
          align: 'center'
        }
        var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
        chart2.render();
        
        options.title = {
          text: 'Temperature 3',
          align: 'center'
        }
        var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
        chart3.render();
        
        options.title = {
          text: 'Temperature 4',
          align: 'center'
        }
        var chart4 = new ApexCharts(document.querySelector("#chart4"), options);
        chart4.render();
        </script>