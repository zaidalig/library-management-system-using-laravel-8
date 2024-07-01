<?php

namespace App\Http\Controllers;

use App\Models\settings;
use App\Http\Requests\StoresettingsRequest;
use App\Http\Requests\UpdatesettingsRequest;
use Exception;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('settings', ['data' => settings::latest()->first()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while loading the settings.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesettingsRequest  $request
     * @param  \App\Models\settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesettingsRequest $request)
    {
        try {
            $setting = settings::latest()->first();
            $setting->return_days = $request->return_days;
            $setting->fine = $request->fine;
            $setting->save();
            return redirect()->route('settings');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the settings.']);
        }
    }
}
