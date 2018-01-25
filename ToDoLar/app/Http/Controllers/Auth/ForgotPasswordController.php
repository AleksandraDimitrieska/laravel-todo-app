<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Mail\ChangePassword;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
//use TokenCl;
use Illuminate\Contracts\Auth\CanResetPassword;
class ForgotPasswordController extends Controller 
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getResetToken(Request $request)
    {

        $this->validate($request, ['email' => 'required|email']);
        //if ($request->wantsJson()) {
            $user = User::where('email', $request->input('email'))->first();
          //  if (!$user) {
                //return response()->json(Json::response(null, trans('passwords.user')), 400);
            //}
            $token = $this->broker()->createToken($user);
            //$primer = new TokenCl($token); 
            $email1=$request->email;
            \Mail::to($email1)->send(new ChangePassword($token));
            return response()->json(['token' => $token],201);
    }
}

