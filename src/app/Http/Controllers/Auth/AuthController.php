<?php

namespace PCI\Http\Controllers\Auth;

use Validator;
use PCI\Models\User;
use PCI\Events\NewUserRegistration;
use PCI\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * el campo en la tabla usuario que es el seudonimo
     * (overwrites email como default)
     *
     * @var string
     */
    protected $username = 'name';

    /**
     * AuthenticatesAndRegistersUsers
     * @redirectPath()
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * path de redireccionamiento cuando
     * autenticacion falla en postLogin y otros.
     *
     * @var string
     */
    protected $loginPath = 'sesion/iniciar';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
//        $user = User::create([
//            'name'     => $data['name'],
//            'email'    => $data['email'],
//            'password' => bcrypt($data['password']),
//            'status'   => true,
//        ]);

        $user = factory(User::class)->make();

        event(new NewUserRegistration($user));

        return $user;
    }
}
