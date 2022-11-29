<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

header('Access-Control-Allow-Origin: *');
class Socket extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function socket_io_data_send(){
        $host = $_SERVER['HTTP_HOST'];
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$host:5000";
        //echo $actual_link;exit;
        $request_data = json_decode(file_get_contents("php://input"), true);
        
        foreach ($request_data as $key => $request) {
            $socket_name = $request['socket_name'];
            $socket_data = $request['socket_data'];
            $client = new Client(new Version2X($actual_link));
            
            $client->initialize();
            // send message to connected clients
            
            $client->emit($socket_name, $socket_data);
            $client->close();
        }    
        
        $result_array = array();
        $this->data['status'] = API_SUCCESS;
        $this->data['msg'] = 'Notification sended';
        $this->data['result'] = $result_array;
        echo json_encode($this->data);
        die();
    }
}
