<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $setting = Setting::first();
        if( $setting )
            return view('setting', compact('setting'));
        else 
        return view('setting', ['setting' => null]);
    }

    public function store(Request $request, $id)
    {
        // dd($request->all());

        try {
            $hasil = $request->validate([
                'from'          => 'required|email',
                'to'            => 'required|email',
                'interval'      => 'required|integer',
                'host'          => 'required',
                'port'          => 'required|integer',
                'notification'  => 'required',
                'subject'       => 'required'
            ]);
            // dd($hasil);
            // $notif = $request->get('notification');
            
            $setting = Setting::find($id)->update($request->all());
            // $setting = Setting::find($id)->update(['notification' => $notif]);
            // dd(\DB::getQueryLog());
            // $setting = Setting::find($id); 
            // dd($setting);
            return redirect('setting')->with('status', 'Success')->with('data', compact('setting'));
        }catch(Handler $ex) {
            $setting = Setting::find($id);
            return redirect('setting')->with('error', 'Error')->with('data', compact('setting'));
        }
    }
}
