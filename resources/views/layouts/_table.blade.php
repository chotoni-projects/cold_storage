<div class="grid">
    <div class="bg-white rounded-lg p-4 m-2">
      <div >
        <h4 class="text-center font-semibold text-xl">Report Temperature</h4>
        <div class="flex justify-between">
          <div class="flex items-center mb-4 pt-10">
              <input id="livestream" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="livestream" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Live Update</label>
            </div>
          <div class="flex gap-4 mb-4">
            
            <div class="w-64">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Date</label>
                <input id="datepicker" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Range Date" required>
            </div>
            <div>
                <label for="first_name" class="block mb-5 text-sm font-medium text-gray-900 dark:text-white"></label>
                <button id="submit" class="mt-2 items-end  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Get Data</button>
            </div>
            <div>
                <label for="first_name" class="block mb-5 text-sm font-medium text-gray-900 dark:text-white"></label>
                <button id="excel" class="mt-2 items-end  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Export Excel</button>
            </div>
          </div>
        </div>
        
      <table id="report_table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Datetime</th>
                <th>Export Temperature 1</th>
                <th>Export Temperature 2</th>
                <th>Import Temperature 1</th>
                <th>Import Temperature 2</th>
            </tr>
        </thead>
        <tbody>
          </tbody>
        </table>
      </div>
    </div>
</div>
<script>
$(document).ready(function () {
  var live = false;
  var loopTable = null;
  $('#livestream').on('change', function(){
    live = $('#livestream').is(":checked")
    console.log('live', live)
    if( !live ) clearInterval(loopTable)
    else {
      $("#datepicker").val('')
      loopTable = setInterval(() => {
        console.log('live')
        fetch('/api/logging/' ).then((response) => response.json()).then((data) => {
            dataset = convert(data);
            table.clear().rows.add(data).draw();
            $('#submit').removeAttr('disabled');
        });
      }, 5000);
    }
  })

  $("#datepicker").flatpickr({
    mode: "range"
  });
  $("#datepicker").on('change', function(){
    var dateData = $('#datepicker').val()
    $( "#livestream" ).prop( "checked", false );
    clearInterval(loopTable)
  })
  dataset = [];
  var convert = function (row) {
    return row.map( function(doc){
      doc.created_at = doc.created_at.substr(0,19).replace('T', ' ')
      return doc
    })
  }
  var table = $('#report_table').DataTable({
    data: dataset,
    ordering: false,
    columns: [
            { width: "30%", data: 'created_at', className: 'text-center'  },
            { data: 'value1', className: 'text-center' },
            { data: 'value2', className: 'text-center'  },
            { data: 'value3', className: 'text-center'  },
            { data: 'value4', className: 'text-center'  },
        ]
  });
  $('#submit').on('click', function(){
    $('#submit').attr('disabled', 'disabled');
    var daterange = $('#datepicker').val()
    var param = ''
    if( daterange != '' ) {
      param = new URLSearchParams({
          from: daterange.indexOf('to') > -1 ? daterange.split('to')[0].trim() : daterange,
          to: daterange.indexOf('to') > -1 ? daterange.split('to')[1].trim() : daterange,
      })
    }
    fetch('/api/logging/?' + param ).then((response) => response.json()).then((data) => {
      dataset = convert(data);
      table.clear().rows.add(data).draw();
      $('#submit').removeAttr('disabled');
    });  
  })
  fetch('/api/logging/' ).then((response) => response.json()).then((data) => {
      dataset = convert(data);
      table.clear().rows.add(data).draw();
      $('#submit').removeAttr('disabled');
  });
  $('#excel').on('click', function(){
    // Load an existing workbook
    
    // /* generate worksheet and workbook */
    // const worksheet = XLSX.utils.json_to_sheet(dataset);
    // const workbook = XLSX.utils.book_new();
    // XLSX.utils.book_append_sheet(workbook, worksheet, "Dates");

    // // /* fix headers */
    // // XLSX.utils.sheet_add_aoa(worksheet, [["Name", "Birthday"]], { origin: "A1" });

    // // /* calculate column width */
    // // const max_width = rows.reduce((w, r) => Math.max(w, r.name.length), 10);
    // // worksheet["!cols"] = [ { wch: max_width } ];

    // /* create an XLSX file and try to save to Presidents.xlsx */
    // XLSX.writeFile(workbook, "Report.xlsx", { compression: true });


    generateBlob()
  })

  var Promise = XlsxPopulate.Promise;

  function getWorkbook() {
        if (false) {
            return XlsxPopulate.fromBlankAsync();
        } else if (true) {
            return new Promise(function (resolve, reject) {
                var req = new XMLHttpRequest();
                var url = '/assets/Book1.xlsx';
                req.open("GET", url, true);
                req.responseType = "arraybuffer";
                req.onreadystatechange = function () {
                    if (req.readyState === 4){
                        if (req.status === 200) {
                            resolve(XlsxPopulate.fromDataAsync(req.response));
                        } else {
                            reject("Received a " + req.status + " HTTP code.");
                        }
                    }
                };

                req.send();
            });
        } else if (false) {
            var file = fileInput.files[0];
            if (!file) return Promise.reject("You must select a file.");
            return XlsxPopulate.fromDataAsync(file);
        }
    }

    function generate(type) {
        return getWorkbook()
            .then(async function (workbook) {
              var daterange = $('#datepicker').val()
              var param = ''
              if( daterange != '' ) {
                param = new URLSearchParams({
                    from: daterange.indexOf('to') > -1 ? daterange.split('to')[0].trim() : daterange,
                    to: daterange.indexOf('to') > -1 ? daterange.split('to')[1].trim() : daterange,
                })
              }
              var data = await fetch('/api/logging/?' + param ).then((response) => response.json())
                var convdata = data.map( function(doc){
                  return [doc.created_at.substr(0,19).replace('T', ' '), doc.value1, doc.value2, doc.value3, doc.value4]
                } )
                console.log(convdata, 'asd')
                workbook.sheet(0).cell("A3").value(convdata);
                return workbook.outputAsync({ type: type });  
                
            });
    }

    function generateBlob() {
        return generate()
            .then(function (blob) {
                if (window.navigator && window.navigator.msSaveOrOpenBlob) {
                    window.navigator.msSaveOrOpenBlob(blob, "Report Cold Storage.xlsx");
                } else {
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    document.body.appendChild(a);
                    a.href = url;
                    a.download = "Report Cold Storage.xlsx";
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                }
            })
            .catch(function (err) {
                alert(err.message || err);
                throw err;
            });
    }
});
</script>