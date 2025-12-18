<?php

namespace App\Traits;

use App\Models\LorawanRechargeRequest;
use App\Models\Setting;

trait SendToLorawan
{
    use HttpHelper;

    public function sendRequestToLorawan(LorawanRechargeRequest $lorawanRechargeRequest): void
    {
        $send_to_lorawan = (int) Setting::get('SEND_TO_LORAWAN');
        $api_token = Setting::get('API_TOKEN');

        $data = json_encode([
            'action' => 'zlMeter',
            'method' => 'remotelyTopUp',
            'apiToken' => $api_token,
            'param' => [
                'nbonetNetImei' => $lorawanRechargeRequest->payment->customer->imei,
                'topUpToDeviceAmount' => $lorawanRechargeRequest->topup_to_device_amount,
                'topUpAmount' => $lorawanRechargeRequest->topup_amount
            ]
        ]);

        if ($send_to_lorawan) {

            $response = $this->sendHttpRequest(data: (string) $data);

            if ($response) {
                $lorawanRechargeRequest->update([
                    'error_code' => $response['errcode'],
                    'error_message' => $response['errmsg'],
                    'order_id' => $response['orderId'],
                    'status' => $response['errcode'] === "0" ? "Success" : "Failed"
                ]);
            }
        } else {
            info('Sending requests to Lorawan is disabled');
        }
    }
}
