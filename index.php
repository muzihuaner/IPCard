<?php

class App
{
    /*高德地图开发者key*/
    private $key = 'c6f191bab17453c6571eab1c63430595';
    /*是否允许空refer，0为不允许，1为允许*/
    public $referopen = "1";
    /**路径 */
    private $path = __DIR__ . "/";

    // 浏览器信息
    public $browser = null;
    // 系统信息
    public $os = null;
    // 访问者IP
    public $ip = null;
    // 城市代码
    public $adcode = null;
    // 天气
    public $weather = null;
    // 图片
    public $drawIm = null;
    // 先定义一个数组
    public $weekarray = array("日", "一", "二", "三", "四", "五", "六");
    // 城市
    public $city = "";
    // 省份
    public $province = "";


    // 初始化
    public function init()
    {
        // 获取浏览器信息
        $this->browser = $this->getBrowser();
        // 获取系统信息
        $this->os = $this->getOs();
        // 访问者IP
        $this->ip = $_SERVER["REMOTE_ADDR"];
        // $this->ip = '222.216.222.168';
        // 获取访问者信息
        $this->getAddress();
        // 绘制图片
        $this->picInit()->setWeather()->setIcon()->setInfo();
        // 
        return $this;
    }

    /**
     * 设置信息
     */
    public function setInfo()
    {
        /*基本项文字位置*/
        //标语
        $by_text = ""; //文字标语
        $by_size = "12"; //文字大小
        $by_angle = "0"; //角度
        $by_x = "60";
        $by_y = "45";
        $by_font = $this->path . "font/msyh.ttf"; //字体位置
        $by_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        //自定义文字
        $diy_size = "20"; //文字大小
        $diy_angle = "0"; //角度
        $diy_x = "125";
        $diy_y = "45";
        $diy_font = $this->path . "font/msyh.ttf"; //字体位置
        $diy_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        //日期
        $time_size = "10"; //文字大小
        $time_angle = "0"; //角度
        $time_x = "167";
        $time_y = "194";
        $time_font = $this->path . "font/msyh.ttf"; //字体位置
        $time_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        //位置
        $local_size = "10"; //文字大小
        $local_angle = "0"; //角度
        $local_x = "165";
        $local_y = "212";
        $local_font = $this->path . "font/msyh.ttf"; //字体位置
        $local_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        //IP
        $ip_size = "10"; //文字大小
        $ip_angle = "0"; //角度
        $ip_x = "165";
        $ip_y = "232";
        $ip_font = $this->path . "font/msyh.ttf"; //字体位置
        $ip_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        //系统
        $system_size = "10"; //文字大小
        $system_angle = "0"; //角度
        $system_x = "278";
        $system_y = "212";
        $system_font = $this->path . "font/msyh.ttf"; //字体位置
        $system_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        //浏览器
        $bro_size = "10"; //文字大小
        $bro_angle = "0"; //角度
        $bro_x = "278";
        $bro_y = "232";
        $bro_font = $this->path . "font/msyh.ttf"; //字体位置
        $bro_color = imagecolorallocate($this->drawIm, 0, 51, 78); //这里可以自定义自己需要的颜色，但需要转为RGB值，可将0,51,78修改为自己需要的颜色的RGB值
        imagettftext($this->drawIm, $time_size, $time_angle, $time_x, $time_y, $time_color, $time_font, date('Y年n月j日') . " 星期" . $this->weekarray[date("w")]);
        imagettftext($this->drawIm, $local_size, $local_angle, $local_x, $local_y, $local_color, $local_font, $this->province . '-' . $this->city);
        imagettftext($this->drawIm, $by_size, $by_angle, $by_x, $by_y, $by_color, $by_font, $by_text); //标语添加到图片
        $_diy = isset($_GET["diy"]) ? $_GET["diy"] : "";
        imagettftext($this->drawIm, $diy_size, $diy_angle, $diy_x, $diy_y, $diy_color, $diy_font, base64_decode($_diy)); //自定义文字添加到图片
        imagettftext($this->drawIm, $ip_size, $ip_angle, $ip_x, $ip_y, $ip_color, $ip_font, $this->ip); //IP添加到图片
        imagettftext($this->drawIm, $system_size, $system_angle, $system_x, $system_y, $system_color, $system_font, $this->os); //系统添加到图片
        imagettftext($this->drawIm, $bro_size, $bro_angle, $bro_x, $bro_y, $bro_color, $bro_font, $this->browser); //浏览器添加到图片

        return $this;
    }

