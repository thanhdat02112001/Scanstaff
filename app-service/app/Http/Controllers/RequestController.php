<?php

namespace App\Http\Controllers;

use App\Events\DisableRunButton;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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

    public function sendPushNoti(Request $request, $id)
    {
        $http_client = new Client();

        $server_key = config('env.FCM_SERVER_KEY');
        $host = config('env.APP_URL');

        $headers = array(
            "Content-Type" => "application/json",
            "Authorization" => "key={$server_key}"
        );

        $name = $request->name;
        $message = $request->message;

        $tokens = array();
        // get tokens of user in redis
        $redis = Redis::connection();
        $participants = $redis->lrange("pad-{$id}-participants", 0, -1);
        foreach ($participants as $participant) {
            $user = json_decode($participant);
            if (isset($user->token) && $user->token) {
                array_push($tokens, $user->token);
            }
        }

        $body = array(
            "data" => array(
                "title" => config('env.NOTI_TITLE'),
                "body" => "Ứng viên {$name}\n{$message}",
                "url" => "{$host}/pad/{$id}",
            ),
            "registration_ids" => $tokens
        );

        $response = $http_client->request(
            'POST',
            'https://fcm.googleapis.com/fcm/send',
            array(
                'headers' => $headers,
                'body' => json_encode($body)
            )
        );

        echo ($response->getBody());
    }
}
