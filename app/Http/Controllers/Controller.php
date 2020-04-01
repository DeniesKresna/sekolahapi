<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Mpdf\MpdfException;

class Controller extends BaseController
{
    const STATUS_NEW = "new";
    const PROCESSED = "process";
    const STATUS_REJECT = "reject";
    const STATUS_ACCEPT = "accept";
    const STATUS_FINISH = "finish";
    const PERPAGE = 8;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function upload($path, $photo, $title=""){
        $destinationPath = base_upload_dir().$path;
        $photoName = time().(!empty($title)?"_".$title:"").'.'.$photo->getClientOriginalExtension();
        $photo->move($destinationPath, $photoName);
        return $path.$photoName;
    }

    public function makePDF($html, $title_file){
        try {
            $pdf = new \Mpdf\Mpdf();
            $pdf->WriteHTML($html);
            $pdf->Output($title_file.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        } catch (MpdfException $e) {

        }
    }

    public function sendMail($data, $from, $to, $subject, $view) {
        $mail = Mail::send($view, $data, function ($m) use ($data,$from,$to,$subject)  {
            $m->from($from["email"], $from["name"]);
            $m->to($to["email"], $to["name"])->subject($subject);
        });
        return $mail;
    }
}
