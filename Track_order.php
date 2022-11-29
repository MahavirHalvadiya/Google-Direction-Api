<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
class Track_order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function socket_data_send_to_emit(){
        $socket = array();
        
        $socket_data = array(
            'lat' => '24.054158',
            'lng' => '77.256398',
        );
        $socket[] = array(
            'socket_name' => 'track_live_location',
            'socket_data' => $socket_data,
        );              
        /************socket************/
        $headers = array(
            'auth_key: PRO_TMP_key',
            'Content-Type: application/json'
        );

        $url = base_url().'Socket/socket_io_data_send';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($socket));
        $result = curl_exec($ch);
        $result_decode = json_decode($result);
        return true;
    }
}
