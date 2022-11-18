<div class="grid">
    <div class="bg-white rounded-lg p-4 m-2">
      <div >
        <h4 class="text-center font-semibold text-xl">Report Temperature</h4>
      <table id="report_table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Datetime</th>
                <th>Area Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>10 Januari 2023</td>
                <td>Cold Storage 1</td>
                <td>-10 C</td>
            </tr>
            <tr>
                <td>10 Januari 2023</td>
                <td>Cold Storage 1</td>
                <td>-10 C</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#report_table').DataTable();
});
</script>