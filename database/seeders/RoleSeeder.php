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
        $support_access  = Permission::create([ 'name' => 'support.access' ]);
        $restaurants  = Permission::create([ 'name' => 'support.restaurants' ]);

        $user_profile  = Permission::create([ 'name' => 'user.profile' ]);

        $orders_index  = Permission::create([ 'name' => 'orders.index' ]);
        $orders_create  = Permission::create([ 'name' => 'orders.create' ]);
        $orders_show  = Permission::create([ 'name' => 'orders.show' ]);
        $orders_edit  = Permission::create([ 'name' => 'orders.edit' ]);
        $orders_destroy  = Permission::create([ 'name' => 'orders.destroy' ]);

        $waiters  = Permission::create([ 'name' => 'waiters' ]);
        $dishes  = Permission::create([ 'name' => 'dishes' ]);
        $categories  = Permission::create([ 'name' => 'categories' ]);
        $tables  = Permission::create([ 'name' => 'tables' ]);



        $SUPPORT = Role::create([ 'name' => 'SUPPORT' ])->syncPermissions([
            $support_access,
            $restaurants,
        ]);

        $restaurant_role = Role::create([ 'name' => 'RESTAURANT' ])->syncPermissions([
            $user_profile,
            $categories,
            $waiters,
            $dishes,
            $tables,
            $orders_index,
            $orders_create,
            $orders_show,
            $orders_edit,
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
            'name' => 'admin',
            'email' => 'admin@mojatechnology.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($SUPPORT);

        $restaurant_user = User::create([
            'name' => 'restaurante 1',
            'email' => 'res1@moja',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($restaurant_role);

        $waiter_user = User::create([
            'name' => 'Camarero 1',
            'email' => 'cam1@moja',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->syncRoles($waiter_role);


        /*
         * Creacion Restaurant
         */
        $restaurant_name = 'Restaurante 1';
        $RESTAURANT = Restaurant::create([
            'user_id' => $restaurant_user->id,
            'name' => $restaurant_name,
            'slug' => Str::slug($restaurant_name),
            'nit' => 'nit9999999',
            'unsubscribe' => now()->addMonth(1),
        ]);


        /*
         * Creacion Restaurant Subscription
         */
        Subscription::create([
            'restaurant_id' => $RESTAURANT->id,
            'quantity' => 5,
            'payment_date' => now(),
            'unsubscribe' => now()->addMonth(1)
        ]);


        /*
         * Creacion Waiters
         */
        Waiter::create([
            'user_id' => $waiter_user->id,
            'restaurant_id' => $RESTAURANT->id,
            'name' => 'Camarero 1',
            'telephone' => 'cam1-tel'
        ]);

    }
}
