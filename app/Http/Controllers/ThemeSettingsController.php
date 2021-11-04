<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemeSettingsRequest;
use App\Models\ThemeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ThemeSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThemeSettingsRequest $request)
    {
        $themeSettings = ThemeSettings::where('user_id', $request->user()->id);
        $themeSettings->update([
            'themeColor' => $request->input('themeColor'),
            'fontStyle' => $request->input('fontStyle'),
            'lightVersion' => $request->input('lightVersion'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
