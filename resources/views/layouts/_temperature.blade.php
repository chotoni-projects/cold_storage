<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
    <div class="p-4 m-2 rounded-lg bg-gradient-to-r from-green-400 to-blue-500 text-white drop-shadow-xl relative">
        <h6 class="text-center">Temperature Cold Storage 1</h6>
        <div class="h-24 relative ">
            <div class="w-14 absolute left-0 top-5">
                <img src="/assets/thermo.svg" />
            </div>
            <div class="flex items-center justify-center h-full">
                <span id="temperature1" class="text-6xl font-semibold"></span>
                <span id="unit1" class="text-xl"></span>
            </div>
            <div id="error1" class="hidden">
                <span id="indicator1" class="flex h-4 w-4 absolute z-10 bottom-0 mb-[0.20rem]">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                </span>
                <span id="errorText1" class="ml-5 absolute text-sm text-left bottom-0 w-full" ></span>
            </div>
        </div>
    </div>
    <div class="p-4 m-2 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg  text-white drop-shadow-xl">
        <h6 class="text-center">Temperature Cold Storage 2</h6>
        <div class="h-24 relative ">
            <div class="w-14 absolute left-0 top-5">
                <img src="/assets/thermo.svg" />
            </div>
            <div class="flex items-center justify-center h-full">
                <span id="temperature2" class="text-6xl font-semibold"></span>
                <span id="unit2" class="text-xl"></span>
            </div>
            <div id="error2" class="hidden">
                <span id="indicator2" class="flex h-4 w-4 absolute z-10 bottom-0 mb-[0.20rem]">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                </span>
                <span id="errorText2" class="ml-5 absolute text-sm text-left bottom-0 w-full" ></span>
            </div>
        </div>
    </div>
    <div class="p-4 m-2 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg  text-white drop-shadow-xl">
        <h6 class="text-center">Temperature Cold Storage 3</h6>
        <div class="h-24 relative ">
            <div class="w-14 absolute left-0 top-4">
                <img src="/assets/thermo.svg" />
            </div>
            <div class="flex items-center justify-center h-full">
                <span id="temperature3" class="text-6xl font-semibold"></span>
                <span id="unit3" class="text-xl"></span>
            </div>
            <div id="error3" class="hidden ">
                <span id="indicator3" class="flex h-4 w-4 absolute z-10 bottom-0 mb-[0.20rem]">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                </span>
                <span id="errorText3" class="ml-5 absolute text-sm text-left bottom-0 w-full" ></span>
            </div>
        </div>
    </div>
    <div class="p-4 m-2 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg  text-white drop-shadow-xl">
        <h6 class="text-center">Temperature Cold Storage 4</h6>
        <div class="h-24 relative ">
            <div class="w-14 absolute left-0 top-5">
                <img src="/assets/thermo.svg" />
            </div>
            <div class="flex items-center justify-center h-full">
                <span id="temperature4" class="text-6xl font-semibold"></span>
                <span id="unit4" class="text-xl"></span>
            </div>
            <div id="error4" class="hidden">
                <span id="indicator4" class="flex h-4 w-4 absolute z-10 bottom-0 mb-[0.20rem]">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                </span>
                <span id="errorText4" class="ml-5 absolute text-sm text-left bottom-0 w-full" ></span>
            </div>
        </div>
    </div>
</div>
<script>
    var setError = function( index, show, message ) {
        if( show ) {
            $(`#error${index}`).removeClass('hidden')
            $(`#errorText${index}`).text(message)
            $(`#temperature${index}`).text('')
        } else {
            $(`#error${index}`).addClass('hidden')
            $(`#errorText${index}`).text('')
        }
    } 
    socket = io('http://localhost:3000');
    var room = "data";
    socket.on(room, function(msg) {
        var arrMsg = JSON.parse(msg)
        arrMsg.forEach(function(row){
            var sensorIndex = row.label.substr(-1)
            if( 'error' in row ) {
                setError(sensorIndex, true, row.error)
            } else {
                setError(sensorIndex, false )
                $(`#temperature${sensorIndex}`).text(row.value)
                $(`#unit${sensorIndex}`).html('&#8451;')
            }
        });
        console.log(msg)
    });
</script>