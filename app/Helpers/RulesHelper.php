<?php
if (! function_exists('rules_lists')) {
    function rules_lists($controller, $method="any", $custom_var = [])
    {
        $path = explode('\\', $controller);
        $controller = array_pop($path);

        //================================Device Line=======================
        if($controller == "DeviceLineController"){
            if($method=="store"){
                return [
                    'car_id' => [new \App\Rules\isUnique("device_lines","car_id"), new \App\Rules\isExists("cars","id")],
                    'driver_id' => [new \App\Rules\isUnique("device_lines","driver_id"), new \App\Rules\isExists("drivers","id")],
                    'box_id' => [new \App\Rules\isUnique("device_lines","box_id"), new \App\Rules\isExists("boxes","id")],
                    'device_id' => [new \App\Rules\isUnique("device_lines","device_id"), new \App\Rules\isExists("devices","id")],
                    "device_type_id"=>[new \App\Rules\isExists("device_types","id")],
                    'device_type' => ['in:led,screen'],
                ];
            } elseif($method=="update"){
                return [
                    'car_id' => [new \App\Rules\isUnique("device_lines","car_id",["id"=>$custom_var["id"]]), new \App\Rules\isExists("cars","id")],
                    'driver_id' => [new \App\Rules\isUnique("device_lines","driver_id",["id"=>$custom_var["id"]]), new \App\Rules\isExists("drivers","id")],
                    'box_id' => [new \App\Rules\isUnique("device_lines","box_id",["id"=>$custom_var["id"]]), new \App\Rules\isExists("boxes","id")],
                    'device_id' => [new \App\Rules\isUnique("device_lines","device_id",["id"=>$custom_var["id"]]), new \App\Rules\isExists("devices","id")],
                    "device_type_id"=>[new \App\Rules\isExists("device_types","id")],
                    'device_type' => ['in:led,screen'],
                ];
            }

        }

        //================================Campaign Playlist=======================
        if($controller == "PlaylistController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200',
                    'description' => 'required|max:500',
                    'file_ids' => 'required'
                ];
            }
            else {
                return [
                    'name' => 'required|max:200',
                    'description' => 'required|max:500',
                ];
            }

        }
        //================================Campaign ==============================
        else if($controller == "CampaignController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200',
                    'start_date' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:today',
                    'end_date'=> 'required|date|date_format:Y-m-d H:i:s|after_or_equal:start_date',
                    'slots'=> 'required|numeric|min:1'
                ];
            }
            else {
                return [
                    'name' => 'required|max:200'
                ];
            }
        }

        //================================Campaign File ============================
        else if($controller == "ContentController"){
            if($method=="store"){
                return [
                    'file_name' => 'required|max:200',
                    'file_description' => 'required|max:500',
                ];
            }
            else{
                return [
                    'file_name' => 'required|max:200',
                    'file_description' => 'required|max:500',
                ];
            }
        }

        //================================Device =================================
        else if($controller == "DeviceController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200',
                    'imei' => 'required|max:200|unique:devices,imei'
                ];
            }
        }

        //================================Box =================================
        else if($controller == "BoxController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200|unique:boxes,name',
                ];
            }
        }

        //================================Car =================================
        else if($controller == "CarController"){
            if($method=="store"){
                return [
                    'plate_number' => 'required|max:200|unique:cars,plate_number',
                ];
            }
        }

        //================================Driver =================================
        else if($controller == "DriverController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200',
                ];
            }
        }

        //================================Location =================================
        else if($controller == "LocationController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200',
                ];
            }
            else{
                return [
                    'name' => 'required|max:200',
                ];
            }
        }

        //================================Layout =================================
        else if($controller == "LayoutController"){
            if($method=="store"){
                return [
                    'name' => 'required|max:200',
                    'timeout' => 'required|numeric|min:15000',
                    'type' => 'required|max:200'
                ];
            }
            else{
                return [
                    'name' => 'required|max:200',
                    'timeout' => 'required|numeric|min:15000',
                    'type' => 'required|max:200'
                ];
            }
        }

        //========================Global============================================

        else if($controller == "Global"){
            if($method=="any"){
                return [
                    'start_date' => 'date|date_format:Y-m-d',
                    'end_date' => 'date|date_format:Y-m-d|after_or_equal:start_date',
                    'start_time' => 'date_format:Y-m-d H:i:s',
                    'end_time' => 'date_format:Y-m-d H:i:s'
                ];
            }
        }
        
        return [];
    }
}