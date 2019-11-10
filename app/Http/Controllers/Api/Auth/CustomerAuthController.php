<?php

namespace App\Http\Controllers\Api\Auth;

use App\Customer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api_customer', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api_customer')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return new CustomerResource(auth('api_customer')->user());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api_customer')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api_customer')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'max:50'],
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $request['password'] = bcrypt($request->password);

        $customer = Customer::create($request->all());

        // $token = auth('api_customer')->login($customer);
        // return $this->respondWithToken($token);


        return new CustomerResource($customer);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api_customer')->refresh());
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
            'expires_in' => auth('api_customer')->factory()->getTTL() * 60
        ]);
    }
}
