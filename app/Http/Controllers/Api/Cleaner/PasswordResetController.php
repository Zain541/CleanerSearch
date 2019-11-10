<?php
namespace App\Http\Controllers\Api\Cleaner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cleaner;
use Illuminate\Support\Facades\Mail;
use App\PasswordReset;
use Illuminate\Support\Facades\Validator;
class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $cleaner = Cleaner::where('email', $request->email)->first();
        if (!$cleaner)
            return response()->json([
                'message' => 'We can\'t find a cleaner with that e-mail address.'
            ], 404);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $cleaner->email],
            [
                'email' => $cleaner->email,
                'token' => str_random(60)
             ]
        );
          $email_data = array(
             'recipient' => $cleaner->email,
             'subject' => 'Password Reset'
              );
          $data = ['url' =>  url('/api/cleaner/password/find/'.$passwordReset->token)];
        if ($cleaner && $passwordReset)
           Mail::send('emails.passwordreset', $data, function($message) use ($email_data) {
                  $message->to($email_data['recipient'])
                          ->subject($email_data['subject']);
              });
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
       
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        $reset_credentials['email'] = $passwordReset->email;
        $reset_credentials['token'] = $passwordReset->token;
        return view('cleaner.password.reset',compact('reset_credentials'));
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $cleaner = Cleaner::where('email', $passwordReset->email)->first();
        if (!$cleaner)
            return response()->json([
                'message' => 'We can\'t find a cleaner with that e-mail address.'
            ], 404);
        $cleaner->password = bcrypt($request->password);
        $cleaner->save();
        $passwordReset->delete();
        return view('cleaner.password.success');
    }
}