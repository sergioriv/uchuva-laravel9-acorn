<?php

namespace App\Http\Controllers\support;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\SmtpMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
Use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:support.access');
    }

    public function index()
    {
        return view('support.users.index');
    }

    public function data()
    {
        return ['data' => User::with('roles')->orderBy('created_at','DESC')->get()];
    }

    public static function _create($name, $email, $role)
    {

        /* tratamiento para el username */
        $name = static::_username($name);

        if (NULL != $email)
        {
            /* convertir email in lower */
            $email = Str::lower($email);
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
        ])->assignRole($role);

        $sendmail = SmtpMail::sendEmailVerificationNotification($user);

        /* si el mail de verificación rebota, el usuario es eliminado
         * se retorna false para la creación del usuario
         * */
        if (!$sendmail) {
            $user->delete();
            return false;
        }

        // $user->sendEmailVerificationNotification();

        event(new Registered($user));

        return $user;
    }

    public function show(User $user)
    {
        return redirect()->route('support.users.edit', $user);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('support.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'role' => 'required'
        ]);

        $user->roles()->sync($request->role);

        return redirect()->route('support.users.index')->with([
            'notify' => 'success',
            'title' => 'Updated user!',
        ]);
    }

    public static function _update($user_id, $name, $email)
    {
        $user = User::findOrFail($user_id);

        /* tratamiento para el username */
        $name = static::_username($name);


        $user->update([
            'name' => $name,
        ]);

        if($email != null){

            /* convertir email in lower */
            $email = Str::lower($email);
            $user->update([
                'email' => $email,
            ]);
        }

    }

    public static function upload_avatar(Request $request, User $user)
    {
        $path = static::save_avatar($request);

        if ($request->hasFile('avatar'))
            File::delete(public_path($user->avatar));

        $user->update([
            'avatar' => $path
        ]);
    }

    private static function save_avatar($request)
    {
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatar', 'public');
            return config('filesystems.disks.public.url') . '/' . $path;
        } else return null;
    }

    public static function role_auth()
    {
        return User::find(Auth::user()->id)->getRoleNames()[0];
    }



    /* Tratamiento de datos */
    private static function _username($name)
    {
        $name = Str::limit($name, 15, null);
        $name = Str::words($name, 2, null);
        return $name;
    }


}
