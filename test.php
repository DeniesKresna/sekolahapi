<?php

function device($a, $param_1)
{
    $this->load->library('ODevice');

    if ($a == "set_speed_limit") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        $device->set_speed_limit(doubleval($this->input->post('speed_limit')));
        die(langtext('speed_limit_set_ok'));
    }
    if ($a == "set_gprs_interval") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        $device->set_gprs_interval(intval($this->input->post('gprs_interval')));
        die(langtext('gprs_interval_set_ok'));
    }
    /*
    if($a == "flameoff")
    {
    $device_id = $param_1;
    $device = new ODevice($device_id);
    if(!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin)) { die(""); }
    $vd = new ODevice($device_id);
    if($this->admin)
    {
    $vd->activate_flameoff($this->session->userdata("userid"),"admin");
    }
    else
    {
    $vd->activate_flameoff($this->user->id,"user");
    }
    die(langtext('flame_off_request_sent'));
    }
    if($a == "flameon")
    {
    $device_id = $param_1;
    $device = new ODevice($device_id);
    if(!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin)) { die(""); }
    $vd = new ODevice($device_id);
    if($this->admin)
    {
    $vd->request_flameon($this->session->userdata("userid"),"admin");
    }
    else
    {
    $vd->request_flameon($this->user->id,"user");
    }
    die(langtext('flame_on_request_sent'));
    }
     */
    if ($a == "flameon_password") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        if (sizeof($_POST) > 0) {
            $password = md5($_POST['password']);
            $users    = $device->get_users_upto_superusers();
            if ($users[0]->password != md5($_POST['password']) && $users[1]->password != md5($_POST['password'])) {
                die(langtext('wrong_password'));
            } else {
                if ($this->admin) {
                    $device->request_flameon($this->session->userdata("userid"), "admin");
                } else {
                    $device->request_flameon($this->user->id, "user");
                }
                die(langtext('flame_on_request_sent'));
            }
        } else {
            echo '
                <form action="/ajax/device/flameon_password/' . $device_id . '" class="dialog_ajax_form" method="post">
                Password: <input type="password" name="password" id="password" /> <button type="submit">Submit</button>
                </form>
              ';
        }
    }
    if ($a == "flameoff_password") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        if (sizeof($_POST) > 0) {
            $password = md5($_POST['password']);
            $users    = $device->get_users_upto_superusers();
            if ($users[0]->password != md5($_POST['password']) && $users[1]->password != md5($_POST['password'])) {
                die(langtext('wrong_password'));
            } else {
                if ($this->admin) {
                    $device->activate_flameoff($this->session->userdata("userid"), "admin");
                } else {
                    $device->activate_flameoff($this->user->id, "user");
                }
                die(langtext('flame_off_request_sent'));
            }
        } else {
            echo '
                <form action="/ajax/device/flameoff_password/<?=$device_id?>" class="dialog_ajax_form" method="post">
                Password: <input type="password" name="password" id="password" /> <button type="submit">Submit</button>
                </form>
              ';
        }
    }
    if ($a == "reset") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        $device->reset_location();
        die(langtext('reset_device_ok'));
    }
    if ($a == "assign_group") {
        $group_id   = intval($this->input->post('group_id'));
        $group_name = $this->input->post('group_name');
        $device_id  = $param_1;
        $device     = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        $device->assign_group($group_id, $group_name);
        die("DONE");
    }
    if ($a == "set_route") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        //$device->set_gprs_interval(intval($this->input->post('gprs_interval')));
        //die(langtext('gprs_interval_set_ok'));
        $route_name       = $this->input->post('name');
        $route_legs       = $this->input->post('route_leg');
        $route_walkpoints = $this->input->post('route_walkpoint');
        $add              = $device->add_route($route_name, parseLatLng($route_walkpoints), parseLatLng($route_legs));
        //var_dump($this->db->last_query());
        if ($add) {
            die(langtext('set_route_ok'));
        } else {
            die(langtext('set_route_fail'));
        }
    }
    if ($a == "set_focus_route") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        if ($device->row->focus_on_route == 'off') {
            $param['focus_on_route'] = 'on';
        } else {
            $param['focus_on_route'] = 'off';
        }
        $edit = $device->edit($param);
        echo strtoupper($param['focus_on_route']);
    }
    if ($a == "delete_route") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        $delete                  = $device->delete_route();
        $param['focus_on_route'] = 'off';
        $edit                    = $device->edit($param);
        echo $delete;
    }
    if ($a == "all_devices") {
        $user_id = $param_1;
        if ($this->user->id != $user_id && !$this->admin && !$this->vsu->is_valid_user($user_id)) {die("");}
        $vu = new OUser($this->user->id);
        if ($vu->row->type == "superuser") {
            $devices          = $vu->get_devices();
            $device_groups    = $vu->get_device_groups();
            $device_group_arr = array();
            if (!empty($devices)) {
                foreach ($device_groups as $dg) {
                    $device_group_devices = $vu->get_device_group_devices($dg->id);
                    foreach ($device_group_devices as $dgd) {
                        $device_group_arr[] = $dgd->id;
                    }
                }

                echo "<div id='group_{$tmpuser->id}' class='groups'>
                      <a href='javascript:void(0);' onclick='\$(\".groups li\").removeClass(\"active\"); $(\".groups li span\").addClass(\"hide\"); return get_user_devices_on_map(" . $this->user->id . ",true);'>{$vu->row->name}</a>
                      <ul>";
                $this->load->library('ODevice');
                $total         = sizeof($devices);
                $total         = $total - sizeof($device_group_arr);
                $count         = 0;
                $cur_device_id = $this->session->userdata('cur_device_id');
                //device list
                foreach ($devices as $row) {

                    $dev_r = $row;
                    //if($this->user->id == 6868){
                    //var_dump($device_group_arr);
                    if (in_array($dev_r->id, $device_group_arr)) {
                        continue;
                    }

                    //}

                    $lastts     = strtotime($dev_r->last_moving_time);
                    $fiveminago = strtotime("-5 minute");
                    $onedayago  = strtotime("-1 day");
                    $vd         = new ODevice($dev_r->id);
                    $dotcolor   = $vd->get_status_color();

                    // $will_expire = $vd->is_feature_expired();
                    // $halo_expire = $vd->is_halo_expired();
                    // $warranty_expire = $vd->is_warranty_expired();

                    ?>
                    <li  <?=($dev_r->id == $cur_device_id ? 'class="active"' : '')?>>
                        <a href="javascript:void(0);" onclick="<?="set_device({$dev_r->id});"?>" class="device_links <?=($dev_r->active_status == 'free' ? 'red':'')?> <?=($dev_r->active_status == 'inactive' ? 'green':'')?>" device_id="<?=$dev_r->id?>" id="device_<?=$dev_r->id?>">
                            <img src="/_assets/images/ddl-<?php if ($count == ($total - 1)) {echo "last";} else {echo "any";}?>.png" /> <?php echo $dev_r->name; ?>
                        </a>
                        <br>
                        <span id="span_<?=$dev_r->id?>" class="<?=($dev_r->id == $cur_device_id ? '' : 'hide')?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$dev_r->device_type_sn_complete?></span>
                    </li>
                    <?
                    unset($vd);
                    $count++;
                }

                echo "</ul></div>";

                //device groups
                //if($this->user->id == 6868){
                if (!empty($device_groups)) {
                    echo "<ul class='group_devices'>";
                    foreach ($device_groups as $dg) {

                        $device_group_devices = $vu->get_device_group_devices($dg->id);
                        $total                = sizeof($device_group_devices);
                        $count                = 0;
                        if (!$device_group_devices) {
                            continue;
                        }

                        echo "<li>";
                        echo "
                              <div id='group_device_{$dg->id}' class='groups'>
                              <a href='javascript:void(0);' onclick='\$(\".groups li\").removeClass(\"active\"); $(\".groups li span\").addClass(\"hide\"); return get_group_devices_on_map(" . $dg->id . ",true);'><img src='/_assets/images/ddl-last.png' />{$dg->name}</a>
                              <ul>";

                        foreach ($device_group_devices as $dgd) {
                            $dev_r      = $dgd;
                            $lastts     = strtotime($dev_r->last_moving_time);
                            $fiveminago = strtotime("-5 minute");
                            $onedayago  = strtotime("-1 day");
                            $vd         = new ODevice($dev_r->id);
                            $dotcolor   = $vd->get_status_color();

                            // $will_expire = $vd->is_feature_expired();
                            // $halo_expire = $vd->is_halo_expired();
                            // $warranty_expire = $vd->is_warranty_expired();
                            ?>
                            <li <?=($dev_r->id == $cur_device_id ? 'class="active"' : '')?>>
                                <a href="javascript:void(0);" onclick="<?="set_device({$dev_r->id});"?>" class="device_links <?=($dev_r->active_status == 'free' ? 'red':'')?> <?=($dev_r->active_status == 'inactive' ? 'green':'')?>" device_id="<?=$dev_r->id?>" id="device_<?=$dev_r->id?>">
                                    <img src="/_assets/images/ddl-<?php echo ($count == ($total - 1)) ? "last" : "any"; ?>.png" /> <?=$dev_r->device_name?>
                                </a><br>
                                <span id="span_<?=$dev_r->id?>" class="<?=($dev_r->id == $cur_device_id ? '' : 'hide')?>"> &nbsp;&nbsp;&nbsp;&nbsp;<?=$dev_r->device_type_sn_complete?>
                                    <?php
                                    if (strtoupper($this->user->email) == "DEMO" || ($this->user->type == "superuser" && $this->user->supriv_edit == "no")) {
                                        echo $vd->get_disallow_edit_link_format();
                                    } else {
                                        echo $vd->get_edit_link_format();
                                    }
                                    ?>
                                    <br>
                                    <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $vu->get_device_add_cart_links($vd->row); ?>
                                    <?php /* ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;<?=($dev_r->active_status != 'active' ? 'Standar' : 'Premium')?>
                  <?php
                  if(!$vd->is_cellocate()) {
                  if ($warranty_expire && $vd->is_can_renew_warranty() && !empty($vd->row->device_sn)) {
                  echo " | ".anchor('cart/add_to_cart/-2?device_sn='.$vd->row->device_sn,'Warranty');
                  }
                  // else {
                  //   echo 'No Warranty';
                  // }
                  }
                  if(!$vd->is_cellocate() && $vd->is_kartuHalo()) {
                  if ($halo_expire && !empty($vd->row->device_sn)) {
                  echo " | ".anchor('cart/add_to_cart/-3?device_sn='.$vd->row->device_sn,'Halo');
                  }
                  }
                  ?>&nbsp;
                  <a href="http://vast.co.id/shop" target="_blank"><img src='/_assets/icons/cart.png' alt='Vast Technology' /></a>
                  <?php //*/?>
                  </span>
                            </li>
                            <?
                            unset($vd);
                            $count++;
                        }
                        echo "</ul></div></li>";
                    }
                    echo "</ul>";
                }
                //}
            }
        } else {
            $users = $vu->get_users();

            foreach ($users as $tmpuser) {
                if ($vu->row->type == "superuser" && $tmpuser->id == $this->user->id) {
                    continue;
                }

                $tmpvu = new OUser($tmpuser->id);
                if ($tmpvu->row->type != "user") {
                    echo "<div class='group_name'><a href='javascript:void(0);' onclick='return toggleGroup({$tmpuser->id});' id='icon_{$tmpuser->id}' style='text-decoration:none'>+</a> <a href='javascript:void(0);' onclick='return get_group_devices_on_map(0,{$tmpuser->id},true);' style='text-decoration:none'>{$tmpuser->name}</a></div>";
                }

                $devices = $tmpvu->get_devices();
                if (!empty($devices)) {
                    $cur_device_id = $this->session->userdata('cur_device_id');
                    echo "<div id='group_{$tmpuser->id}' class='groups'><ul>";
                    $this->load->library('ODevice');
                    foreach ($devices as $row) {
                        $dev_r      = $row;
                        $lastts     = strtotime($dev_r->last_moving_time);
                        $fiveminago = strtotime("-5 minute");
                        $onedayago  = strtotime("-1 day");
                        $vd         = new ODevice($dev_r->id);
                        $dotcolor   = $vd->get_status_color();

                        // $will_expire = $vd->is_feature_expired();
                        // $halo_expire = $vd->is_halo_expired();
                        // $warranty_expire = $vd->is_warranty_expired();
                        ?>
                        <li  <?=($dev_r->id == $cur_device_id ? 'class="active"' : '')?>>
                            <a href="javascript:void(0);" onclick="<?="set_device({$dev_r->id});"?>" class="device_links" device_id="<?=$dev_r->id?>" id="device_<?=$dev_r->id?>">
                                <?=$dev_r->device_name?>
                            </a>
                            <br>
                            <span id="span_<?=$dev_r->id?>" <?=($dev_r->id == $cur_device_id ? '' : 'class="hide"')?>>
                  &nbsp;&nbsp;&nbsp;&nbsp;<?=$dev_r->device_type_sn_complete?>
                                <?php
                                if ($vu->is_demo()) {
                                    echo $vd->get_disallow_edit_link_format();
                                } else {
                                    echo $vd->get_edit_link_format();
                                }
                                ?>
                                <br>
                                <?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $vu->get_device_add_cart_links($vd->row); ?>
                </span>
                        </li>
                        <?
                        unset($vd);
                    }
                    echo "</ul></div>";
                    if ($tmpvu->type != "user") {
                        echo "";
                    }

                }
                unset($tmpvu);
            }

        }
        unset($vu);

        die();
    }
    if ($a == "get_route") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}

        header("content-type: text/json");
        $route        = $device->get_route();
        $r            = null;
        $r->id        = $route->id;
        $r->name      = $route->name;
        $r->waypoints = multipointToArray($route->waypoints);
        $r->legs      = multipointToArray($route->legs);

        echo json_encode($r);
    }
    if ($a == "get_position") {
        header("content-type: text/json");
        // if (!stristr($_SERVER['HTTP_REFERER'], "vast.co.id") && !stristr($_SERVER['HTTP_REFERER'], "cellocate.com")) {echo json_encode((object) array('error' => "Invalid request. {$_SERVER['HTTP_REFERER']}"));die();}

        // get device object
        $q    = "SELECT * FROM devices WHERE imei = ?";
        $dres = $this->db->query($q, array($this->input->get('sn')));
        if (!emptyres($dres)) {
            $drow = $dres->row();
            $this->load->library('ODevice');
            $vdrow = new ODevice();
            $vdrow->setup($drow);
            $pvdrow = $vdrow;
        } else {
            exit;
        }

        if (!$vdrow->id || (!$vdrow->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($drow->id))) {die("");}
        if (!$vdrow->is_active_device()) {
            die("");
        }

        $lastpos    = $vdrow->get_last_position();
        $lastupdate = $vdrow->get_last_update();
        $lastalarm  = $vdrow->get_last_alarm();

        if ($lastpos === false) {
            $r->device_sn      = $vdrow->row->imei;
            $r->name           = $vdrow->row->device_name;
            $r->device_type_id = $drow->device_type_id;
            $r->addr           = "";
            $r->lat            = DEFAULT_LAT;
            $r->lng            = DEFAULT_LNG;
            $r->icon           = $vdrow->get_current_status_icon();
            if ($this->input->get('showall') == 'true') {
                $vu = new OUser($this->user->id);
                if ($vu->row->type == "user" || $vu->row->type == "superuser") {
                    $tmpdevices = $vu->get_devices();
                } else if ($vu->row->type == "subadmin") {
                    $vsa        = new VSubAdmin($vu->row->id);
                    $tmpdevices = $vsa->get_devices();
                }
                if (empty($tmpdevices)) {} else {
                    $devices = $this->generate_devices_for_json($tmpdevices);

                    $r->other_devices = $devices;

                }
            }
            echo json_encode($r);
        } else {
            $r = $lastupdate;
            if ($tmpr->photo != "") {
                $r->photo = $tmpr->photo;
            } else {
                $r->photo = '';
            }
            $r->name = $vdrow->row->device_name;
            /*
            $cacheaddress = get_cached_address($lastpos->lat,$lastpos->lng,$lastpos->course,$r->id,$r->device_sn);
            if($cacheaddress == FALSE)
            {
            $r->addr = reverse_geocode($lastpos->lat,$lastpos->lng);
            }
            else
            {
            $r->addr = $cacheaddress;
            }
             */

            $r->device_type_id = $drow->device_type_id;
            $r->addr           = "";
            $r->lat            = $lastpos->lat;
            $r->lng            = $lastpos->lng;
            $r->last_update    = format_date($lastupdate->dt_added);
            $r->dt             = format_date($lastpos->dt_added);

            $r->color = $vdrow->get_status_color();

            if ($lastpos->satellite == null || intval($lastpos->satellite) == 0) {
                $r->satellite = "N/A";
            }

            $r->gps     = $r->satellite     = $lastpos->satellite;
            $r->gsm     = $r->signal;
            $r->bearing = $lastpos->course;
            if ($vdrow->get_current_status() == "UPDATED") {
                if ($r->photo != "") {
                    $r->icon = $r->photo;
                } else {
                    $r->icon = $vdrow->get_current_status_icon();
                }

            } else {
                $r->icon = $vdrow->get_current_status_icon();
            }
            // device status
            $lastmsg   = array();
            $lastmsg[] = $vdrow->get_current_status();

            if ($lastupdatets >= $thirtydaysago) {
                // $lastmsg[] = $vdrow->get_device_moving_status($acc);
                if ($vdrow->row->speed_limit > 0) {
                    if ($vdrow->row->speed_limit < $lastupdate->speed) {
                        $lastmsg[] = "SPEEDING";
                    }
                }
                if ($lastalarm->status_alarm == "SOS") {
                    $lastmsg[] = "SOS";
                }

            }

            // process alarms
            // $alarm_rows = $vdrow->get_alarmreport_by_date(date("Y-m-d") . " 00:00:00", date("Y-m-d H:i:s"));
            $alarms = array();

            foreach ($alarm_rows as $alarm) {

                $tmparr = explode(",", $alarm->alarms);

                foreach ($tmparr as $tmp) {
                    if (stristr($tmp, "geofence")) {
                        $alarms[] = "GEOFENCE";
                    } else if (stristr($tmp, "POI")) {
                        $alarms[] = "POI";
                    } else {
                        $alarms[] = $tmp;
                    }

                }

                $alarms = array_unique($alarms);

                $newalarm = implode(", ", $alarms);

            }
            $r->last_alarm = $newalarm;

            // get login pr logout
            if ($vdrow->get_current_status() == 'OFFLINE') {
                $login = '';
            } else {
                $loginStat = $vdrow->get_last_login();
                //var_dump($loginStat);
                if ($loginStat->type == 'logout') {
                    $login = 'logout';
                } else {
                    $login = 'login';
                }

            }

            $r->speed = number_format($lastpos->speed, 2);
            if ($this->input->get('showall') == 'true') {
                $vu = new OUser($this->user->id);
                if ($vu->row->type == "user" || $vu->row->type == "superuser") {
                    $tmpdevices = $vu->get_devices();
                } else if ($vu->row->type == "subadmin") {
                    $vsa        = new VSubAdmin($vu->row->id);
                    $tmpdevices = $vsa->get_devices();
                }
                if (empty($tmpdevices)) {}
                else {
                    $devices = $this->generate_devices_for_json($tmpdevices);

                    $r->other_devices = $devices;

                }
            }

            echo json_encode($r);
        }
    }
    if ($a == "device_info") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        if (!$device->is_active_device()) {
            die("Rental expired. Please contact us.");
        }

        if (stristr($_SERVER['HTTP_REFERER'], "admin")) {
            $admin = "admin";
        } else {
            $admin = "";
        }

        ?>
        <div id="device_info">
            <?php
            $lastmsg = array();
            $lastpos = $lastupdate = $device->get_last_position();

            $status_name = strtoupper($device->get_current_status());
            $lastmsg[]   = $status_name;

            $status = $status_name;
            ?>
            <?=langtext('Status')?>: <span id="device_status"><?=$status?></span><br />
            <br>
            <?php
            if ($device->is_gt06()) {
                if ($device->has_voltage_status()) {
                    if ($device->row->oil_engine_status == "OFF") {
                        $flame_status = "<span style='color:red'>ENGINE OFF</span>";
                    } else {
                        $flame_status = "ENGINE NORMAL";
                    }
                    // "FLAME {$vdrow->row->oil_engine_status}";
                    ?>
                    <?=langtext('power')?>: POWER <span id="device_power"><?=protocol_interpret('GT06', 'status_voltage', $lastupdate->status_voltage)?></span>, <span id="device_flame_status"><?=$flame_status?></span><br />
                    <?php
                } else {
                    ?><?=langtext('power')?>: N/A<?php
                }
            }
            ?>
            <input type="hidden" name="device_type" id="device_type" value="<?=$device->row->device_type_id?>">
            <?php /* <?=langtext('last_update')?> : <span id="device_last_location_date"></span><br />*/ ?>
            <?=langtext('last_location_update')?> : <span id="device_gps_date"></span><br />
            <?=langtext('last_location')?>: <span id="device_last_location"></span><br />

            <?=langtext('device_name')?> : <?=$device->row->name?><br />
            TRACKER ID: <span id="span_device_sn"><?=$device->row->imei?></span><br />

        </div>
        <?
        die();
    }
    if ($a == "device_geofence") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        if ($device->row->geofence_coords == "") {
            echo "[]";
        } else {
            echo $device->row->geofence_coords;
        }

        die();
    }
    if ($a == "device_history_box") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {die("");}
        $start = $this->session->userdata('start_date');
        $end   = $this->session->userdata('end_date');
        if (!empty($start)) {
            $hmstart = date('H:i', strtotime($start));
        }

        if (!empty($end)) {
            $hmend = date('H:i', strtotime($end));
        }

        if (!empty($start)) {
            $start = date('Y-m-d', strtotime($start));
        }

        if (!empty($end)) {
            $end = date('Y-m-d', strtotime($end));
        }

        $hstart = explode(':', $hmstart);
        $hend   = explode(':', $hmend);
        ?>
        <form method="get" action="" id="history_form">
            <input type="hidden" name="device_id" id="device_id" value="<?=$device->row->id?>" />
            <span class="field"><?=langtext('from')?></span> <input type="text" name="start" value="<?=($start == "" ? date("Y-m-d") : $start)?>" id="start" size="11" /> <?=hour_ddl("start_hour", (empty($hstart[0]) ? "00" : $hstart[0]))?><?=minute_ddl("start_min", (empty($hstart[1]) ? "00" : $hstart[1]))?><br />
            <span class="field"><?=langtext('to')?></span> <input type="text" name="end" value="<?=($end == "" ? date("Y-m-d") : $end)?>" id="end" size="11" /> <?=hour_ddl("end_hour", (empty($hend[0]) ? date("H") : $hend[0]))?><?=minute_ddl("end_min", (empty($hend[1]) ? date("i") : $hend[1]))?>  <br /><button type="submit"><?=langtext('show_history')?></button>
            <button type="button" name="animation" id="animation" onclick="rhistory.play(0,1000);$('#rhistory_play_speed').removeClass('hide');"><?=langtext('animate')?></button>
            <?php /* ?>
      <button type="button" name="stop_animation" id="stop_animation" onclick="rhistory.stop_play();"><?=langtext('stop')?></button>
      <?php //*/?>
            <button type="button" name="clear" id="clear" onclick="rhistory.clear_all();$('#rhistory_play_speed').addClass('hide');"><?=langtext('clear')?></button>
            <button type="button" name="email" id="email" onclick="reporting_system.summary_report('<?=date("Y-m-d", strtotime("-1 day"))?>','<?=date("Y-m-d", strtotime("-1 day"))?>',null,null,1);">Email</button>
            <div id="rhistory_play_speed" class="hide">
                <br />Play Speed: <button type="button" onclick="rhistory.stop_play();"><i class="fa fa-stop"></i></button> <button type="button" onclick="rhistory.play(0,1000);">&gt;</button> <button type="button" onclick="rhistory.play(0,500);">&gt;&gt;</button> <button type="button" onclick="rhistory.play(0,100);">&gt;&gt;&gt;</button>
            </div>
            <?php /*?><button type="submit" name="act" id="export" value="export_to_excel" onclick="return export_to_excel(<?=$device->id?>);"><?=langtext('export_to_excel')?></button><?php */?>
            <br  />
            <span id="history_error" style="color:red; font-size:0.8em;"></span>
        </form><br />
        <div style="overflow:auto;" id="history_div">
        </div>
        <div id="distance_div"></div>
        <?
        die();
    }
    if ($a == "device_command_box") {
        $device_id = $param_1;
        $device    = new ODevice($device_id);
        if (!$device->id || (!$device->is_device_owner($this->user->id) && !$this->admin && !$this->vsu->is_valid_device($device_id))) {
            die("");
        }
        $is_cellocate = $device->is_cellocate();
        $vu           = new OUser($this->user->id);
        ?>
        <div id="init_start">
            <div style="padding-bottom:2px;">
                <button id="device_auto_center"><?=langtext('auto_center')?>: <span id="device_auto_center_status">OFF</span></button> <a title="Klik di sini untuk melihat video tutorial" href="https://www.youtube.com/watch?v=wV7BZ5JET-s" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a>
            </div>
            <div style="padding-bottom:2px;">
                <?php
                if ($device->row->geofence_coords == "" || $device->row->geofence_coords == "[]") {
                    ?>
                    <?=langtext('geofence_is_not_set')?>
                    <button id="gf_start"><?=ucfirst(langtext('create'))?></button>
                    <?php
                } else {
                    ?>
                    <?=langtext('geofence_is_set')?>
                    <button id="gf_start"><?=ucfirst(langtext('edit'))?></button>
                    <button id="gf_delete" device_id="<?php echo $device->row->id; ?>"><?=ucfirst(langtext('delete'))?></button>
                    <?php
                }
                ?>
                <a href="https://www.youtube.com/watch?v=Ymxuz9P-cYM" title="Klik di sini untuk melihat video tutorial" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a>
            </div>
            <?php
            if ($device->row->active_status == 'active') {
                $route = $device->get_route();
                ?>
                <div style="padding-bottom:2px;">
                    <?php if (!$route): ?>
                        <?=langtext('route_is_not_set')?> <button id="device_create_route"><?=langtext('create')?></button>
                    <?php else: ?>
                        <?=langtext('route_is_set')?> <button id="device_edit_route"><?=ucfirst(langtext('edit'))?></button> <button id="device_delete_route"><?=ucfirst(langtext('delete'))?></button>
                        <button id="device_focus_route"><?=langtext('focus_route')?>: <span id="device_focus_route_status"><?=strtoupper($device->row->focus_on_route)?></span></button>
                    <?php endif;?>
                </div>
            <?php } ?>
            <?php
            if ($device->row->active_status == "active") {
                ?>
                <!-- mySpots -->
                <div style="padding-bottom:2px;">
                    <?php
                    $pois = $device->get_pois();

                    if ($pois) {
                        $total_pois = intval(sizeof($pois));
                    } else {
                        $total_pois = 0;
                    }

                    if ($total_pois >= 5) {
                        $disabled = "disabled='disabled'";
                    }
                    ?>
                    <span id="total_pois_text"><?=$total_pois?></span> <?=langtext('pois_are_set')?> <button id="poi_start" <?=$disabled?>><?=langtext('set_poi')?></button>
                    <a href="https://www.youtube.com/watch?v=6OmIC43v-zk" title="Klik di sini untuk melihat video tutorial" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a>
                </div>
            <?php }?>

            <!-- myPOI -->
            <div style="padding-bottom:2px;">
                <?php
                $mypois       = $device->get_mypois();
                $total_mypois = intval(sizeof($mypois));
                ?>
                <span id="total_mypois_text"><?=$total_mypois?></span> <?=langtext('mypois_are_set')?> <button id="mypoi_start"><?=langtext('set_mypoi')?></button> <button id="mypoi_toggle" data-value="show"><span>Hide</span> myPOI</button>
                <a title="Klik di sini untuk melihat video tutorial" href="https://www.youtube.com/watch?v=0fisWfRh9mE" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a>
            </div>
            <div style="padding-bottom:2px;">
                <?php
                $lastupdate = $device->get_current_status();
                if ($device->is_gt06() || $device->is_tr02()) {
                    ?>
                    <button id="device_reset_btn"><?=langtext('Reset')?></button>
                    <a href="https://www.youtube.com/watch?v=FXnF4Z-sMeo" title="Klik di sini untuk melihat video tutorial" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a><br /><br />
                    <span id="reset_status"></span>
                    <?
                }
                ?>
            </div>
            <input type="hidden" name="speed_alert_id" id="speed_alert_id" value="<?=$device->row->id?>" />
            <?php if (!$is_cellocate) {?>
                <form id="speed_alert_form" style="padding-bottom:2px;">
                    <?=langtext('speed_limit')?>: <input type="text" id="speed_alert" name="speed_alert" style="width:40px;" value="<?=$device->row->speed_limit?>" /> km/h <button id="speed_alert"><?=langtext('set')?></button>
                    <a href="https://www.youtube.com/watch?v=pUDRCnvvHcg" title="Klik di sini untuk melihat video tutorial" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a><br />
                    <span id="speed_alert_status"></span>
                </form>
                <br />
            <?php }?>

            <div style="padding-bottom:2px;">
                <?php
                if ($device->has_gprs_interval()) {
                    ?>
                    <form id="gprs_interval_form" style="padding-bottom:2px;">
                        <?php if (!$device->is_cellocate()) {?>
                            <?=langtext('gps_interval')?>: <?=dropdown("gprs_interval", array(10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45, 50 => 50, 55 => 55, 60 => 60), $device->row->gprs_interval)?> <?=langtext('seconds')?>
                        <?php } else {?>
                            <?=langtext('gps_interval')?>: <?=dropdown("gprs_interval", array(180 => 3, 300 => 5, 600 => 10), $device->row->gprs_interval)?> <?=langtext('minutes')?> <!-- ,1800 => 30,3600 => 60 -->
                        <?php }?>
                        <button id="gprs_interval_btn"><?=langtext('set')?></button>
                        <a href="https://www.youtube.com/watch?v=pUDRCnvvHcg" title="Klik di sini untuk melihat video tutorial" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a>
                        <span id="gprs_interval_status"></span>
                        <br />
                    </form>
                    <?php
                }
                ?>
            </div>
            <div style="padding-bottom:2px;">
                <?=langtext('nearest_reminder')?>:<br>
                <?php
                $reminder = $device->get_nearest_reminders();
                //var_dump($reminder->date);
                echo "[" . $reminder->date->diff . "] " . langtext('day') . " " . anchor("services", "<img src='/_assets/images/icon_edit.png' alt='Setting' />") . "<br>";
                echo "[" . $reminder->km->value . "] km " . anchor("services", "<img src='/_assets/images/icon_edit.png' alt='Setting' />");
                ?>
            </div>
            <?php if ($vu->row->type == "superuser") {?>
                <div style="padding-bottom:2px;">
                    <button onclick="window.location='<?=base_url('devices?addv=1')?>'"><span><?=ucfirst(langtext('add') . ' Voucher')?></span></button>
                </div>
            <?php }?>
            <?php
            if ($device->has_flame_status() && (($this->user->email != "DEMO" && $this->user->id != "") || $this->admin)) {
                ?>
                <div style="padding-bottom:2px;">
                    <?php if (!$is_cellocate) {?>
                        <button class="dialog_ajax" ajax_url="/ajax/device/flameoff_password/<?=$device->row->id?>"><?=langtext('turn_off_engine')?></button> <button class="dialog_ajax" ajax_url="/ajax/device/flameon_password/<?=$device->row->id?>"><?=langtext('turn_on_engine')?></button><span id="engine_request_status"></span>
                        <br />
                    <?php }?>
                    <a href="https://www.youtube.com/watch?v=cnqWo5aqEO4" title="Klik di sini untuk melihat video tutorial" target="_blank"><img src='/_assets/icons/video.png' alt='Video' /></a> << Klik di sini untuk video training
                </div>
                <?php
            } else {

            }
            ?>
        </div>
        <?php
        die();
    }
    die();
}