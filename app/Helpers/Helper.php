<?php

define("STATUS_FINISHED", "finish");
define("STATUS_CANCELED", "cancel");
define("STATUS_NEW", "new");

/**
 * @return string
 */
function upload_dir(){
    return asset('public/gallery/');
}

/**
 * @return string
 */
function default_image_upload(){
    return "default-photo.jpg";
}

/**
 * @return string
 */
function default_image_url(){
    return upload_dir().default_image_upload();
}

/**
 * @return string
 */
function base_upload_dir(){
    return public_path('gallery/');
}

/**
 * @param $path
 * @param $photo
 * @param string $title
 * @return string
 */
function upload($path, $photo, $title=""){
    $destinationPath = base_upload_dir().$path;
    $photoName = time().(!empty($title)?"_".$title:"").'.'.$photo->getClientOriginalExtension();
    $photo->move($destinationPath, $photoName);
    return $path.$photoName;
}

function file_extension($url){
    $arr = explode(".",$url);
    return end($arr);
}

function file_type($ext){
    $videos = ["mp4","m4a","m4v","f4v","f4a","m4b","m4r","f4b","mov","3gp","3gp2","3g2","3gpp","3gpp2","ogg","oga","ogv","ogx","wmv","wma","asf","webm","flv","avi","hdv","OP1a","OP-Atom","ts","wav","lxf","vob"];
    $images = ['gif', 'jpg', 'jpeg', 'png'];
    if (in_array($ext,$images)) return "image";
    if (in_array($ext,$videos)) return "video";
    else return false;

}

/**
 * @param $type
 * @param $str
 * @return string
 */
function print_status($type, $str)
{
    $in_array = ['warning','success','danger','primary','info'];
    if (in_array($type,$in_array)) return ($str != "" ? "<div class='alert alert-".$type."'>".$str."</div>" : "");
    else return ($str != "" ? "<div class='alert alert-danger'>Type alert not found</div>" : "");
}

/**
 * @param $string
 * @return null|string|string[]
 */
function detect_newline($string){
    return preg_replace("/[\r\n][\r\n]/","<br/>",$string);
}

/**
 * @param $request_datas
 * @param $in_array
 * @return bool
 */
function require_params($request_datas, $in_array){
    foreach ($request_datas as $key => $value){
        if (in_array($key, $in_array) && !empty($value))
            if (($key = array_search($key,$in_array)) !== false)
                unset($in_array[$key]);
    }
    if (empty(sizeof($in_array))) return true;
    else return false;

}

/**
 * @param $status
 * @param $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function send_response($status, $message, $data = []){
    if ($status) return response()->json(["status"=>$status, "message"=>$message, "data"=>$data]);
    else  return response()->json(["status"=>$status, "message"=>$message]);
}

/**
 * @param $request_datas
 * @param $in_array
 * @return array
 */
function exclude_array($request_datas = [], $in_array = []){
    $arr = [];
    foreach ($request_datas as $key => $value){
        if (in_array($key, $in_array) && !empty($value)) $arr[$key] = $value;
    }
    return $arr;
}

/**
 * @param $arr
 * @return mixed
 */
function to_object($arr){
    return json_decode(json_encode($arr));
}

/**
 * @param $arr
 * @return mixed
 */
function to_array($arr){
    return json_decode(json_encode($arr),true);
}

/**
 * @param $password
 * @return string
 */
function password_encrypt($password){
    return md5(md5($password));
}

/**
 * @return string
 */
function print_flashdata(){
    if (Session::has('danger'))
        return "<div class=\"alert alert-danger\">".Session::get('danger')."</div>";
    elseif (Session::has('warning'))
        return "<div class=\"alert alert-warning\">".Session::get('warning')."</div>";
    elseif (Session::has('success'))
        return "<div class=\"alert alert-success\">".Session::get('success')."</div>";
    elseif (Session::has('info'))
        return "<div class=\"alert alert-info\">".Session::get('info')."</div>";
}