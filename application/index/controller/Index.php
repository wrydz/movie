<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    /*
     * 加载首页时，请求首页数据
     *
     */
    public function homePageData()
    {
        // 4大类别
        $films = Db::query('select * from video_film_info limit 8');
        $teleplays = Db::query('select * from video_teleplay_info where volume_num = ?',[1]);
        $cartoons = Db::query('select * from video_cartoon_info where volume_num = ?', [1]);
        $games = Db::query('select * from video_game_info limit 8');

        $data = [
            'films'=>$films,
            'teleplays'=>$teleplays,
            'cartoons'=>$cartoons,
            'games'=>$games
        ];

        // 跨域访问
        header("access-control-allow-origin:*");
        echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}
