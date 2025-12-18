<?php

namespace App\Livewire\Payments;

use App\Models\LorawanRechargeRequest;
use App\Models\Payment;
use App\Traits\SendToLorawan;
use Livewire\Component;

class PaymentDetails extends Component
{
    use SendToLorawan;

    public Payment $payment;

    public function mount(Payment $payment): void
    {
        $this->payment = $payment;
    }

    public function resendRechargeRequest(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
       $this->sendRequestToLorawan($lorawanRechargeRequest);
    }

    public function render()
    {
        return view('livewire.payments.payment-details')->title('Payment Details');
    }
}
