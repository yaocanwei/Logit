<?php

namespace Logit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Logit\Settings;

class SettingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('timezone');
    }
    
    public function settings ()
    {
		$brukerinfo = Auth::user();

        $settings = Settings::where('user_id', Auth::id())
            ->first();

        $topNav = [
            0 => [
                'url'  => '/user/settings',
                'name' => 'Settings'
            ]
        ];

        return view('user.settings', [
            'topNav'     => $topNav,
            'settings'   => $settings,
            'brukerinfo' => $brukerinfo
        ]);
    }

    public function editSettings (Request $request)
    {
        $data = $request->all();

        $settings = Settings::where('user_id', Auth::id())
            ->first();

        // If there is an instance of the user already in our settingstable
        if ($settings) {
            $settings->user_id = Auth::id();
        }
        // Else, create a new instance
        else {
            $settings = new Settings;
        }

        $settings->unit = $data['unit'];
        $settings->timezone = $data['timezone'];

        if (!array_key_exists('recap', $data)) {
            $settings->recap = 0;
        } else {
            $settings->recap = 1;
        }

        if (!array_key_exists('share_workouts', $data)) {
            $settings->share_workouts = 0;
        } else {
            $settings->share_workouts = 1;
        }

        if (!array_key_exists('accept_friends', $data)) {
            $settings->accept_friends = 0;
        } else {
            $settings->accept_friends = 1;
        }

        if ($settings->save()) {
            return back()->with('script_success', 'Settings updated.');
        }


        return back()->with('script_danger', 'Something went wrong. Please try again.');
    }
}
