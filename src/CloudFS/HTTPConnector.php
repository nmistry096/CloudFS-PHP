<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

namespace CloudFS;

use CloudFS\Exception\BitcasaStatus;
use CloudFS\Exception\BitcasaError;


class HTTPConnector {

    private $headers;
    private $user_agent;
    private $http_status;
    private $return_xfer;
    private $session;
    private $response;
    private $error_msg;
    private $error_code;
    private $data;
    private $datalen;
    private $is_raw;
    private $debug;
    public $curl;
    public $boundary;
    public $eof;
    public $postdata;

    /**
     * Initializes the http connect instance.
     *
     * @param Session $session The http session instance.
     */
    public function __construct($session = null) {
        $this->curl = null;
        $this->session = $session;
        $this->headers = array();
        $this->return_xfer = true;
        $this->response = null;
        $this->error_msg = null;
        $this->error_code = 0;
        $this->data = null;
        $this->datalen = 0;
        $this->postdata = null;
        $this->boundary = null;
        $this->eof = false;
        $this->is_raw = false;
        $debug = getenv("BC_DEBUG");
        if ($debug != null) {
            $this->debug = true;
        }
        $this->response_type = "";
    }

    /**
     * Sets the raw flag of the http request.
     */
    public function raw() {
        $this->is_raw = true;
    }

    /**
     * Adds the specified http header to the http request.
     *
     * @param string $h The specified http header.
     * @param string $v The http header value to be added.
     */
    public function addHeader($h, $v) {
        unset($this->headers[$h]);
        $this->headers[$h] = $v;
    }

    /**
     * Adds the specified http header to the http request if it's missing.
     * @param string $h The specified http header.
     * @param string $v The http header value to be added.
     * @return Flag whether the operation was successful.
     */
    public function addMissingHeader($h, $v) {
        if (!isset($this->headers[$h])) {
            $this->headers[$h] = $v;
            return true;
        }
        return false;
    }

    /**
     * Retrieves whether the http request has the specified http header.
     *
     * @param string $h The specified http header.
     * @param string $value The specified http header value.
     * @return The flag as to whether the http request has the specified header.
     */
    public function hasHeader($h, $value = null) {
        if (!isset($this->headers[$h])) {
            return false;
        }
        if ($value != null) {
            return ($this->headers[$h] == $value);
        }
        return true;
    }

    /**
     * Retrieves the header of an http request.
     *
     * @return The header result array.
     */
    public function getHeaders() {
        $result = array();
        foreach ($this->headers as $k => $v) {
            $h = $k . ": " . $v;
            $result[] = $h;
        }
        return $result;
    }

    /**
     * Sets the data and the data length of the http request.
     *
     * @param mixed $data The data to be added to the http request.
     * @param int $len The length of the added data.
     */
    public function setData($data, $len = 0) {
        if ($len == 0) {
            $len = count($data);
        }
        $this->datalen = $len;
        $this->data = $data;
    }

