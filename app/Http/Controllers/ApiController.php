<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Mpdf\MpdfException;

class ApiController extends BaseController
{


    /**
     * @param $html
     * @param $title_file
     */
    public function makePDF($html, $title_file){
        try {
            $pdf = new \Mpdf\Mpdf();
            $pdf->WriteHTML($html);
            $pdf->Output($title_file.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        } catch (MpdfException $e) {

        }
    }

    /**
     * @param $data
     * @param $from
     * @param $to
     * @param $subject
     * @param $view
     * @return mixed
     */
    public function sendMail($data, $from, $to, $subject, $view) {
        $mail = Mail::send($view, $data, function ($m) use ($data,$from,$to,$subject)  {
            $m->from($from["email"], $from["name"]);
            $m->to($to["email"], $to["name"])->subject($subject);
        });
        return $mail;
    }

    /**
     * @param array $datas
     * @return \Illuminate\Http\JsonResponse
     */
    public function error_responses($datas = [], $message = "Failed"){
        return response()->json([
            "status"=>false,
            "message"=>$message,
            "datas"=>$datas
        ]);
    }

    /**
     * @param array $datas
     * @return \Illuminate\Http\JsonResponse
     */
    public function success_responses($datas = [],$message= 'Success'){
        return response()->json([
            "status"=>true,
            "message"=>$message,
            "datas"=>to_array($datas)
        ]);
    }
}
