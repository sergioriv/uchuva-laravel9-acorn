<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $support_users  = Permission::create([ 'name' => 'support.users' ]);
        $support_roles  = Permission::create([ 'name' => 'support.roles' ]);
        $restaurantes  = Permission::create([ 'name' => 'restaurantes' ]);

        $dashboard  = Permission::create([ 'name' => 'dashboard' ]);

        $comandas_index  = Permission::create([ 'name' => 'comandas.index' ]);
        $comandas_create  = Permission::create([ 'name' => 'comandas.create' ]);
        $comandas_show  = Permission::create([ 'name' => 'comandas.show' ]);
        $comandas_edit  = Permission::create([ 'name' => 'comandas.edit' ]);
        $comandas_destroy  = Permission::create([ 'name' => 'comandas.destroy' ]);

        $sucursales  = Permission::create([ 'name' => 'sucursales' ]);
        $meseros  = Permission::create([ 'name' => 'meseros' ]);
        $platos  = Permission::create([ 'name' => 'platos' ]);



        $SUPPORT = Role::create([ 'name' => 'SUPPORT' ])->syncPermissions([
            $support_users,
            $support_roles,
            $restaurantes,
        ]);

        $restaurant = Role::create([ 'name' => 'RESTAURANT' ])->syncPermissions([
            $dashboard,
            $sucursales
        ]);

        Role::create([ 'name' => 'BRANCH' ])->syncPermissions([
            $dashboard,
            $meseros,
            $platos,
            $comandas_index,
            $comandas_destroy
        ]);

        Role::create([ 'name' => 'WAITER' ])->syncPermissions([
            $comandas_index,
            $comandas_create,
            $comandas_show,
            $comandas_edit
        ]);

        User::create([
            'name' => 'support',
            'email' => 'support@mantiztechnology.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($SUPPORT);

        /*
         * Creacion user
         */
        $user = User::create([
            'name' => 'restaurante 1',
            'email' => 'res1@example',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($restaurant);

        Restaurant::create([
            'user_id' => $user->id,
            'unsubscribe' => now()->addMonth(1),
        ]);

    }
}
