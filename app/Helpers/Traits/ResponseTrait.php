<?php
namespace App\Helpers\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{
    public function ajaxResponse($result, $data = "")
    {
        if ($result) {
            $return_data = $data;
        } else {
            $return_data = [];
            $return_data['code'] = -1;
            if (is_string($data)) {
                $return_data['message'] = $data;
            } elseif (is_array($data)) {
                switch (count($data)) {
                    case 1:
                        $return_data['message'] = $data;
                        break;
                    case 2:
                        $return_data['code'] = $data[0];
                        $return_data['message'] = $data[1];
                        break;
                }
            }
        }

        return (new Response([
            'result' => !!$result,
            'data' => $return_data
        ]));
    }
}