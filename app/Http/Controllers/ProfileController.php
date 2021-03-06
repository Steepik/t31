<?php

namespace App\Http\Controllers;

use App\ExportXls;
use App\Http\Requests\ProfileInfoRequest;
use App\Http\Requests\ProfilePasswordRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Session;

class ProfileController extends Controller
{
    /**
     * @var User
     */
    public $user;

    /**
     * ProfileController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $wholesaler = Auth::user()->is_wholesaler;

        return view('profile.index', compact('user', 'wholesaler'));
    }

    public function updateInfo(ProfileInfoRequest $request)
    {
        $user = $this->user->find(Auth::user()->id);
        $result = $user->update($request->except('_token'));

        if(isset($request->hideOptPrice)) {
            Session::put('hideOpt', true);
        } else {
            Session::forget('hideOpt');
        }

        if($result) {
            return redirect()->back()->with('success', '');
        }
    }

    public function updatePass(ProfilePasswordRequest $request)
    {
        $user = $this->user->find(Auth::user()->id);
        $check = Hash::check($request->old_pass, $user->password);

        //if old password doesn't match
        if(!$check) {
            return redirect()->back()->withErrors(Lang::get('messages.old_wrong_password'));
        }

        //if all is good
        $password = Hash::make($request->password);
        $result = $user->update(['password' => $password]);

        if($result) {
            return redirect()->back()->with('success-pass', '');
        }
    }

    public function excelDownload($type)
    {
        if(ExportXls::export($type)) {
            //download started
        } else {
            return redirect('/excel-download');
        }
    }
}
