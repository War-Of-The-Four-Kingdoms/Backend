<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthenController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    private $client;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('password_client', 1)->first();
    }

    /**
     * @param Request $request
     * @return mixed
     */

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $request->request->add([
                'grant_type' => 'password',
                'username' => $request->email,
                'password' => $request->password,
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'scope' => ''
            ]);

            $proxy = Request::create(
                'api/oauth/token',
                'POST'
            );

            return \Route::dispatch($proxy);
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Invalid email or password.']);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function refreshToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'api/oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }

    public $successStatus = 200;

    public function register(Request $request)
    {
        if(User::where('email', $request->email)->exists()){
            return $this->sendError('Exists', ['error'=>'Email already exists']);
        }
        else{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $data = $request->only('email','name','password','mobile');
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'uuid' => uniqid()
            ]);

            $request->request->add([
                'grant_type'    => 'password',
                'client_id'     => $this->client->id,
                'client_secret' => $this->client->secret,
                'username'      => $data['email'],
                'password'      => $data['password'],
                'scope'         => null,
            ]);

            $token = Request::create(
                'api/oauth/token',
                'POST'
            );
            return \Route::dispatch($token);
        }

    }

    // Personal Access Token

    // public function login(Request $request)
    // {
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('W4K');

    //         $success['name'] =  $user->name;

    //         return $this->sendResponse($success, 'User login successfully.');
    //     }
    //     else{
    //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //     }
    // }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function editUsername(Request $request){
        $user = User::where('uuid',Auth::user()->uuid)->first();
        $user->name = $request->name;
        $user->save();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
