<div class="grid">
    <div class="bg-white rounded-lg p-4 m-2">
      <div >
        <h4 class="text-center font-semibold text-xl">Report Temperature</h4>
        
        <div class="flex gap-4 mb-4">
          <input id="datepicker" class="block w-max-[250px] p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 "></input>
          <button id="submit" class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Get Data</button>
          <button id="excel" class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Export Excel</button>
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
  $("#datepicker").flatpickr({
    mode: "range"
  });
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
            { data: 'created_at' },
            { data: 'value1' },
            { data: 'value2' },
            { data: 'value3' },
            { data: 'value4' },
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