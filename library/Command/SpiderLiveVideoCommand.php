<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SpiderLiveVideoCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('spider:livevideo')
            ->setDescription('crawl live video')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                '(LOL|Dota2)?'
            )
            ->addOption(
               'dry-run',
               null,
               InputOption::VALUE_NONE,
               'If set, only output single result, won\'t save'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;
        $this->beginToCrawl = date("Y-m-d H:i:s");
        $this->name = strtolower($input->getArgument('name'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $this->name;

        $availableFunc = array("lol"=>"crawl_lol",
                                "dota2"=>"crawl_dota2");
        if(!$availableFunc[$name])
        {   
            $this->writeBlock('Error!', 'name is invalid, should be (LOL|Dota2)', 'error');
        }else{
            call_user_func_array(array($this, $availableFunc[$name]), array($input->getOption('dry-run')));

            if(!$input->getOption('dry-run'))
            {
                $this->reloadHeap();
            }
            $this->writeBlock('Done!', 'finished successfully', 'info');
        }
    }

    protected function writeBlock($title, $content, $style="error")
    {
        $formatter = $this->getHelper('formatter');
        $errorMessages = array($title, $content);
        $formattedBlock = $formatter->formatBlock($errorMessages, $style);
        $this->output->writeln($formattedBlock);
    }

    private function mycurl($url, $ua='AppleCoreMedia/1.0.0.11D257 (iPhone; U; CPU OS 7_1_2 like Mac OS X; zh_cn)', $parm='', $timeout=10) 
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        if(!empty($parm))
        {
            curl_setopt($curl, CURLOPT_POST, 1 );
            curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($parm) ? http_build_query($parm) : $parm));
        }
        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function checkM3U8($addr) 
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $addr);
        curl_setopt($curl, CURLOPT_USERAGENT, 'AppleCoreMedia/1.0.0.11D257 (iPhone; U; CPU OS 7_1_2 like Mac OS X; zh_cn)');
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $res = $this->mycurl_redirect_exec($curl);
        curl_close($curl);
        return ($res)?true:false;
    }

    /*
     *  curl 跳转抓取
     */
    private function mycurl_redirect_exec($curl, &$redirects=0, $curlopt_returntransfer = true, $curlopt_maxredirs = 10, $curlopt_header = false) 
    {
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $exceeded_max_redirects = $curlopt_maxredirs > $redirects;
        $exist_more_redirects = false;
        if ($http_code == 301 || $http_code == 302) {
            if ($exceeded_max_redirects) {
                list($header) = explode("\r\n\r\n", $data, 2);
                $matches = array();

                preg_match('/Location: (.*)/', $header, $matches);
                $url = trim(array_pop($matches));
                $url_parsed = parse_url($url);
                if (isset($url_parsed)) {
                    curl_setopt($curl, CURLOPT_URL, $url);
                    $redirects++;
                    return $this->mycurl_redirect_exec($curl, $redirects, $curlopt_returntransfer, $curlopt_maxredirs, $curlopt_header);
                }
            } else {
                $exist_more_redirects = true;
            }
        }
        if ($data !== false) {
            if (!$curlopt_header) list(,$data) = explode("\r\n\r\n", $data, 2);
            if ($exist_more_redirects) return false;
            if ($curlopt_returntransfer) {
                return $data;
            } else {
                if (curl_errno($ch) === 0) 
                    return true;
                else
                    return false;
            }
        } else {
            return false;
        }
    }

    protected function storeInDB($data)
    {
        $em = \Yaf\Registry::get("entityManager");
        $livevideo = new \Entity\LiveVideo;
        $livevideo->setImg($data['img']);
        $livevideo->setTitle($data['title']);
        $livevideo->setSource($data['source']);
        $livevideo->setVurl($data['vurl']);
        $livevideo->setGame($this->name);
        $livevideo->setHash(md5($data['title'].$data['source']));
        $em->persist($livevideo);
        $em->flush();
    }

    protected function reloadHeap()
    {
        $this->writeBlock('reload heap', 'start '.date("Y-m-d H:i:s"), 'comment');

        $em = \Yaf\Registry::get("entityManager");
        //insert new
        $em->getConnection()->exec("REPLACE INTO live_video_run SELECT a.id, a.title, a.img, a.source, a.vurl, a.game, a.created_at, b.weight FROM live_video as a LEFT JOIN live_video_sort as b ON a.hash = b.hash WHERE game='{$this->name}' AND created_at>'{$this->beginToCrawl}';");
        //delete old
        $em->getConnection()->exec("DELETE FROM live_video_run WHERE game='{$this->name}' AND created_at<='{$this->beginToCrawl}';");
        //clean lazy table
        $em->getConnection()->exec("DELETE FROM live_video WHERE game='{$this->name}' AND created_at<='{$this->beginToCrawl}';");

        $this->writeBlock('reload heap', 'end '.date("Y-m-d H:i:s"), 'comment');
    }

    /**
     * LOL
     */
    protected function crawl_lol($dryRun)
    {
        /* douyu */
        $this->writeBlock('douyou', 'start '.date("Y-m-d H:i:s"), 'comment');
        $url = "http://api.douyutv.com/api/client/live/1?offset=0&limit=100&client_sys=ios";

        $res = $this->mycurl($url, '%E6%96%97%E9%B1%BCTV/1.03 CFNetwork/672.1.15 Darwin/14.0.0');
        $res = json_decode($res, true);
        if ($res['error'] === 0 && is_array($res['data'])) {
            foreach ($res['data'] as $key => $value) {
                $data = array();

                $data['img'] = $value["room_src"];
                $data['title'] = $value["room_name"];
                $data['source'] = 'douyutv';
                $data['vurl'] = 'http://live.e7joy.com/dyUrl/'.$value["room_id"];
                if($dryRun)
                {
                    $this->writeBlock('douyou', '', 'comment');
                    var_dump($data);break;
                }else{
                    $this->storeInDB($data);
                }
            }
        }
        $this->writeBlock('douyou', 'end '.date("Y-m-d H:i:s"), 'comment');

        /* zhanqi tv */
        $this->writeBlock('zhanqi tv', 'start '.date("Y-m-d H:i:s"), 'comment');
        $url = "http://v1.m.api.zhanqi.tv/m/room?gameId=6&page=1";

        $res = $this->mycurl($url);
        $res = json_decode($res, true);
        foreach ($res['data'] as $key => $value) {
            $data = array();
            $pImg = '';
            $pTitle = '';
            $pUrl = '';
            $pRes = null;

            $pImg = $value["spic"];
            $pTitle = $value["title"];
            $pUrl = "http://v1.m.api.zhanqi.tv/m/live?anchorId=".$value["anchorId"];
            $pRes = $this->mycurl($pUrl);
            $pRes = json_decode($pRes, true);
            if ($pRes['code'] == 0) {
                $data['img'] = $pImg;
                $data['title'] = $pTitle;
                $data['source'] = 'zhanqi';
                $data['vurl'] = $pRes['data']['room_info']['flashvars']['RtmpUrl'].'/'.$pRes['data']['room_info']['flashvars']['LiveID'];
                if ($this->checkM3U8($data['vurl'])) {
                    if($dryRun)
                    {
                        $this->writeBlock('zhanqi tv', '', 'comment');
                        var_dump($data);break;
                    }else{
                        $this->storeInDB($data);
                    }
                }
            }
        }
        $this->writeBlock('zhanqi tv', 'end '.date("Y-m-d H:i:s"), 'comment');

        /* tga plu */
        $this->writeBlock('tga plu', 'start '.date("Y-m-d H:i:s"), 'comment');
        $url = "http://api.plu.cn/tga/streams?max-results=150&game=4";

        $res = $this->mycurl($url);
        $res = json_decode($res, true);
        foreach ($res['data']['items'] as $key => $value) {
            $data = array();
            $pImg = '';
            $pTitle = '';
            $pUrl = '';
            $pRes = null;

            $pImg = $value["preview"];
            $pTitle = $value["channel"]["name"];
            $pUrl = $value["channel"]["url"];
            $pRes = $this->mycurl($pUrl);
            preg_match_all("/\"BoardCast_Address\":\"(\d+)\"/", $pRes, $cnlidArr);
            if($cnlidArr && is_array($cnlidArr) && is_array($cnlidArr[1]) && !empty($cnlidArr[1]) && $cnlidArr[1][0] != '') {
                $data['img'] = $pImg;
                $data['title'] = $pTitle;
                $data['source'] = 'tga';
                $data['vurl'] = "http://zb.v.qq.com:1863/?progid=".$cnlidArr[1][0]."&ostype=ios&rid=".md5(rand().'_'.time());
                if ($this->checkM3U8($data['vurl'])) {
                    if($dryRun)
                    {
                        $this->writeBlock('tga plu', '', 'comment');
                        var_dump($data);break;
                    }else{
                        $this->storeInDB($data);
                    }
                }
            }
        }
        $this->writeBlock('tga plu', 'end '.date("Y-m-d H:i:s"), 'comment');

        /* Twitch TV */
        $this->writeBlock('Twitch TV', 'start '.date("Y-m-d H:i:s"), 'comment');
        $url = "http://api.twitch.tv/kraken/streams?limit=10&offset=0&game=League+of+Legends&on_site=1";
        $res = $this->mycurl($url);
        $res = json_decode($res, true);
        if ($res && is_array($res)) {
            foreach ($res['streams'] as $key => $value) {
                $data = array();
                $pImg = '';
                $pTitle = '';
                $pUrl = '';
                $pRes = null;
                $rUrl = '';
                $rRes = '';

                $pImg = $value["preview"]["medium"];
                $pTitle = $value["channel"]["display_name"];
                $pUrl = "http://api.twitch.tv/api/channels/".$value["channel"]["name"]."/access_token";
                $pRes = $this->mycurl($pUrl, "Twitch 20140818 (iPhone; iPhone OS 7.1.2; zh_CN)");
                $pRes = json_decode($pRes, true);
                if ($pRes && is_array($pRes) && $pRes["token"] && $pRes["sig"]) {
                    $rUrl = "http://usher.twitch.tv/api/channel/hls/".$value["channel"]["name"].".m3u8?token=".urlencode($pRes["token"])."&sig=".$pRes["sig"];
                    if ($this->checkM3U8($rUrl)) {
                        $rRes = $this->mycurl($rUrl, "Twitch 20140818 (iPhone; iPhone OS 7.1.2; zh_CN)");
                        preg_match_all('/VIDEO\=\"medium\"(.*)\#EXT-X-MEDIA\:TYPE=VIDEO\,GROUP-ID\=\"low\"/', str_replace("\n","",$rRes), $matches);
                        if ($matches && is_array($matches) && $matches[1][0]) {
                            if ($this->checkM3U8($matches[1][0])) {
                                $data['img'] = $pImg;
                                $data['title'] = "TwitchTV-".$pTitle."-加载有点慢,耐心";
                                $data['source'] = 'twitch';
                                $data['vurl'] = urlencode($matches[1][0]);
                                if($dryRun)
                                {
                                    $this->writeBlock('Twitch TV', '', 'comment');
                                    var_dump($data);break;
                                }else{
                                    $this->storeInDB($data);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->writeBlock('Twitch TV', 'end '.date("Y-m-d H:i:s"), 'comment');
    }

    /**
     * DOTA2
     */
    protected function crawl_dota2($dryRun)
    {
        /* zhanqi tv */
        $this->writeBlock('zhangqi tv', 'start '.date("Y-m-d H:i:s"), 'comment');
        $url = "http://v1.m.api.zhanqi.tv/m/room?gameId=10&page=1";

        $res = $this->mycurl($url);
        $res = json_decode($res, true);
        foreach ($res['data'] as $key => $value) {
            $data = array();
            $pImg = '';
            $pTitle = '';
            $pUrl = '';
            $pRes = null;

            $pImg = $value["spic"];
            $pTitle = $value["title"];
            $pUrl = "http://v1.m.api.zhanqi.tv/m/live?anchorId=".$value["anchorId"];
            $pRes = $this->mycurl($pUrl);
            $pRes = json_decode($pRes, true);
            if ($pRes['code'] == 0) {
                $data['img'] = $pImg;
                $data['title'] = $pTitle;
                $data['source'] = 'zhanqi';
                $data['vurl'] = $pRes['data']['room_info']['flashvars']['RtmpUrl'].'/'.$pRes['data']['room_info']['flashvars']['LiveID'];
                if ($this->checkM3U8($data['vurl'])) {
                    if($dryRun)
                    {
                        $this->writeBlock('Twitch TV', '', 'comment');
                        var_dump($data);break;
                    }else{
                        $this->storeInDB($data);
                    }
                }
            }
        }
        $this->writeBlock('zhangqi tv', 'end '.date("Y-m-d H:i:s"), 'comment');

        /* douyu */
        $this->writeBlock('douyou', 'start '.date("Y-m-d H:i:s"), 'comment');
        $url = "http://api.douyutv.com/api/client/live/3?offset=0&limit=100&client_sys=ios";

        $res = $this->mycurl($url, '%E6%96%97%E9%B1%BCTV/1.03 CFNetwork/672.1.15 Darwin/14.0.0');
        $res = json_decode($res, true);
        if ($res['error'] === 0 && is_array($res['data'])) {
            foreach ($res['data'] as $key => $value) {
                $data = array();

                $data['img'] = $value["room_src"];
                $data['title'] = $value["room_name"];
                $data['source'] = 'douyutv';
                $data['vurl'] = 'http://live.e7joy.com/dyUrl/'.$value["room_id"];
                if($dryRun)
                {
                    $this->writeBlock('Twitch TV', '', 'comment');
                    var_dump($data);break;
                }else{
                    $this->storeInDB($data);
                }
            }
        }
        $this->writeBlock('douyou', 'end '.date("Y-m-d H:i:s"), 'comment');
    }
}