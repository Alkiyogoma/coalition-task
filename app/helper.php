<?php

function church_name() {
    $server_name = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

    $domain = strtolower(str_replace('.kanisalink.com', '', $server_name));

    if ($domain == 'localhost') {
        // if condition for local IP will be here. If not localhost, put your server name
        $schema = 'kanisalink.';
    } else if ($domain == 'demo') {
        $schema = 'demo.';
    } else {
        $schema = $domain . '.';
    }
    return $schema;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function valid_date($date, $format = 'Y-m-d')
{
    return date($format, strtotime($date));
}

function json_call($array = null) {
    if (isset($_GET['callback']) === TRUE) {
        header('Content-Type: text/javascript;');
        header('Access-Control-Allow-Origin: http://client');
        header('Access-Control-Max-Age: 3628800');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

        return request('callback') . '(' . (json_encode($array)) . ')';
    }
}

    function money($amount, $decimal = 0) {
        return number_format($amount, $decimal);
    }



function number_to_words($number) {
    if (($number < 0) || ($number > 999999999)) {
        return "$number";
    }

    $Gn = floor($number / 1000000);  /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10; /* Ones */

    $res = "";

    if ($Gn) {
        $res .= number_to_words($Gn) . " Million";
    }

    if ($kn) {
        $res .= (empty($res) ? "" : " ") .
                number_to_words($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
                number_to_words($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res)) {
        $res = "Zero";
    }

    return $res;
}

function userAccessRole() {
    $user_id = \Auth::User()->id;

    if ((int) $user_id > 0) {
        $user = \App\Models\User::find($user_id);  
        $permission = \App\Models\RoleHasPermission::where('role_id', $user->role_id)->get();
      
        $objet = array();
      
        if (count($permission) > 0) {
            foreach ($permission as $perm) {
                array_push($objet, $perm->permission->name);
            }
        }
       
        return $objet;
    }
}

function form_error($errors, $tag) {
    if ($errors != null && $errors->has($tag)) {
        return $errors->first($tag);
    }
}

function can_access($permission) {
    $user_id = \Auth::User()->id;
    
    if ((int) $user_id > 0) {
        $global = userAccessRole();
        return in_array($permission, $global) ? 1 : 0;
    }
}


function user_id() {
    if (!Auth::check()) {
        return 0;
    }else{
            $user_id = \Auth::User()->id;
            return (int) $user_id > 0 ? (int) $user_id  : 0;
        }

    }

function createRoute() {
    $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $url_param = explode('/', $url);

    $controller = isset($url_param[3]) && !empty($url_param[3]) ? $url_param[3] . '' : 'Dashboard';
    $method = isset($url_param[4]) && !empty($url_param[4]) ? $url_param[4] : 'index';
    $view = $method == 'view' ? 'show' : $method;

    return in_array($controller, array('public', 'storage')) ? NULL : ucfirst($controller) . '@' . $view;
}

function timeAgo($datetime, $full = false) {
    return \Carbon\Carbon::createFromTimeStamp(strtotime($datetime))->diffForHumans();
}


if (!function_exists('form_dropdown')) {

    function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {
        if (!is_array($selected)) {
            $selected = array($selected);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if (count($selected) === 0) {
            // If the form name appears in the $_POST array we have a winner!
            if (isset($_POST[$name])) {
                $selected = array($_POST[$name]);
            }
        }
 
        if ($extra != '')
            $extra = ' ' . $extra;

        $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

        $form = '<select name="' . $name . '"' . $extra . $multiple . ">\n";

        foreach ($options as $key => $val) {
            $key = (string) $key;

            if (is_array($val) && !empty($val)) {
                $form .= '<optgroup label="' . $key . '">' . "\n";

                foreach ($val as $optgroup_key => $optgroup_val) {
                    $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

                    $form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
                }

                $form .= '</optgroup>' . "\n";
            } else {
                $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

                $form .= '<option value="' . $key . '"' . $sel . '>' . (string) $val . "</option>\n";
            }
        }

        $form .= '</select>';

        return $form;
    }

}



/**
 * 
 * @param type $phone_number
 * @return array($country_name, $valid_number) or not array if wrong number
 */
function validate_phone_number($number) {
    $phone_number = preg_replace("/[^0-9]/", '', $number);
    ;
    if (strlen(preg_replace('#[^0-9]#i', '', $phone_number)) < 7 || strlen(preg_replace('#[^0-9]#i', '', $phone_number)) > 14) {
        return FALSE;
    } else {

        $y = substr($phone_number, -9);
        $z = str_ireplace($y, '', $phone_number);
        $p = str_ireplace('+', '', $z);

        $x = array(
            93 => " Afghanistan",
            355 => " Albania", 213 => " Algeria",
            1 => " American Samoa",
            376 => "Andorra ",
            244 => " Angola",
            1 => " Anguilla",
            1 => " Antigua and Barbuda",
            54 => " Argentine Republic",
            374 => " Armenia",
            297 => " Aruba",
            247 => " Ascension",
            61 => " Australia",
            672 => " Australian External Territories",
            43 => " Austria ", 994 => " Azerbaijani Republic", 1 => " Bahamas ", 973 => " Bahrain", 880 => " Bangladesh ", 1 => " Barbados ", 375 => " Belarus ", 32 => " Belgium ", 501 => " Belize", 229 => " Benin ", 1 => " Bermuda ", 975 => " Bhutan", 591 => " Bolivia", 387 => " Bosnia and Herzegovina ", 267 => " Botswana", 55 => " Brazil (Federative Republic of)", 1 => " British Virgin Islands", 673 => " Brunei Darussalam ", 359 => " Bulgaria (Republic of)", 226 => " Burkina Faso", 257 => " Burundi (Republic of)", 855 => " Cambodia (Kingdom of)", 237 => " Cameroon (Republic of)", 1 => " Canada", 238 => " Cape Verde (Republic of)", 1 => " Cayman Islands ", 236 => " Central African Republic ", 235 => " Chad (Republic of)", 56 => " Chile ", 86 => " China ( Republic of)", 57 => " Colombia (Republic of)", 269 => " Comoros (Union of the)", 242 => " Congo (Republic of the)", 682 => " Cook Islands", 506 => " Costa Rica", 225 => " Côte d \"Ivoire (Republic of)", 385 => " Croatia (Republic of)", 53 => " Cuba", 357 => " Cyprus (Republic of)", 420 => " Czech Republic ", 850 => " Democratic People\"s Republic of Korea ", 243 => " Democratic Republic of the Congo", 670 => " Democratic Republic of Timor-Leste", 45 => " Denmark", 246 => " Diego Garcia ", 253 => " Djibouti (Republic of) ", 1 => " Dominica (Commonwealth of)", 1 => " Dominican Republic", 593 => " Ecuador", 20 => " Egypt (Arab Republic of)", 503 => " El Salvador (Republic of)", 240 => " Equatorial Guinea (Republic of)", 291 => " Eritrea", 372 => " Estonia (Republic of)", 251 => " Ethiopia (Federal Democratic Republic of) ", 500 => " Falkland Islands (Malvinas) ", 298 => " Faroe Islands", 679 => " Fiji (Republic of)", 358 => " Finland ", 33 => " France", 262 => " French Departments and Territories in the Indian Ocean ", 594 => " French Guiana (French Department of)", 689 => " French Polynesia (Territoire français \"outre-mer)", 241 => " Gabonese Republic", 220 => " Gambia (Republic of the)", 995 => " Georgia", 49 => " Germany (Federal Republic of)", 233 => " Ghana", 350 => " Gibraltar", 881 => " Global Mobile Satellite System (GMSS) shared code", 30 => " Greece ", 299 => " Greenland (Denmark)", 1 => " Grenada", 388 => " Group of countries shared code", 590 => " Guadeloupe (French Department of)", 1 => " Guam ", 502 => " Guatemala (Republic of)", 224 => " Guinea (Republic of)", 245 => " Guinea-Bissau (Republic of)", 592 => " Guyana", 509 => " Haiti (Republic of)", 504 => " Honduras (Republic of)", 852 => " Hong Kong China", 36 => " Hungary (Republic of)", 354 => " Iceland", 91 => " India (Republic of)", 62 => " Indonesia (Republic of)", 870 => " Inmarsat SNAC ", 98 => " Iran (Islamic Republic of)", 964 => " Iraq (Republic of)", 353 => " Ireland", 972 => " Israel (State of)", 39 => " Italy", 1 => " Jamaica", 81 => " Japan", 962 => " Jordan (Hashemite Kingdom of)", 7 => " Kazakhstan (Republic of)", 254 => " Kenya (Republic of)", 686 => " Kiribati (Republic of)", 82 => " Korea (Republic of)", 965 => " Kuwait (State of)", 996 => " Kyrgyz Republic ", 856 => " Lao People\"s Democratic Republic", 371 => " Latvia (Republic of)", 961 => " Lebanon ", 266 => " Lesotho (Kingdom of)", 231 => " Liberia (Republic of)", 218 => " Libya (Socialist People\"s Libyan Arab Jamahiriya)", 423 => " Liechtenstein (Principality of)", 370 => " Lithuania (Republic of) ", 352 => " Luxembourg", 853 => " Macao China", 261 => " Madagascar (Republic of)", 265 => " Malawi", 60 => " Malaysia", 960 => " Maldives (Republic of)", 223 => " Mali (Republic of)", 356 => " Malta", 692 => " Marshall Islands (Republic of the)", 596 => " Martinique (French Department of)", 222 => " Mauritania (Islamic Republic of)", 230 => " Mauritius (Republic of)", 269 => " Mayotte", 52 => " Mexico", 691 => " Micronesia (Federated States of)", 373 => " Moldova (Republic of) ", 377 => " Monaco (Principality of)", 976 => " Mongolia ", 382 => " Montenegro (Republic of)", 1 => " Montserrat", 212 => " Morocco (Kingdom of)", 258 => " Mozambique (Republic of) ", 95 => " Myanmar (Union of)", 264 => " Namibia (Republic of)", 674 => " Nauru (Republic of)", 977 => " Nepal (Federal Democratic Republic of)", 31 => " Netherlands (Kingdom of the)", 599 => " Netherlands Antilles", 687 => " New Caledonia (Territoire français d\"outre-mer)", 64 => " New Zealand", 505 => " Nicaragua", 227 => "Niger (Republic of the)", 234 => " Nigeria (Federal Republic of)", 683 => " Niue ", 1 => " Northern Mariana Islands (Commonwealth of the)", 47 => " Norway", 968 => " Oman (Sultanate of)", 92 => " Pakistan (Islamic Republic of)", 680 => " Palau (Republic of)", 507 => " Panama (Republic of)", 675 => " Papua New Guinea", 595 => " Paraguay (Republic of)", 51 => "Peru", 63 => "Philippines (Republic of the)", 48 => " Poland (Republic of)", 351 => " Portugal", 1 => " Puerto Rico", 974 => " Qatar (State of)", 40 => " Romania ", 7 => " Russian Federation", 250 => " Rwanda (Republic of)", 290 => " Saint Helena", 1 => " Saint Kitts and Nevis", 1 => " Saint Lucia", 508 => " Saint Pierre and Miquelon (Collectivité territoriale de la République française)", 1 => " Saint Vincent and the Grenadines", 685 => " Samoa (Independent State of)", 378 => " San Marino (Republic of) ", 239 => " Sao Tome and Principe (Democratic Republic of)", 966 => " Saudi Arabia (Kingdom of)", 221 => " Senegal (Republic of)", 381 => " Serbia (Republic of)", 248 => " Seychelles (Republic of)", 232 => " Sierra Leone", 65 => " Singapore (Republic of)", 421 => " Slovak Republic", 386 => " Slovenia (Republic of)", 677 => " Solomon Islands", 252 => " Somali Democratic Republic", 27 => " South Africa (Republic of)", 34 => " Spain", 94 => " Sri Lanka (Democratic Socialist Republic of)", 249 => " Sudan (Republic of the)", 597 => " Suriname (Republic of)", 268 => " Swaziland (Kingdom of)", 46 => " Sweden", 41 => " Switzerland (Confederation of)", 963 => " Syrian Arab Republic", 886 => " Taiwan China", 992 => " Tajikistan (Republic of)", 255 => " Tanzania (United Republic of)", 66 => " Thailand", 389 => " The Former Yugoslav Republic of Macedonia", 228 => " Togolese Republic", 690 => " Tokelau", 676 => " Tonga (Kingdom of)", 1 => " Trinidad and Tobago", 290 => " Tristan da Cunha", 216 => " Tunisia", 90 => " Turkey", 993 => " Turkmenistan", 1 => " Turks and Caicos Islands", 688 => " Tuvalu", 256 => " Uganda (Republic of)", 380 => " Ukraine", 971 => " United Arab Emirates", 44 => " United Kingdom of Great Britain and Northern Ireland ", 1 => " United States of America", 1 => " United States Virgin Islands", 598 => " Uruguay (Eastern Republic of)", 998 => " Uzbekistan (Republic of)", 678 => " Vanuatu (Republic of)", 379 => " Vatican City State", 39 => " Vatican City State", 58 => " Venezuela (Bolivarian Republic of)", 84 => " Viet Nam (Socialist Republic of)", 681 => " Wallis and Futuna (Territoire français d\"outre-mer)", 967 => " Yemen (Republic of)", 260 => "Zambia (Republic of)", 263 => " Zimbabwe");


        foreach ($x as $key => $value) {
            if ($p == $key) {
                $country_name = $value;
                $code = $key;
            } else {
                $country_name = ' Tanzania (United Republic of)';
                $code = '255';
            }
        }

        $valid_number = '+' . $code . $y;

        $valid = array($country_name, $valid_number);
        return $valid;
    }

}

function random_username($string) {
    $pattern = " ";
    $firstPart = strstr(strtolower($string), $pattern, true);
    $secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
    $nrRand = rand(0, 100);

    $username = trim($firstPart).trim($secondPart).trim($nrRand);
    return $username;
}

function allUpper($str){
    return strtoupper($str);
  }

    function sendMessages(){
      
        $messages =  DB::table('messages')->where('status', 0)->select('body')->limit(5)->distinct()->get();
        if (count($messages) > 0) {
            $i = 1;
            $numbers = [];
            $numbers1 = array();

            foreach($messages as $message1){
                $body = $message1->body;

                $real_messages =  \DB::table('messages')->where('body', $body)->where('status', 0)->limit(10)->get();
               
            foreach($real_messages as $message){
                $phone_number = str_replace('+', '', validate_phone_number(trim($message->phone))[1]);
                if(preg_match('/25576/', $phone_number) || preg_match('/25575/', $phone_number) || preg_match('/25574/', $phone_number)){
                    array_push($numbers1, $phone_number);
                }else{
                    array_push($numbers, $phone_number);
                }
               \DB::table('messages')->where('id', $message->id)->update(['status' => 1, 'return_code' => 'Message Sent Successfuly']);
            }
           count($numbers1) > 0 ? set_numbers(array_unique($numbers1) , $body) : '';
           count($numbers) > 0 ? imart($body, (string)implode(',', array_unique($numbers)), 'STEAM') : '';
        }
            return true;
        }else{
            return true;
        }
    }


    function imart($message, $phone_number, $sender){
        $api_key = '363622C886AD5E';
        $contacts = $phone_number;
        $from = $sender;
        $sms_text = urlencode($message);
        if(preg_match('/25576/', $phone_number) || preg_match('/25575/', $phone_number) || preg_match('/25574/', $phone_number)){
            send_sms1($phone_number, $message);
        }
        //Submit to server
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://smsportal.imartgroup.co.tz/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=8&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response; 
    }


function send_sms($phone_number, $message, $sender = 'INFO'){
    $api_key = '363622C886AD5E';
    $contacts = $phone_number;
    $from = $sender;
    $sms_text = urlencode($message);
    //Submit to server
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://smsportal.imartgroup.co.tz/app/smsapi/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=8&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response; 
}


    function set_numbers($numbers, $message){
        if(count($numbers) > 0){
            foreach ($numbers as $number) {
                send_sms1($number, $message);
            }
        }
    }

    function send_sms1($phone_number, $message, $sender = 'DARSMS'){
        $api_key = '363622C886AD5E';
        $contacts = $phone_number;
        $from = $sender;
        $sms_text = urlencode($message);
        
        //Submit to server
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://smsportal.imartgroup.co.tz/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=8&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response; 
    }


    
    function logRequest($id, $name) {
        $id = $id;
        

        $ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
        $loc = getIsp($ip);
        $url_param = explode('/', createRoute());
        $controller = isset($url_param[0]) ? $url_param[0] : 'homepage';
        $method = isset($url_param[1]) ? $url_param[1] : 'index';
        if (!empty($loc) && is_object($loc)) {
            $log = array(
                'url' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
                'user_agent' => getBrowser(),
                'platform' => getOS(),
                'country' => getIsp()->country,
                'city' => getIsp()->city,
                'source' => getIsp()->ip,
                'name' => $name,
                'user_id' => $id,
                'region' => getIsp()->region,
                'controller' => $controller,
                'method' => $method,
                'request' => strlen(request('password')) > 1 ? json_encode([]) : json_encode(request()->all()),
                'is_ajax' => request()->ajax()
            );
        } else {
            $log = array(
                'url' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
                'user_agent' => getBrowser(),
                'platform' => getOS(),
                'country' => '',
                'city' => '',
                'source' => $ip,
                'name' => $name,
                'user_id' => $id,
                'region' => '',
                'controller' => $controller,
                'method' => $method,
                'request' => strlen(request('password')) > 1 ? json_encode([]) : json_encode(request()->all()),
                'is_ajax' => request()->ajax()
            );
        }
            return \DB::table('user_log')->insert($log);
    }

    function getOS() {

        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown agent';

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    function getBrowser() {

        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown agent';

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }


    function getIsp($ip = null) {
        /*  if (@file_get_contents("http://ipinfo.io/{$ip}") === FALSE) {
          $details = FALSE;
          } else {
          $json = file_get_contents("http://ipinfo.io/{$ip}");
          $details = (object) json_decode($json, true);
          } */
        return FALSE;
    }

    function getSmsCount($content) {
        if (strlen($content) >= 0 && strlen($content) <= 160) {
            RETURN 1;
        } elseif (strlen($content) > 160 && strlen($content) <= 306) {
            RETURN 2;
        } elseif (strlen($content) > 306 && strlen($content) <= 459) {
            RETURN 3;
        } elseif (strlen($content) > 459 && strlen($content) <= 612) {
            RETURN 4;
        } elseif (strlen($content) >= 612 && strlen($content) <= 765) {
            RETURN 5;
        } elseif (strlen($content) > 765 && strlen($content) <= 918) {
            RETURN 6;
        } elseif (strlen($content) > 918 && strlen($content) <= 1071) {
            RETURN 7;
        } elseif (strlen($content) > 1071 && strlen($content) <= 1224) {
            RETURN 8;
        } elseif (strlen($content) > 1224 && strlen($content) <= 1377) {
            RETURN 9;
        } elseif (strlen($content) > 1377 && strlen($content) <= 1530) {
            RETURN 10;
        }
    }

//  PHP function that finds the next multiple of 5 or 10 from a given number:
    function findNextMultiple($num) {
        // check if the number is already a multiple of 5 or 10
        if ($num % 5 == 0 || $num % 10 == 0) {
            return $num;
        }
        
        // calculate the difference between the number and the next multiple of 5 or 10
        $diff = 0;
        if ($num < 5) {
            $diff = 5 - $num;
        } else if ($num < 10) {
            $diff = 10 - $num;
        } else {
            $diff = 10 - ($num % 10);
        }
        
        // add the difference to the number to get the next multiple of 5 or 10
        $nextMultiple = $num + $diff;
        
        return $nextMultiple;
    }
    
    function split_name($name) {
        $parts = array();
    
        while ( strlen( trim($name)) > 0 ) {
            $name = trim($name);
            $string = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $parts[] = $string;
            $name = trim( preg_replace('#'.preg_quote($string,'#').'#', '', $name ) );
        }
    
        if (empty($parts)) {
            return false;
        }
    
        $parts = array_reverse($parts);
        $name = array();
        $name['first'] = $parts[0];
        $name['middle'] = (isset($parts[2])) ? $parts[1] : '';
        $name['last'] = (isset($parts[2])) ? $parts[2] : ( isset($parts[1]) ? $parts[1] : '');
    
        return $name;
    }
    
