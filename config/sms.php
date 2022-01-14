<?php
/**
 * ---------------------------------------
 * This are the sms gateway api endpoints
 * and keys to be used.
 * ---------------------------------------
 */
return [
    // auth keys to be used
    'keys' => [
        'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjU2ZWM5MTJlNTA4Y2JlMzQwNGYwZjNiZmZiNTAzMjk5ZmNkYmIwMzhlZDlhNjU2Y2IyYjAzMWVhYmI1NzAyZmZiOWViODFjYjM5MjdlZjYiLCJpYXQiOjE1OTI4MTY3MTcsIm5iZiI6MTU5MjgxNjcxNywiZXhwIjoxNjI0MzUyNzE3LCJzdWIiOiI1OSIsInNjb3BlcyI6W119.XrMeTrUQdw4akkobjZ90RWqISnFBFtBwhgWG4cPS07MpQ5VVex0P5vGQoQdlQnMrP02clAEP9ml4XUNo2erTnm0I69ZG3mljlghxvRR6n_QDyaCtjjEkHZwRAIwtpkJT0Xfedf5ki7MeKtxhC9xvSpInYCIi1ArXGjYHxoYqSdBhbaU7GS7pPDKwIUbdXQb0fsn8gGoZa2Wek26onpY2MbaBxiPmhGPLcwL7yZvrlWxsoCeWLDokKdt_USOIhr-2WnJ-_7EhEowEkbxnvUhCYB-4PD2fmDlPkPzV65Jr4uHsEpRqZR97gsn2lL-PVFW9n5X5OoLOBvV-XeOCi0L1UdIIgPGE7W1pRTBhWkZnJbWWDbKYHqWaJUYq2g9bBEE3yWJyV8d97MbH_azgaQfLK53XPCX8v3SS06mjYGk91LcTe61CFuBoTgt3W-oY2WGDpnAzf6-KnrhW1UvFHzkj-Z452jJg86vu7RoJNbvGC7mHXnp_hLN01YjKZ6IjY4V3yN5rxMPHiYB3CebfFKf_GPz94K9Gb2z5DwXTOMOFuIn3_qscqJVDrp7OU98ppF2VrMF5E3NyeOfbqZQeLTxfb8ZaZ2BkLgHDcOxw7wwXXeom7jqlHS4rDryp7jP81230TOkvkSvpH98bCUhQ5bLnxZRMwaNOpwz7jhIRa8yhG0I',
        'sender' => 'SHIFTECH'
    ],

    // This are the endpoint urls
    'url' => [
        'endpoint' => 'https://bulk.bongatech.co.ke/api/v1/',
        'account-balance' => config('sms.url.endpoint') . 'account/balance', // GET
        'account-top-up' => config('sms.url.endpoint') . 'account/top-up', // POST
        'send-sms' => config('sms.url.endpoint') . 'send-sms', // POST
        'whatsapp-send-message' => config('sms.url.endpoint') . 'whatsapp/send-message', // POST
    ],

    /**
     * ---------------------------------------------------------------------------------------------------
     * The timeout is the time given for the response to be given if no response is given
     * in 120 seconds the request is dropped.
     * You are free to set your timeout
     * ---------------------------------------------------------------------------------------------------
     */
    'timeout' => env('TIMEOUT', 120), // Response timeout 120sec

    /**
     * ---------------------------------------------------------------------------------------------------
     * The connection timeout is the time given for the request to acquire full connection to the
     * end point url. So if not connection is made in 60 seconds the request is dropped.
     * Your free to set your own connection timeout.
     * ---------------------------------------------------------------------------------------------------
     */
    'connect_timeout' => env('CONNECTION_TIMEOUT', 60), // Connection timeout 60sec
];
