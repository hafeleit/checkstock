<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'terms' => 'required'
        ]);
        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/dashboard');
    }

    public function itservice_rating(Request $request){

      $data = [];
      $data['task_id'] = $request->task_id ?? '';
      //get task detail
      $res = $this->get_task($data['task_id']);

      $task_name = $res->name ?? '';
      if($task_name != ''){
        $task_assign_id = $res->assignees[0]->id ?? '';

        $data['task_name'] = $task_name;
        $data['task_assign_id'] = $task_assign_id;

        return view('auth.itservice_rating',[ 'data' => $data ]);

      }else{
        abort(404);
      }

    }

    public function save_itservice_rating(Request $request){

      if($request->task_id != ''){

        $task_id = $request->task_id;
        $rating = $request->rating ?? 5;
        $comment_text = $request->comment_text . ' \n(rating by user: '.$rating.')' ?? 'API TEST';
        $task_assign_id = $request->task_assign_id ?? '';

        $field_id = '9c2dd406-7d3f-4843-88ae-666064ab480a'; //rating field id (get by Get Accessible Custom Fields api)
        $this->set_custom_field($task_id, $field_id, $rating);

        $field_id = 'ed3c67b5-d5c4-4568-bbb2-92ec1b73911e'; //rating field id (get by Get Accessible Custom Fields api)
        $this->set_custom_field($task_id, $field_id, $comment_text);

        $this->create_task_comment($task_id, $comment_text, $task_assign_id);

        return view('auth.itservice_thank');

      }else{

        return response()->json([
          'status' => false,
          'errors' => 'Not found Task ID',
        ]);

      }


    }

    //api click up

    public function set_custom_field($task_id, $field_id, $value){

      $httpcode = 0;
      $url = 'https://api.clickup.com/api/v2/task/' . $task_id . '/field/' . $field_id;
      //dd($value);
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        	"value": "'.$value.'"
        }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer 54895392_796cd8bdeaa5e959f83d5e3b552bd32648acbaf191b5e8bffb7a2ba9ff9e0c93'
        ),
      ));

      $response = curl_exec($curl);
      $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      //echo $response;
      //dd($response);
      return $httpcode;

    }

    public function create_task_comment($task_id, $comment_text, $assign_id){

      $url = 'https://api.clickup.com/api/v2/task/'. $task_id .'/comment';
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "comment_text": "'.$comment_text.'",
        "assignee": "'.$assign_id.'",
        "notify_all": true
      }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer 54895392_796cd8bdeaa5e959f83d5e3b552bd32648acbaf191b5e8bffb7a2ba9ff9e0c93'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

    }

    public function get_task($task_id){

      $url = 'https://api.clickup.com/api/v2/task/' . $task_id;
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer 54895392_796cd8bdeaa5e959f83d5e3b552bd32648acbaf191b5e8bffb7a2ba9ff9e0c93'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      $response = json_decode($response);
      return $response;

    }
}
