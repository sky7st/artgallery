<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    public function showRegistrationForm()
    {

        $roles = Permission::whereName('can be registered')->first()->roles;

        return view('auth.register', [
            'regRoles' => $roles
        ]);

    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/artist';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validArr = [];
        $roles = Permission::whereName('can be registered')->first()->roles;
        foreach($roles as $role){
            array_push($validArr, $role->id);
        }
        $valid = "in:".join(",", $validArr);
        return Validator::make($data, [
            'role' => ['required', 'integer', $valid],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ssn' => [
                'required', 
                'string', 
                'unique:artist,artist_ssn',
                'unique:customer,customer_ssn',
                'unique:saler,saler_ssn',
                'unique:admin,admin_ssn',
            ],
            'phone' => ['required', 'string'],
            'add' => ['required', 'string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $role = Role::where('id', $data['role'])->first();
        $user->roles()
            ->attach($role);
        switch ($role->name) {
            case 'artist':
                $artist = [
                    'artist_ssn '=> $data['ssn'],
                    'artist_email' => $data['email'],
                    'name' => $data['name'],
                    'address' => $data['add'],
                    'phone' => $data['phone'],
                    'usual_type' => $data['utype'],
                    'usual_medium' => $data['umedium'],
                    'usual_style' => $data['ustyle']
                ];
                $user->artist()->create($artist);
                break;
            case 'customer':
                $customer = [
                    'customer_ssn '=> $data['ssn'],
                    'customer_email' => $data['email'],
                    'name' => $data['name'],
                    'address' => $data['add'],
                    'phone' => $data['phone']
                ];
                $user->customer()->create($customer);
            default:
                # code...
                break;
        }
        
        return $user;
    }
}
