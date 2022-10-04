<?php

namespace App\View\Components;

use App\Http\Controllers\restaurant\MyRestaurant;
use Illuminate\View\Component;

class MailMessageComponent extends Component
{
    public $mailContent;
    public $headerRestaurant;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mailContent, $headerRestaurant = NULL)
    {
        $this->mailContent = $mailContent;

        if ($headerRestaurant === TRUE)
            $this->headerRestaurant = config('app.url') .'/'. MyRestaurant::avatar();
        else
            $this->headerRestaurant = config('app.url') .'/img/logo/logo-uchuva-lobby-light.svg';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.mail.message')->with([
            'headerRestaurant' => $this->headerRestaurant,
            'slot' => $this->mailContent
        ]);
    }
}
