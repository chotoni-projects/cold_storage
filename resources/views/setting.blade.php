<x-app-layout>
    <div class="bg-white p-4 w-full md:w-1/2 m-4 rounded-lg">
        <div>
            <h4 class="text-center font-semibold text-xl">Email Notification</h4>
        </div>
        @if ($status = Session::get('status'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                <span class="font-medium">Success alert!</span> Data already changed.
            </div>
        @elseif ($status = Session::get('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <span class="font-medium">Fail alert!</span> Failed data update.
            </div>
        @endif
        <form name="setting"  method="post" action="{{url('store-setting', $setting->id)}}">
        @csrf
            <div class="mb-6">
                <label for="notification" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notification Status</label>
                <select id="notification" name="notification" value="{{$setting->notification}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="enable" <?php if($setting->notification == 'enable') {echo 'selected';}?> >Enable</option>
                    <option value="disable" <?php if($setting->notification == 'disable') {echo 'selected';}?> >Disable</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="host" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Server SMTP</label>
                <input type="text" id="host" name="host" value="<?php echo $setting->host;?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required>
            </div>
            <div class="mb-6">
                <label for="port" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Port SMTP</label>
                <input type="number" id="port" name="port" value="<?php echo $setting->port;?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Send Email Address From</label>
                <input type="email" id="from" name="from" value="<?php echo $setting->from;?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Send Email Address To</label>
                <input type="email" id="to" name="to" value="<?php echo $setting->to;?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="interval" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Interval (minutes)</label>
                <input type="number" id="interval" name="interval" value="<?php echo $setting->interval;?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Subject</label>
                <input type="text" id="subject" name="subject" value="<?php echo $setting->subject;?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>
</x-app-layout>
<script>
    // var enable = $('#select_n').val()
    // if( !enable ) {
    //     $('#host').attr('disabled', 'disabled')
    //     $('#port').attr('disabled', 'disabled')
    //     $('#to').attr('disabled', 'disabled')
    //     $('#from').attr('disabled', 'disabled')
    //     $('#interval').attr('disabled', 'disabled')
    // } else {
    //     $('#host').removeAttr('disabled', 'disabled')
    //     $('#port').removeAttr('disabled', 'disabled')
    //     $('#to').removeAttr('disabled', 'disabled')
    //     $('#from').removeAttr('disabled', 'disabled')
    //     $('#interval').removeAttr('disabled', 'disabled')
    // }
    // $('#select_n').on('change', function(){
    //     var enable = $('#select_n').val()
    //     $('#layer_n').val(enable)
    //     // $('#notification').val(enable).trigger('change');
    //     if( enable == 'disable' ) {
    //         $('#host').attr('disabled', 'disabled')
    //         $('#port').attr('disabled', 'disabled')
    //         $('#to').attr('disabled', 'disabled')
    //         $('#from').attr('disabled', 'disabled')
    //         $('#interval').attr('disabled', 'disabled')
    //     } else {
    //         console.log('disable')
    //         $('#host').removeAttr('disabled', 'disabled')
    //         $('#port').removeAttr('disabled', 'disabled')
    //         $('#to').removeAttr('disabled', 'disabled')
    //         $('#from').removeAttr('disabled', 'disabled')
    //         $('#interval').removeAttr('disabled', 'disabled')
    //     }
    // })
</script>
