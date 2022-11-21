<div class="grid grid-cols-1 md:grid-cols-2">
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
            },
            animations: {
              enabled: true,
              easing: 'linear',
              dynamicAnimation: {
                speed: 5000
              }
            },
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
            type: 'datetime',
          },
          yaxis: {
            max: 10,
            min: -50
          },
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

        var data = {
          'Temperature1': [],
          'Temperature2': [],
          'Temperature3': [],
          'Temperature4': [],
        }
        var limit = 10
        var room = "data";
        socket.on(room, function(msg) {
            var arrMsg = JSON.parse(msg)
            arrMsg.forEach(function(row){
                if( 'error' in row ) {

                } else {
                  data[row.label].push({
                    y: row.value,
                    // x: row.created_at.substr(5,5).replace('-', '/') + ' ' + row.created_at.substr(11,8)
                    x: new Date(row.created_at)
                  })
                }
            });
            if( data['Temperature1'].length > limit ) data['Temperature1'].shift()
            if( data['Temperature2'].length > limit ) data['Temperature2'].shift()
            if( data['Temperature3'].length > limit ) data['Temperature3'].shift()
            if( data['Temperature4'].length > limit ) data['Temperature4'].shift()
            chart1.updateSeries([{
              data: data['Temperature1']
            }])
            chart2.updateSeries([{
              data: data['Temperature2']
            }])
            chart3.updateSeries([{
              data: data['Temperature3']
            }])
            chart4.updateSeries([{
              data: data['Temperature4']
            }])
        });
</script>