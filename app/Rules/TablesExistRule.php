<?php

namespace App\Rules;

use App\Http\Controllers\support\UserController;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TablesExistRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $parents = $this->parents()[0];
        return Table::where('branch_id', '=', $parents->branch_id)->find($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The table was not found.');
    }

    private function parents()
    {
        switch (UserController::role_auth()) {
            case 'Waiter':
                return Waiter::findOrFail(Auth::user()->id)->select('id', 'restaurant_id', 'branch_id')->get();

            default:
                return null;
        }
    }
}
