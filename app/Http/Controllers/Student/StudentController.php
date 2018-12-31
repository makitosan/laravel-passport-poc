<?php

namespace App\Http\Controllers\Student;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Passport\Client;
use Spatie\Permission\Models\Role;

class StudentController extends Controller
{

    /**
     * Create and register a student user and return a token
     * @see https://stackoverflow.com/questions/44172818/registering-user-with-laravel-passport
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    function create(Request $request)
    {
        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->only('username', 'password', 'client_id', 'client_secret'), [
            'username' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->only('username','name','password', 'client_id', 'client_secret');

        $user = User::create([
            'name' => $data['username'],
            'email' => $data['username'],
            'password' => Hash::make($data['password'])
        ]);

        $role = Role::findByName('student', 'api');
        $user->assignRole($role);
        $role = Role::findByName('student', 'web');
        $user->assignRole($role);

        // And created user until here.

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'username'      => $data['username'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);

        // Fire off the internal request.
        $token = Request::create(
            'api/v1/oauth/token',
            'POST'
        );
        return \Route::dispatch($token);
    }

}
