<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
//
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        //return User::all();

        $users = User::with('userDetail')->get();
        $collection = collect( $users );
        $users = $collection->map(function ($user) {
            $address = $user->userDetail;
            return [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'address' => $address ? $address->user_address : '',
            ];
        });

        return response()->json($users, 201);
    }

    public function show(User $user)
    {
        //return $user;

        $address = $user->userDetail;

        return response()->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'address' => $address->user_address,
        ], 201);
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        if ( array_key_exists('address', $input) ) {
            $address = $input['address'];
            unset( $input['address'] );

            $user = User::create($input);

            $user_id = $user->id;
            $detail = UserDetail::create(
                [
                    'user_id' => $user_id,
                    'user_address' => $address,
                ]
                
            );

            return response()->json( [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'address' => $detail->user_address
            ] , 201 );

        } else {

            $user = User::create($input);

            return response()->json( [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password
            ] , 201 );
        }
    }

    public function update(Request $request, User $user)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user->update($input);

        $address = $user->userDetail;

        if ( $address && isset( $input['address'] ) ) {
            $address->update([
                'user_address' => $input['address'],
            ]);
        }

        return response()->json( [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'address' => $address ? $address->user_address : '',
        ] , 200 );
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