    /**
     * 初始化画布
     */
    public function picInit()
    {
        //背景图片名称（名称.格式，如"bg.png"）
        $dst_path = $this->path . 'img/bg.png';
        //传递背景图片
        $this->drawIm = imagecreatefromstring(file_get_contents($dst_path));
        return $this;
    }

    /**
     * 绘制天气部分
     */
    public function setWeather()
    {
        /*基本图标位置*/
        //天气图标位置
        $weather_icon_x = "65";
        $weather_icon_y = "50";
        //天气图标
        $sunny_path = $this->path . 'icon/weather/sunny.png';
        $sunny_im = imagecreatefromstring(file_get_contents($sunny_path));
        list($sunny_w, $sunny_h) = getimagesize($sunny_path);
        $rain_path = $this->path . 'icon/weather/rain.png';
        $rain_im = imagecreatefromstring(file_get_contents($rain_path));
        list($rain_w, $rain_h) = getimagesize($rain_path);
        $snow_path = $this->path . 'icon/weather/snow.png';
        $snow_im = imagecreatefromstring(file_get_contents($snow_path));
        list($snow_w, $snow_h) = getimagesize($snow_path);
        $sha_path = $this->path . 'icon/weather/sha.png';
        $sha_im = imagecreatefromstring(file_get_contents($sha_path));
        list($sha_w, $sha_h) = getimagesize($sha_path);
        $wu_path = $this->path . 'icon/weather/wu.png';
        $wu_im = imagecreatefromstring(file_get_contents($wu_path));
        list($wu_w, $wu_h) = getimagesize($wu_path);
        $yin_path = $this->path . 'icon/weather/yin.png';
        $yin_im = imagecreatefromstring(file_get_contents($yin_path));
        list($yin_w, $yin_h) = getimagesize($yin_path);
        $dyun_path = $this->path . 'icon/weather/dyun.png';
        $dyun_im = imagecreatefromstring(file_get_contents($dyun_path));
        list($dyun_w, $dyun_h) = getimagesize($dyun_path);
        $unknow_path = $this->path . 'icon/weather/unknow.png';
        $unknow_im = imagecreatefromstring(file_get_contents($unknow_path));
        list($unknow_w, $unknow_h) = getimagesize($unknow_path);
        // 判断天气
        if (strpos($this->weather['weather'], '晴') !== false) {
            imagecopy($this->drawIm, $sunny_im, $weather_icon_x, $weather_icon_y, 0, 0, $sunny_w, $sunny_h);
        } elseif (strpos($this->weather['weather'], '云') !== false) {
            imagecopy($this->drawIm, $dyun_im, $weather_icon_x, $weather_icon_y, 0, 0, $dyun_w, $dyun_h);
        } elseif (strpos($this->weather['weather'], '阴') !== false) {
            imagecopy($this->drawIm, $yin_im, $weather_icon_x, $weather_icon_y, 0, 0, $yin_w, $yin_h);
        } elseif (strpos($this->weather['weather'], '雾') !== false) {
            imagecopy($this->drawIm, $wu_im, $weather_icon_x, $weather_icon_y, 0, 0, $wu_w, $wu_h);
        } elseif (strpos($this->weather['weather'], '雨') !== false) {
            imagecopy($this->drawIm, $rain_im, $weather_icon_x, $weather_icon_y, 0, 0, $rain_w, $rain_h);
        } elseif (strpos($this->weather['weather'], '雪') !== false) {
            imagecopy($this->drawIm, $snow_im, $weather_icon_x, $weather_icon_y, 0, 0, $snow_w, $snow_h);
        } elseif (strpos($this->weather['weather'], '风') !== false) {
            imagecopy($this->drawIm, $sha_im, $weather_icon_x, $weather_icon_y, 0, 0, $sha_w, $sha_h);
        } else {
            imagecopy($this->drawIm, $unknow_im, $weather_icon_x, $weather_icon_y, 0, 0, $unknow_w, $unknow_h);
        }

        imagettftext($this->drawIm, 14, 0, 95, 140, imagecolorallocate($this->drawIm, 0, 51, 78), $this->path . "font/msyh.ttf", $this->weather['weather']); //今天天气添加到图片
        imagettftext($this->drawIm, 13, 0, 160, 90, imagecolorallocate($this->drawIm, 0, 51, 78), $this->path . "font/msyh.ttf", '温度:' .  $this->weather['temp'] . '℃'); //当前温度添加到图片
        imagettftext($this->drawIm, 13, 0, 237, 90, imagecolorallocate($this->drawIm, 0, 51, 78), $this->path . "font/msyh.ttf", '湿度:' .  $this->weather['humidity'] . '%RH'); //当前湿度添加到图片
        imagettftext($this->drawIm, 11, 0, 160, 115, imagecolorallocate($this->drawIm, 0, 51, 78), $this->path .  "font/msyh.ttf", '风向:' .  $this->weather['winddirection'] . '方'); //当前风向添加到图片
        imagettftext($this->drawIm, 11, 0, 237, 115, imagecolorallocate($this->drawIm, 0, 51, 78), $this->path . "font/msyh.ttf", '风力级别:' . $this->weather['windpower'] . '级'); //风力级别添加到图片
        imagettftext($this->drawIm, 11, 0, 160, 135, imagecolorallocate($this->drawIm, 0, 51, 78), $this->path . "font/msyh.ttf", '更新时间:' . $this->weather['reporttime']); //更新时间添加到图片

        return $this;
    }

