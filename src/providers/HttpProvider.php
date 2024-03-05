<?php
namespace Qin\Web3Php\providers;
class HttpProvider{

    // Information and debugging
    public $status;
    public $error;
    public $response;
    private $id = 0;

    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }


    public function __call($method, $params)
    {
        $this->status = null;
        $this->error = null;
        $this->response = null;

        // If no parameters are passed, this will be an empty array
        $params = array_values($params);

        // The ID should be unique for each call
        $this->id++;

        // Build the request, it's ok that params might have any empty array
        $data = json_encode(array(
            'method' => $method,
            'params' => $params,
            'id' => $this->id
        ));

        // Build the cURL session
        $curl = curl_init();
        $headerArray = array("Content-type:application/json;charset='utf-8'", "Accept:application/json");
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Execute the request and decode to an array
        $response = curl_exec($curl);
        $this->response = json_decode($response, true);

        // If the status is not 200, something is wrong
        $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // If there was no error, this will be an empty string
        $curl_error = curl_error($curl);

        curl_close($curl);

        if (!empty($curl_error)) {
            $this->error = $curl_error;
        }


        if (array_key_exists("error", $this->response)) {
            // If bitcoind returned an error, put that in $this->error
            $this->error = $this->response['error']['message'];
        } elseif ($this->status != 200) {
            // If bitcoind didn't return a nice error message, we need to make our own
            switch ($this->status) {
                case 400:
                    $this->error = 'HTTP_BAD_REQUEST';
                    break;
                case 401:
                    $this->error = 'HTTP_UNAUTHORIZED';
                    break;
                case 403:
                    $this->error = 'HTTP_FORBIDDEN';
                    break;
                case 404:
                    $this->error = 'HTTP_NOT_FOUND';
                    break;
            }
        }

        if ($this->error) {
            return false;
        }

        return $this->response['result'];
    }
}