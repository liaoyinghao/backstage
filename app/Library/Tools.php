<?php
namespace App\Library;
/**
 *
 */
class Tools
{

    function __construct()
    {
        # code...
    }


    //异步获取远程微信图片存入本地
    //@target    目标图片
    //@local      本地存储图片
    //savePic()
    public static function curlGetPic($target,$local){
        $curl = new \Curl\Curl();
        $curl_data['target']=$target;
        $curl_data['local']=$local;
        $curl->setOpt(CURLOPT_TIMEOUT,1);
        $curl->setOpt(CURLOPT_NOSIGNAL,1);//毫秒起效
        $curl->setOpt(CURLOPT_CONNECTTIMEOUT_MS,100);
        $curl->get(route('h5_process_save_pic'), $curl_data);
        $curl->close();
    }


    //坐标转换
    public static function gpsToGoogle($x='',$y=''){

        $host = "http://aliapi.updust.com";
        $path = "/geoconv";
        $method = "GET";
        $appcode = "365657eb9a74482c9f0f9ce31e7300a0";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "from=gps&lat=".$x."&lng=".$y."&to=google";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }

        return json_decode(curl_exec($curl));

    }



    /**
    * 计算两点地理坐标之间的距离
    * @param  Decimal $longitude1 起点经度
    * @param  Decimal $latitude1  起点纬度
    * @param  Decimal $longitude2 终点经度
    * @param  Decimal $latitude2  终点纬度
    * @param  Int     $unit       单位 1:米 2:公里
    * @param  Int     $decimal    精度 保留小数位数
    * @return Decimal
    */
    function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926;

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI /180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if($unit==2){
        $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }

