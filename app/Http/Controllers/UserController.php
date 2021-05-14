<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
    *  index
    *
    *  This function is returning users' data as a certanly formatted JSON
    *
    *  @type    function
    *  @date    11/05/2021
    *
    *  @param   void
    *  @return  string
    */
    public function index()
    {
        $users = User::with('userDetail')->paginate(10);

        return response()->json($users, 200);
    }

    /**
    *  show
    *
    *  This function will show a user's data
    *
    *  @type    function
    *  @date    11/05/2021
    *
    *  @param User
    *  @return  string
    */
    public function show(User $user)
    {

        return response()->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
                'address' => $user->userDetail->user_address,
        ], 201);
    }

    /**
     *  store
     *
     *  This function will add a new user in the Database
     *
     * @date    11/05/2021
     *
     * @param UserRequest $request
     *
     * @return  string
     */
    public function store(UserRequest $request)
    {

        $input = $request->validated();

        $user = User::create($input);

        if ( ! $input->input('address') ) {
            return response()->json( [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password
            ] , 201 );
        }

        $user_id = $user->id;
        $detail = UserDetail::create(
            [
                'user_id' => $user_id,
                'user_address' => $input->input('address'),
            ]
        );

        return response()->json( [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => $user->password,
            'address' => $detail->user_address
        ] , 201 );

    }

    /**
     *  update
     *
     *  This function will update the information related to a certain user
     *
     * @date    11/05/2021
     *
     * @param UserRequest $request
     * @param User $user
     *
     * @return  string
     */
    public function update(UserRequest $request, User $user)
    {

        $input = $request->validated();

        $user->update($input);

        if ( ! $input->input('address') ) {
            return response()->json( [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'password' => $user->password,
            ] , 200 );
        }

        $user->userDetail->update([
            'user_address' => $input['address'],
        ]);

        return response()->json( [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => $user->password,
            'address' => $user->userDetail->user_address,
        ] , 200 );

    }

    /**
     *  update
     *
     *  This function will update the information related to a certain user
     *
     *  @type    function
     *  @date    11/05/2021
     *
     *  @param   User
     *  @return  string
     */
    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
