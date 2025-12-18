<?php

namespace App\Observers;

use App\Models\LorawanRechargeRequest;
use App\Models\Payment;
use App\Models\Setting;
use App\Traits\HttpHelper;
use App\Traits\SendToLorawan;

class LorawanRechargeObserver
{
    use SendToLorawan;

    /**
     * Handle the LorawanRechargeRequest "created" event.
     */
    public function created(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
        $this->sendRequestToLorawan($lorawanRechargeRequest);
    }

    /**
     * Handle the LorawanRechargeRequest "updated" event.
     */
    public function updated(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
        Payment::findOrFail($lorawanRechargeRequest->payment_id)->update([
            'status' => $lorawanRechargeRequest->error_code === "0" ? "Recharged" : "Failed"
        ]);
    }

    /**
     * Handle the LorawanRechargeRequest "deleted" event.
     */
    public function deleted(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
        //
    }

    /**
     * Handle the LorawanRechargeRequest "restored" event.
     */
    public function restored(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
        //
    }

    /**
     * Handle the LorawanRechargeRequest "force deleted" event.
     */
    public function forceDeleted(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
        //
    }
}
