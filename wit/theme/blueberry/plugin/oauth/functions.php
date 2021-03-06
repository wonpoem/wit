<?php

function get_oauth_member_info($no, $nick, $service)
{
    if(!$no || !$service)
        return '';

    $id   = '';
    $str  = '';
    $info = array();

    if(strlen($no) > 16)
        $no = str_baseconvert($no);

    switch($service) {
        case 'naver':
            $str = 'nid';
            break;
        case 'kakao':
            $str = 'kko';
            break;
        case 'facebook':
            $str = 'fcb';
            break;
        case 'google':
            $str = 'ggl';
            break;
        default:
            alert('올바르게 이용해 주십시오.');
            break;
    }

    if($str)
        $id = $str.'-'.$no;

    $pass = get_encrypt_string(rand(1, 999).$no);
    $nick = 'sns-'.$nick;

    $info = array('id' => $id, 'pass' => $pass, 'nick' => $nick);

    return $info;
}

function alert_opener_url($msg='', $url=G5_URL)
{
    $url = str_replace('&amp;', '&', $url);
    $url = preg_replace("/[\<\>\'\"\\\'\\\"\(\)]/", "", $url);

    // url 체크
    check_url_host($url);

    echo '<script>'.PHP_EOL;
    if(trim($msg))
        echo 'alert("'.$msg.'");'.PHP_EOL;
    echo 'window.opener.location.href = "'.$url.'";'.PHP_EOL;
    echo 'window.close();'.PHP_EOL;
    echo '</script>';
    exit;
}

// http://php.net/manual/kr/function.base-convert.php#109660
function str_baseconvert($str, $frombase=10, $tobase=36)
{
    $str = trim($str);
    if (intval($frombase) != 10) {
        $len = strlen($str);
        $q = 0;
        for ($i=0; $i<$len; $i++) {
            $r = base_convert($str[$i], $frombase, 10);
            $q = bcadd(bcmul($q, $frombase), $r);
        }
    }
    else $q = $str;

    if (intval($tobase) != 10) {
        $s = '';
        while (bccomp($q, '0', 0) > 0) {
            $r = intval(bcmod($q, $tobase));
            $s = base_convert($r, 10, $tobase) . $s;
            $q = bcdiv($q, $tobase, 0);
        }
    }
    else $s = $q;

    return $s;
}
?>