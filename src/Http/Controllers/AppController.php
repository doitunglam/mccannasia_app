<?php

namespace Goeasyapp\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goeasyapp\Core\Http\Hooks\LoginValidateHook;
use Goeasyapp\Core\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    private $useHook;
    private $useRepository;
    public function __construct(LoginValidateHook $LoginValidateHook, UserRepository $UserRepository)
    {
        $this->useHook = $LoginValidateHook;
        $this->useRepository = $UserRepository;
    }
    public function home()
    {
        return view('app::home');
    }
    /* begin author Doi Tung Lam */

    public function homeAboutUs()
    {
        return view('app::aboutUs');
    }

    

    public function publisherOverview()
    {
        return view('app::publisherOverview');
    }

    public function publisherPolicy()
    {
        return view('app::publisherPolicy');
    }

    public function contact()
    {
        return view('app::contact');
    }

    /* end author Doi Tung Lam */
    public function introduce($id)
    {
        session()->put('introduce', $id);
        return redirect()->intended('/');
    }
    public function dashboard()
    {
        return view('app::dashboard');
    }
    public function localeCn()
    {
        session()->put('locale', 'cn');
        return redirect()->back();
    }
    public function localeEn()
    {
        session()->put('locale', 'en');
        return redirect()->back();
    }
    public function localeVi()
    {
        session()->put('locale', 'vi');
        return redirect()->back();
    }
	 public function aboutUs()
    {
        return view('app::aboutUs');
    }

    public function advertiser()
    {
        return view('app::advertiser');
    }

    

    


}