    /**
     * 绘制ICON
     */
    public function setIcon()
    {
        //ip图标位置
        $ip_icon_x = "150";
        $ip_icon_y = "220";
        //时间图标位置
        $time_icon_x = "150";
        $time_icon_y = "180";
        //位置图标位置
        $local_icon_x = "150";
        $local_icon_y = "200";
        //系统图标位置
        $system_icon_x = "260";
        $system_icon_y = "200";
        //浏览器图标位置
        $bro_icon_x = "260";
        $bro_icon_y = "220";
        //IP等图标
        $ip_path = $this->path . 'icon/ico/IP.png';
        $ip_im = imagecreatefromstring(file_get_contents($ip_path));
        list($ip_w, $ip_h) = getimagesize($ip_path);
        $time_path = $this->path . 'icon/ico/time.png';
        $time_im = imagecreatefromstring(file_get_contents($time_path));
        list($time_w, $time_h) = getimagesize($time_path);
        $local_path = $this->path . 'icon/ico/local.png';
        $local_im = imagecreatefromstring(file_get_contents($local_path));
        list($local_w, $local_h) = getimagesize($local_path);
        $system_path = $this->path . 'icon/ico/system.png';
        $system_im = imagecreatefromstring(file_get_contents($system_path));
        list($system_w, $system_h) = getimagesize($system_path);
        $bro_path = $this->path . 'icon/ico/bro.png';
        $bro_im = imagecreatefromstring(file_get_contents($bro_path));
        list($bro_w, $bro_h) = getimagesize($bro_path);

        //各图标位置
        imagecopy($this->drawIm, $ip_im, $ip_icon_x, $ip_icon_y, 0, 0, $ip_w, $ip_h);
        imagecopy($this->drawIm, $time_im, $time_icon_x, $time_icon_y, 0, 0, $time_w, $time_h);
        imagecopy($this->drawIm, $local_im, $local_icon_x, $local_icon_y, 0, 0, $local_w, $local_h);
        imagecopy($this->drawIm, $system_im, $system_icon_x, $system_icon_y, 0, 0, $system_w, $system_h);
        imagecopy($this->drawIm, $bro_im, $bro_icon_x, $bro_icon_y, 0, 0, $bro_w, $bro_h);

        return $this;
    }



    /**
     * 合成输出图片
     */
    public function suture()
    {
        header("Content-type: image/JPEG");

        //输出
        imagegif($this->drawIm);
        imagedestroy($this->drawIm);
    }

    /**
     * 获取IP及城市代码
     */
    public function getAddress()
    {
        //获取IP及城市代码
        $url = "http://restapi.amap.com/v3/ip?key=" . $this->key . "&ip=" . $this->ip;
        $UserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($curl);
        $data = json_decode($data, true);
        $this->province = isset($data['province']) ? $data['province'] : "未知"; //省
        $this->city = isset($data['city']) ? $data['city'] : "未知"; //市
        $this->adcode = isset($data['adcode']) ? $data['adcode'] : ""; //城市代码
        // 不为空获取天气信息
        if ($this->adcode) {
            $this->getWeather();
        }
        // 
        return $this;
    }

