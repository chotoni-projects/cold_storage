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
                <th>Area Name</th>
                <th>Value</th>
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
  var dataset = [];
  var table = $('#report_table').DataTable({
    data: dataset,
    columns: [
            { data: 'created_at' },
            { data: 'name' },
            { data: 'value' },
        ],
  });
  $('#submit').on('click', function(){
    $('#submit').attr('disabled', 'disabled');
    var daterange = $('#datepicker').val()
    var param = ''
    if( daterange != '' ) {
      param = new URLSearchParams({
          from: daterange.split('to')[0].trim(),
          to: daterange.split('to')[1].trim(),
      })
    }
    fetch('/api/logging/?' + param ).then((response) => response.json()).then((data) => {
      dataset = data;
      table.clear().rows.add(data).draw();
      $('#submit').removeAttr('disabled');
    });  
  })
  fetch('/api/logging/' ).then((response) => response.json()).then((data) => {
      dataset = data;
      table.clear().rows.add(data).draw();
      $('#submit').removeAttr('disabled');
  });
  $('#excel').on('click', function(){
    /* generate worksheet and workbook */
    const worksheet = XLSX.utils.json_to_sheet(dataset);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Dates");

    // /* fix headers */
    // XLSX.utils.sheet_add_aoa(worksheet, [["Name", "Birthday"]], { origin: "A1" });

    // /* calculate column width */
    // const max_width = rows.reduce((w, r) => Math.max(w, r.name.length), 10);
    // worksheet["!cols"] = [ { wch: max_width } ];

    /* create an XLSX file and try to save to Presidents.xlsx */
    XLSX.writeFile(workbook, "Report.xlsx", { compression: true });
  })
});
</script>