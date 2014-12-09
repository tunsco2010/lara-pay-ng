<?php


namespace Dammyammy\LaraPayNG\Gateways\VoguePay;

use Dammyammy\LaraPayNG\PaymentGateway;
use Dammyammy\LaraPayNG\Support\Helpers;
use GuzzleHttp\Client;

class VoguePay extends Helpers implements PaymentGateway {

    /**
     * Define Gateway name
     */
    const GATEWAY = 'VoguePay';


    public function processTransaction($transactionData)
    {

//        https://ibank.gtbank.com/GTPayService/gettransactionstatus.json?mertid=212&amount=200000&tranxid=PLM_1394115494_11180&hash=F48289B1C72218C6C02884C26438FA070864B624D1FD82C90F858AF268B2B82F7A3D2311400B29E9B3731068B89EB8007F36B642838C821CAB47D2AAFB5FA0EF
        $client = new Client(['base_url' => 'https://ibank.gtbank.com']);

        $response = $client->get('/GTPayService/gettransactionstatus.json', [
            'query'     =>  [
                                'mertid'  => $this->app['config']['services.payment.gtpay.mert_id'],
                                'amount'  => $transactionData['amount'],
                                'tranxid' => $transactionData['id'],
                                'hash'    => $this->helper->generateVerificationHash($transactionData['id'])

                            ],
            'headers'   =>  ['Accept' => 'application/json' ]
        ]);

        dd($response->json());

//        #It is assumed that you have put the URL to this file in the notification url (notify_url)
//##of the form you submitted to voguepay.
//##VoguePay Submits transaction id to this file as $_POST['transaction_id']
//        /*--------------Begin Processing-----------------*/
//##Check if transaction ID has been submitted
//
//        if(isset($_POST['transaction_id'])){
//            //get the full transaction details as an json from voguepay
//            $json = file_get_contents('https://voguepay.com/?v_transaction_id='.$_POST['transaction_id'].'&type=json');
//            //create new array to store our transaction detail
//            $transaction = json_decode($json, true);
//
//            /*
//            Now we have the following keys in our $transaction array
//            $transaction['merchant_id'],
//            $transaction['transaction_id'],
//            $transaction['email'],
//            $transaction['total'],
//            $transaction['merchant_ref'],
//            $transaction['memo'],
//            $transaction['status'],
//            $transaction['date'],
//            $transaction['referrer'],
//            $transaction['method']
//            */
//
//            if($transaction['total'] == 0)die('Invalid total');
//            if($transaction['status'] != 'Approved')die('Failed transaction');
//
//            /*You can do anything you want now with the transaction details or the merchant reference.
//            You should query your database with the merchant reference and fetch the records you saved for this transaction.
//            Then you should compare the $transaction['total'] with the total from your database.*/
//        }

        // Save Response to DB (Keep Transaction Detail)
        // Determine If the Transaction Failed Or Succeeded & Redirect As Appropriate
            // If Success, Notify User Via Email Of their Order
            // Notify Admin Of New Order



        //        . $transactionData['verificatioHash']



//        {"Amount":"2600","MerchantReference":"FBN|WEB|UKV|19-12-2013|037312","MertID":"17","ResponseCode":"00","ResponseDescription":"Approved by Financial Institution"}
    }

    /**
     * Log Transaction
     *
     * @param $transactionData
     *
     * @return
     */
    public function logTransaction($transactionData)
    {
        // TODO: Implement logTransaction() method.
    }

    /**
     * Generate invoice return for Transaction
     *
     * @param $transactionData
     *
     * @return
     */
    public function generateInvoice($transactionData)
    {
        // TODO: Implement generateInvoice() method.
    }

}