    /**
     * Posts the http request to a given url.
     *
     * @param string $url The url for the http post.
     * @return The posts http status.
     * @throws Exception
     */
    public function post($url) {
        $this->setup();
        if ($this->data != null && $this->datalen > 0) {
            if ($this->debug) {
                print "body=";
                var_dump($this->data);
            }
            assert(curl_setopt($this->curl, CURLOPT_POST, $this->datalen));
            assert(curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data));
        }
        $this->process($url);
        return $this->http_status;
    }

    /**
     * Downloads the file at specified url.
     *
     * @param string $url The url for the resource.
     * @param string $localDestinationPath The path of the local file to download the content.
     * @param mixed $downloadProgressCallback The download progress callback function. This function should take
     * 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
     * @return The response status.
     */
    public function download($url, $localDestinationPath, $downloadProgressCallback) {
        $this->setup();
        $targetFile = fopen($localDestinationPath, 'w');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        if (!empty($downloadProgressCallback)) {
            curl_setopt($this->curl, CURLOPT_NOPROGRESS, false);
            curl_setopt($this->curl, CURLOPT_PROGRESSFUNCTION, $downloadProgressCallback);
        }
        curl_setopt($this->curl, CURLOPT_FILE, $targetFile);

        curl_setopt_array($this->curl, array(CURLOPT_URL => $url,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0));

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($this->curl);
        fclose($targetFile);
        curl_close($this->curl);

        return $response;
    }

    /**
     * Gets the redirect url for the specified url.
     *
     * @param $url The request url.
     * @return The redirect url if exist or an empty string.
     */
    public function getRedirectUrl($url) {
        $this->setup();
        if (!$this->is_raw) {
            $this->addMissingHeader('Accept', 'application/json');
        }
        if ($this->return_xfer) {
            assert(curl_setopt_array($this->curl, array(CURLOPT_RETURNTRANSFER => 1)));
        }
        curl_setopt_array($this->curl, array(CURLOPT_URL => $url,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HEADER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0));

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($this->curl);
        curl_close($this->curl);

        preg_match_all('/^Location:(.*)$/mi', $response, $matches);
        $redirectUrl = '';
        if (!empty($matches[1])) {
            $redirectUrl = trim($matches[1][0]);
        }

        return $redirectUrl;
    }

    /**
     * Posts the http request with multiple parts to a given url.
     *
     * @param string $url The url for the http post.
     * @param string $name The filename to be posted.
     * @param string $path The path of the item to be posted.
     * @param string $exists Specifies action to take if item exists.
     * @param mixed $uploadProgressCallback The upload progress callback function. This function should take
     * 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
     * @return The posts http status.
     * @throws Exception
     */
    public function postMultipart($url, $name, $path, $exists, $uploadProgressCallback = null) {
        $this->is_raw = true;
        $curl_file = curl_file_create($path, 'application/octet-stream', $name);
        $post_data = array(
            "exists" => $exists, 
            'file' => $curl_file);

        $headers = array(
            "Authorization: " . "Bearer " . $this->session->getAccessToken(),
            "Accept: application/json");

        $this->setup();
        assert(curl_setopt($this->curl, CURLOPT_URL, $url));
        assert(curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers));
        assert(curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_data));
        if (!empty($uploadProgressCallback)) {
            curl_setopt($this->curl, CURLOPT_NOPROGRESS, false);
            curl_setopt($this->curl, CURLOPT_PROGRESSFUNCTION, $uploadProgressCallback);
        }

        $this->process($url);
        return $this->http_status;
    }

    /**
     * Carries out a put http request on the given url.
     *
     * @param string $url The url for the http put.
     * @return The put operations http status.
     * @throws Exception
     */
    public function put($url) {
        $this->setup();
        $this->process($url);
        return $this->http_status;
    }

    /**
     * Carries out a get http request on the given url.
     *
     * @param string $url The url for the get request.
     * @return The get operations http status.
     * @throws Exception
     */
    public function get($url) {
        $this->setup();
        $this->process($url);
        return $this->http_status;
    }

    /**
     * Carries out a head http request on the given url.
     *
     * @param string $url The url for the head request.
     * @return The head operations http status.
     * @throws Exception
     */
    public function head($url) {
        $this->setup();
        $this->process($url);
        return $this->http_status;
    }

    /**
     * Carries out a delete http request on the given url.
     *
     * @param string $url The url for the delete operation.
     * @return The delete operations http status.
     * @throws Exception
     */
    public function delete($url) {
        $this->setup();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        $this->process($url);
        return $this->http_status;
    }

    /**
     * Returns the response for the http request.
     *
     * @param bool $json Json received as response.
     * @param bool $check Flag to check the response with bitcasa status.
     * @return The http response.
     * @throws BitcasaError
     */
    public function getResponse($json = false, $check = true) {
        if ($json && strpos($this->response_type, 'application/json') !== false) {
            $res = json_decode($this->response, true);
            if ($check) {
                $b = new BitcasaStatus($res, $this->http_status);
                $b->throwOnFailure();
            }
            return $res;
        }
        return $this->response;
    }

    /**
     * Sets the user agent of the http operation.
     *
     * @param string $agent The user agent.
     */
    public function setUserAgent($agent) {
        $this->user_agent = $agent;
    }

    /**
     * Retrieves the user agent of the http operation.
     *
     * @return The user agent.
     */
    public function getUserAgent() {
        return $this->user_agent;
    }

    /**
     * Validates and processes the http request.
     *
     * @param string $url The url variable for curl operations.
     * @throws \Exception
     */
    private function process($url) {
        //if (substr($url, -1, 1) == "/") {
        //	$url = substr($url, 0, -1);
        //}
        if (!$this->is_raw) {
            $this->addMissingHeader('Accept', 'application/json');
        }
        if ($this->return_xfer) {
            assert(curl_setopt_array($this->curl, array(CURLOPT_RETURNTRANSFER => 1)));
        }
        assert(curl_setopt_array($this->curl, array(CURLOPT_URL => $url,
            CURLINFO_HEADER_OUT => true, //Request header
            CURLOPT_HEADER => true, //Return header
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0)));

        if (!$this->is_raw) {
            $hdrs = $this->getHeaders();
            if ($this->debug) {
                var_dump($hdrs);
                var_dump($url);
            }
            assert(curl_setopt($this->curl, CURLOPT_HTTPHEADER, $hdrs));
        }

        $resp = curl_exec($this->curl);

        $header_info = curl_getinfo($this->curl, CURLINFO_HEADER_OUT);
        $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $header_string = substr($resp, 0, $header_size);
        $body = substr($resp, $header_size);
        $resp = $body;

        $header_string = explode("\r\n", $header_string);
        $headers = array();
        foreach ($header_string as $header) {
            // If the header has a : in it...
            if (strpos($header,':') !== false) {
                // split and store
                $split_header = explode(":", $header);
                $headers[$split_header[0]] = trim($split_header[1]);
            }
        }

        if ($resp != false) {
            $this->response = $resp;
        } else {
            $this->response = null;
        }

        // reset response type
        $this->response_type = "";
        if (array_key_exists("Content-Type", $headers)) {
            $this->response_type = $headers['Content-Type'];
        }

        $this->http_status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        if ($this->debug) {
            var_dump("HTTP status: " . $this->http_status);
        }
        if ($this->http_status < 200 || $this->http_status >= 300) {
            if (strpos($this->response_type, 'application/json') !== false && $resp !== false) {

                # code to handle JSON encoded errors from bitcasa
                $json_res = json_decode($resp, true);
                throw new BitcasaError($json_res, $this->http_status);
            } 

            # code to handle all other errors
            $err = curl_errno($this->curl);
            if ($err == 0) {
                $err = $this->http_status;
            }
            if ($resp == false) {
                $resp = curl_error($this->curl);
            }
            throw new \Exception($this->http_status . ": " . $resp, $err);
        }

        if ($resp == NULL || $resp == false) {
            $this->error_msg = curl_error($this->curl);
            $this->error_code = curl_errno($this->curl);
            if ($this->debug) {
                print "error-msg: ";
                var_dump($this->error_msg);
            }
            throw new \Exception($this->error_msg);
        } else {
            #echo "HTTP Response: \r\n" . $resp . "\r\n";
            $this->response = $resp;
        }

        // Close request to clear up some resources
        curl_close($this->curl);
    }

    /**
     * Setup the http request adding the necessary headers and the access token.
     */
    private function setup() {
        $this->curl = curl_init();
        $this->http_status = 0;
        $token = "Bearer " . $this->session->getAccessToken();
        $this->addMissingHeader("Authorization", $token);
        $this->addMissingHeader("Content-Type", "application/x-www-form-urlencoded; charset=\"utf-8\"");
        if ($this->user_agent != null) {
            curl_setopt($this->curl, CURLOPT_USERAGENT, 'http://testcURL.com');
        }
    }
}

?>