// // 起点坐标
// $longitude1 = 113.330405;
// $latitude1 = 23.147255;
//
// // 终点坐标
// $longitude2 = 113.314271;
// $latitude2 = 23.1323;
//
// $distance = getDistance($longitude1, $latitude1, $longitude2, $latitude2, 1);
// echo $distance.'m'; // 2342.38m
//
// $distance = getDistance($longitude1, $latitude1, $longitude2, $latitude2, 2);
// echo $distance.'km'; // 2.34km

    /**
    * 全局qrcode生成
    * @param  Array $param 配置项
    * @param  Int $type  0百度api 1标准模式 2名片模式
    * @param  Bool $debug 调试开关
    */

    public static function dqr($param,$type=1,$debug=false){
        if($type==0){
            return '<img src="http://pan.baidu.com/share/qrcode?w=300&h=300&url='.$param['str'].'">';
        }

        $origin['format']='png';            //PNG，EPS，SVG
        $origin['size']=500;
        $origin['margin']=1;
        $origin['encoding']='UTF-8';
        $origin['color']=[0,0,0];
        $origin['backgroundColor']=[255,255,255];
        $origin['str']=request()->url();
        $origin=array_merge($origin,$param);
        $init=\QrCode::format($origin['format'])
                    ->size($origin['size'])
                    ->color($origin['color'][0],$origin['color'][1],$origin['color'][2])
                    ->backgroundColor($origin['backgroundColor'][0],$origin['backgroundColor'][1],$origin['backgroundColor'][2])
                    ->margin($origin['margin'])
                    ->encoding($origin['encoding'])
                    ->generate($origin['str']);
                    // dd($init);
        $img=base64_encode($init);
        $data_str=($debug)?$origin['str']:'';
        // return "data:image/png;base64,'.$img.'";
        return '<img src="data:image/png;base64,'.$img.'" data-str="'.$data_str.'">';
    }

    public static function downloaddqr($param,$type=1,$debug=false,$imgName,$exec_id){
        if($type==0){
            return '<img src="http://pan.baidu.com/share/qrcode?w=300&h=300&url='.$param['str'].'">';
        }

        $dirPath = public_path("uploads/exec/".$exec_id);



        if (!is_dir($dirPath)){
            @mkdir($dirPath,0777,true);
        }

        $origin['format']='png';            //PNG，EPS，SVG
        $origin['size']=300;
        $origin['margin']=1;
        $origin['encoding']='UTF-8';
        $origin['color']=[0,0,0];
        $origin['backgroundColor']=[255,255,255];
        $origin['str']=request()->url();
        $origin=array_merge($origin,$param);
        $init=\QrCode::format($origin['format'])
                    ->size($origin['size'])
                    ->color($origin['color'][0],$origin['color'][1],$origin['color'][2])
                    ->backgroundColor($origin['backgroundColor'][0],$origin['backgroundColor'][1],$origin['backgroundColor'][2])
                    ->margin($origin['margin'])
                    ->encoding($origin['encoding'])
                    ->generate($origin['str'],$dirPath."/".$imgName.".png");
                    // dd($init);
        $img=base64_encode($init);
        $data_str=($debug)?$origin['str']:'';
        // return "data:image/png;base64,'.$img.'";
        return '<img src="data:image/png;base64,'.$img.'" data-str="'.$data_str.'">';
    }

    public static function downloaddqrs($param,$type=1,$debug=false,$imgName,$exec_id){

        if($type==0){
            return '<img src="http://pan.baidu.com/share/qrcode?w=300&h=300&url='.$param['str'].'">';
        }

        $dirPath = public_path("uploads/m/".$exec_id);
        if (!is_dir($dirPath)){
            @mkdir($dirPath,0777,true);
        }

        $origin['format']='png';            //PNG，EPS，SVG
        $origin['size']=300;
        $origin['margin']=4;
        $origin['encoding']='UTF-8';
        $origin['color']=[0,0,0];
        $origin['backgroundColor']=[255,255,255];
        $origin['str']=request()->url();
        $origin=array_merge($origin,$param);
        $init=\QrCode::format($origin['format'])
                    ->size($origin['size'])
                    ->color($origin['color'][0],$origin['color'][1],$origin['color'][2])
                    ->backgroundColor($origin['backgroundColor'][0],$origin['backgroundColor'][1],$origin['backgroundColor'][2])
                    ->margin($origin['margin'])
                    ->encoding($origin['encoding'])
                    ->generate($origin['str'],$dirPath."/".$imgName.".png");

        $imgurl = $dirPath."/".$imgName.".png";
        $a = self::jiawenzi($imgurl,$imgName);

        $img=base64_encode($init);
        $data_str=($debug)?$origin['str']:'';
        return '<img src="data:image/png;base64,'.$img.'" data-str="'.$data_str.'">';
    }

    public static function jiawenzi($imgurl,$bianhao){
        $bianhao = "No.".$bianhao;
        $dst_path = $imgurl;
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = '/simsunb.ttf';//字体路径
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 15, 0, 105, 290, $black, $font, $bianhao);
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagegif($dst,$imgurl);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagejpeg($dst,$imgurl);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst,$imgurl);
                break;
            default:
                break;
        }
        imagedestroy($dst);
    }

    public static function getip(){
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }

    public static function getIPLoc_sina($ip){
        $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
        $ip=json_decode(file_get_contents($url));
        if((string)$ip->code=='1'){
           return false;
        }
        $loc = $ip->data->city;
        if(mb_strlen($loc,'utf-8')>2){
          $str = mb_substr($loc, 0, -1,'utf-8');
        }
        return $str;
    }

    /**
    * 全局图片压缩
    * @param  varchar $imgsrc 图片路径
    * @param  varchar $imgdst 压缩后保存路径
    */

    public static function compressed_image($imgsrc,$imgdst){
        list($width,$height,$type)=getimagesize($imgsrc);
        $new_width = ($width>600?600:$width)*0.9;
        $new_height =($height>600?600:$height)*0.9;
        switch($type){
          case 1:
            $giftype=check_gifcartoon($imgsrc);
            if($giftype){
              header('Content-Type:image/gif');
              $image_wp=imagecreatetruecolor($new_width, $new_height);
              $image = imagecreatefromgif($imgsrc);
              imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
              //75代表的是质量、压缩图片容量大小
              imagejpeg($image_wp, $imgdst,75);
              imagedestroy($image_wp);
            }
            break;
          case 2:
            header('Content-Type:image/jpeg');
            $image_wp=imagecreatetruecolor($new_width, $new_height);
            $image = imagecreatefromjpeg($imgsrc);
            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            //75代表的是质量、压缩图片容量大小
            imagejpeg($image_wp, $imgdst,75);
            imagedestroy($image_wp);
            break;
          case 3:
            header('Content-Type:image/png');
            $image_wp=imagecreatetruecolor($new_width, $new_height);
            $image = imagecreatefrompng($imgsrc);
            imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            //75代表的是质量、压缩图片容量大小
            imagejpeg($image_wp, $imgdst,75);
            imagedestroy($image_wp);
            break;
        }
    }

}


?>
