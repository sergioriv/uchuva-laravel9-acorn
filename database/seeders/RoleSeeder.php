<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Waiter;
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
        $restaurants  = Permission::create([ 'name' => 'support.restaurants' ]);

        $dashboard  = Permission::create([ 'name' => 'dashboard' ]);

        $user_profile  = Permission::create([ 'name' => 'user.profile' ]);

        $orders_index  = Permission::create([ 'name' => 'orders.index' ]);
        $orders_create  = Permission::create([ 'name' => 'orders.create' ]);
        $orders_show  = Permission::create([ 'name' => 'orders.show' ]);
        $orders_edit  = Permission::create([ 'name' => 'orders.edit' ]);
        $orders_destroy  = Permission::create([ 'name' => 'orders.destroy' ]);

        $branches  = Permission::create([ 'name' => 'branches' ]);
        $waiters  = Permission::create([ 'name' => 'waiters' ]);
        $dishes  = Permission::create([ 'name' => 'dishes' ]);



        $SUPPORT = Role::create([ 'name' => 'SUPPORT' ])->syncPermissions([
            $support_users,
            $support_roles,
            $restaurants,
        ]);

        $restaurant_role = Role::create([ 'name' => 'RESTAURANT' ])->syncPermissions([
            $dashboard,
            $branches,
            $user_profile
        ]);

        $branch_role = Role::create([ 'name' => 'BRANCH' ])->syncPermissions([
            $dashboard,
            $user_profile,
            $waiters,
            $dishes,
            $orders_index,
            $orders_destroy
        ]);

        $waiter_role = Role::create([ 'name' => 'WAITER' ])->syncPermissions([
            $user_profile,
            $orders_index,
            $orders_create,
            $orders_show,
            $orders_edit
        ]);


        /*
         * Creacion user
         */
        User::create([
            'name' => 'support',
            'email' => 'support@mantiztechnology.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($SUPPORT);

        $restaurant_user = User::create([
            'name' => 'restaurante 1',
            'email' => 'res1@example',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($restaurant_role);

        $branch_user = User::create([
            'name' => 'sucursal 1',
            'email' => 'suc1@example',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($branch_role);

        $waiter_user = User::create([
            'name' => 'Camarero 1',
            'email' => 'cam1@example',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($waiter_role);


        /*
         * Creacion Restaurant
         */
        Restaurant::create([
            'id' => $restaurant_user->id,
            'nit' => 'nit9999999',
            'unsubscribe' => now()->addMonth(1),
        ]);


        /*
         * Creacion Restaurant Subscription
         */
        Subscription::create([
            'restaurant_id' => $restaurant_user->id,
            'quantity' => 5,
            'payment_date' => now(),
            'unsubscribe' => now()->addMonth(5)
        ]);


        /*
         * Creacion Branches
         */
        Branch::create([
            'id' => $branch_user->id,
            'restaurant_id' => $restaurant_user->id,
            'code' => Str::upper(Str::random(5)),
            'city' => 'Antioquia - Alejandría',
            'address' => 'suc1-dir',
            'telephone' => 'suc1-tel'
        ]);


        /*
         * Creacion Waiters
         */
        Waiter::create([
            'id' => $waiter_user->id,
            'restaurant_id' => $restaurant_user->id,
            'branch_id' => $branch_user->id,
            'telephone' => 'cam1-tel'
        ]);

    }
}
