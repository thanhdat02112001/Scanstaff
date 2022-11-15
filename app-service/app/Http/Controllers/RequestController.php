<?php

namespace App\Http\Controllers;

use App\Events\DisableRunButton;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RequestController extends Controller
{
    public function sendPostRequest(Request $request, $language)
    {
        // Disable run button on others
        event (new DisableRunButton($request->id));

        // Get language and function
        $client = new Client();
        switch ($language) {
            case 'PHP':
                $func = 'php';
                break;
            case 'JavaScript':
                $func = 'js';
                break;
            case 'Ruby':
                $func = 'ruby';
                break;
            case 'Java':
                $func = 'java';
                break;
            case 'Python':
                $func = 'python2-7';
                break;
            case 'Python3':
                $func = 'python3';
                break;
            default:
                $func = '';
                break;
        }

        if ($func === '') {
            return 'Not supported';
        }

        // Make JSON string
        $data = [
            'body' => $request->data,
            'sid' => Session::getId()
        ];
        $data = json_encode($data);

        // Send request
        $url = "http://192.168.0.104:8080/function/{$func}";
        try {
            $res = $client->request('POST', $url, [
                'body' => $data,
                'timeout' => 8,
                'connect_timeout' => 5
            ]);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }

        return ($res->getBody());
    }
}
