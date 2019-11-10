<?php

namespace App\Http\Controllers\Api\Auth;

use App\Cleaner;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CleanerResource;


class CleanerAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api_cleaner', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api_cleaner')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cleaner = auth('api_cleaner')->user();
        $cleaner->load(array('specialities'));

        return new CleanerResource($cleaner);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $cleaner = Cleaner::findOrFail(auth('api_cleaner')->user()->id);
        $cleaner->load(array('specialities'));

        return new CleanerResource($cleaner);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api_cleaner')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {

    	// return "haha";
    	$validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:cleaners'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['required', 'string', 'max:50', 'unique:cleaners'],
            'phone' => ['required', 'numeric', 'min:11'],
            ]);



        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $request['password'] = bcrypt($request->password);

        $cleaner = Cleaner::create($request->all());
         $cleaner->load(array('specialities'));
        return new CleanerResource($cleaner);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api_cleaner')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api_cleaner')->factory()->getTTL() * 60
        ]);
    }
}
