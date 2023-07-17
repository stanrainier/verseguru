<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\View
     */
    public function showResetForm(Request $request, $token = null, $email = null)
    {
        return view('auth.passwords.reset', compact('token', 'email'));
    }

    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */    
    public function reset(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
    
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
                event(new PasswordReset($user)); // Fire the PasswordReset event
            }
        );
    
        if ($response == Password::PASSWORD_RESET) {
            $this->resetUserPassword($request->email, $request->password); // Update the user's password
            return redirect()->route('login')->with('status', trans($response));
        } else {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the user's password in the user table.
     *
     * @param  string  $email
     * @param  string  $password
     * @return void
     */
    private function resetUserPassword($email, $password)
    {
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();
    }
}