    /**
     * 获取天气信息
     */
    public function getWeather()
    {
        //获取天气信息
        $tqurl = "http://restapi.amap.com/v3/weather/weatherInfo?key=" . $this->key . "&city=" . $this->adcode;
        $UserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $tqurl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $weatherinfo = curl_exec($curl);
        $weatherinfo = json_decode($weatherinfo, true);
        $this->weather['weather'] = $weatherinfo['lives']['0']['weather']; //天气
        $this->weather['temp'] = $weatherinfo['lives']['0']['temperature']; //温度
        $this->weather['humidity'] = $weatherinfo['lives']['0']['humidity']; //湿度
        $this->weather['winddirection'] = $weatherinfo['lives']['0']['winddirection']; //风向
        $this->weather['windpower'] = $weatherinfo['lives']['0']['windpower']; //风力级别
        $this->weather['reporttime'] = $weatherinfo['lives']['0']['reporttime']; //更新时间
        // 
        return $this;
    }

    /**
     * 获取浏览器信息
     */
    public function getBrowser()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串  
        if (preg_match('#(Camino|Chimera)[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Camino(' . $matches[2] . ')';
        } elseif (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = '搜狗(' . $matches[1] . ')';
        } elseif (preg_match('#360([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = '360(' . $matches[1] . ')';
        } elseif (preg_match('#QQ/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'QQ(' . $matches[1] . ')内置';
        } elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Maxthon(' . $matches[2] . ')';
        } elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Chrome(' . $matches[1] . ')';
        } elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Safari(' . $matches[1] . ')';
        } elseif (preg_match('#opera mini#i', $ua)) {
            $browser = 'Opera Mini(' . $matches[1] . ')';
        } elseif (preg_match('#Opera.([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Opera(' . $matches[1] . ')';
        } elseif (preg_match('#(j2me|midp)#i', $ua)) {
            $browser = "J2ME/MIDP Browser";
        } elseif (preg_match('/GreenBrowser/i', $ua)) {
            $browser = 'GreenBrowser';
        } elseif (preg_match('#TencentTraveler ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = '腾讯TT(' . $matches[1] . ')';
        } elseif (preg_match('#UCWEB([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'UCWEB(' . $matches[1];
        } elseif (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Internet Explorer(' . $matches[1] . ')';
        } elseif (preg_match('#avantbrowser.com#i', $ua)) {
            $browser = 'Avant Browser';
        } elseif (preg_match('#PHP#', $ua, $matches)) {
            $browser = 'PHP';
        } elseif (preg_match('#danger hiptop#i', $ua, $matches)) {
            $browser = 'Danger HipTop';
        } elseif (preg_match('#Shiira[/]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Shiira(' . $matches[1] . ')';
        } elseif (preg_match('#Dillo[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Dillo(' . $matches[1] . ')';
        } elseif (preg_match('#Epiphany/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Epiphany(' . $matches[1] . ')';
        } elseif (preg_match('#UP.Browser/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Openwave UP.Browser (' . $matches[1] . ')';
        } elseif (preg_match('#DoCoMo/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'DoCoMo(' . $matches[1] . ')';
        } elseif (preg_match('#(Firefox|Phoenix|Firebird|BonEcho|GranParadiso|Minefield|Iceweasel)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Firefox(' . $matches[2] . ')';
        } elseif (preg_match('#(SeaMonkey)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Mozilla SeaMonkey(' . $matches[2] . ')';
        } elseif (preg_match('#Kazehakase/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $browser = 'Kazehakase(' . $matches[1] . ')';
        } else {
            $browser = '未知';
        }
        return $browser;
    }

    /**
     * 获取系统信息
     */
    public function getOs()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $os = false;
        if (preg_match('/Windows 95/i', $ua) || preg_match('/Win95/', $ua)) {
            $os = "Windows 95";
        } elseif (preg_match('/Windows NT 5.0/i', $ua) || preg_match('/Windows 2000/i', $ua)) {
            $os = "Windows 2000";
        } elseif (preg_match('/Win 9x 4.90/i', $ua) || preg_match('/Windows ME/i', $ua)) {
            $os = "Windows ME";
        } elseif (preg_match('/Windows.98/i', $ua) || preg_match('/Win98/i', $ua)) {
            $os = "Windows 98";
        } elseif (preg_match('/Windows NT 6.0/i', $ua)) {
            $os = "Windows Vista";
        } elseif (preg_match('/Windows NT 6.1/i', $ua)) {
            $os = "Windows 7";
        } elseif (preg_match('/Windows NT 5.1/i', $ua)) {
            $os = "Windows XP";
        } elseif (preg_match('/Windows NT 5.2/i', $ua) && preg_match('/Win64/i', $ua)) {
            $os = "Windows XP 64 bit";
        } elseif (preg_match('/Windows NT 5.2/i', $ua)) {
            $os = "Windows Server 2003";
        } elseif (preg_match('/Mac_PowerPC/i', $ua)) {
            $os = "Mac OS";
        } elseif (preg_match('/Windows Phone/i', $ua)) {
            $os = "Windows Phone7";
        } elseif (preg_match('/Windows NT 6.2/i', $ua)) {
            $os = "Windows 8";
        } elseif (preg_match('/Windows NT 10.0/i', $ua)) {
            $os = "Windows 10";
        } elseif (preg_match('/Windows NT 4.0/i', $ua) || preg_match('/WinNT4.0/i', $ua)) {
            $os = "Windows NT 4.0";
        } elseif (preg_match('/Windows NT/i', $ua) || preg_match('/WinNT/i', $ua)) {
            $os = "Windows NT";
        } elseif (preg_match('/Windows CE/i', $ua)) {
            $os = "Windows CE";
        } elseif (preg_match('/ipad/i', $ua)) {
            if (preg_match("/(?<=CPU OS )[\d\_]{1,}/", $ua, $version)) {
                $ver = str_replace('_', '.', $version[0]);
                $os = "IOS(" . $ver . ")";
            } else {
                $os = "IOS";
            }
        } elseif (preg_match('/Touch/i', $ua)) {
            $os = "Touchw";
        } elseif (preg_match('/Symbian/i', $ua) || preg_match('/SymbOS/i', $ua)) {
            $os = "Symbian OS";
        } elseif (preg_match('/iPhone/i', $ua)) {
            if (preg_match("/(?<=CPU iPhone OS )[\d\_]{1,}/", $ua, $version)) {
                $ver = str_replace('_', '.', $version[0]);
                $os = "IOS(" . $ver . ")";
            } else {
                $os = "IOS";
            }
        } elseif (preg_match('/PalmOS/i', $ua)) {
            $os = "Palm OS";
        } elseif (preg_match('/QtEmbedded/i', $ua)) {
            $os = "Qtopia";
        } elseif (preg_match('/Ubuntu/i', $ua)) {
            $os = "Ubuntu Linux";
        } elseif (preg_match('/Gentoo/i', $ua)) {
            $os = "Gentoo Linux";
        } elseif (preg_match('/Fedora/i', $ua)) {
            $os = "Fedora Linux";
        } elseif (preg_match('/FreeBSD/i', $ua)) {
            $os = "FreeBSD";
        } elseif (preg_match('/NetBSD/i', $ua)) {
            $os = "NetBSD";
        } elseif (preg_match('/OpenBSD/i', $ua)) {
            $os = "OpenBSD";
        } elseif (preg_match('/SunOS/i', $ua)) {
            $os = "SunOS";
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
            if (preg_match('/Android.([0-9. _]+)/i', $ua, $matches)) {
                $os = 'Android(' . $matches[1] . ')';
            } elseif (preg_match('#Ubuntu#i', $ua)) {
                $os = 'Ubuntu';
            } elseif (preg_match('#Debian#i', $ua)) {
                $os = 'Debian';
            } elseif (preg_match('#Fedora#i', $ua)) {
                $os = 'Fedora';
            }
        } elseif (preg_match('/Mac OS X/i', $ua)) {
            $os = "Mac OS X";
        } elseif (preg_match('/Macintosh/i', $ua)) {
            $os = "Mac OS";
        } elseif (preg_match('/Unix/i', $ua)) {
            $os = "Unix";
        } elseif (preg_match('#Nokia([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $os = "Nokia" . $matches[1];
        } elseif (preg_match('/Mac OS X/i', $ua)) {
            $os = "Mac OS X";
        } else {
            $os = '未知';
        }
        return $os;
    }
}

// 执行
$app = new App();

if (empty($app->referopen)) {
    die("配置错误！");
} else if ($app->referopen == 0) {
    if (empty($_SERVER['HTTP_REFERER'])) {
        die("请勿直接访问！");
    }
} else if ($app->referopen == 1) {
    $app->init()->suture();
} else {
    die("未知错误！");
}
