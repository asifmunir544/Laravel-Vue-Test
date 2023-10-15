<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function users(){
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function updateUser(Request $request)
    {
        $user = User::find($request->id);
        if(!empty($user)){
            $user->update($request->only('comment_allowed'));
        }

        return redirect()->back()->with('success', 'Status updated successfully :)');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User Deleted successfully :)');
        } else {
            // Handle the case where the user with the given ID is not found
            return redirect()->back()->with('error', 'User not found');
        }
    }
}
