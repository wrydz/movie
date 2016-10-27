<?php
namespace app\admin\controller;
use think\Controller;


class Game extends Controller
{
    public function lst()
    {
        $games= \think\Db::name('game_info')->order('id asc')->select();
        $this->assign('games',$games);
        return $this->fetch();
    }


    public function add()
    {
        if(request()->isPost()){
            $data=[
                'video_name'=>input('video_name'),
                'director'=>input('director'),
                'roles'=>input('roles'),
                'area'=>input('area'),
                'start_time'=>input('start_time'),
                'kind_name'=>input('kind_name'),
                'suffix'=>input('suffix'),
                'link'=>input('link'),
                'src_type'=>input('src_type'),
                'intro'=>input('intro'),
            ];

            // 上传图片
            if($_FILES['cover_img']['tmp_name']){
                $file = request()->file('cover_img');
                $info = $file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'/static/video_imgs/game');
                if($info){
                    $data['cover_img'] = 'static/video_imgs/game/'.$info->getFilename();
                }else{
                    echo $info->getError();
                }
            }

            // 验证数据
            $validate = \think\Loader::validate('GameInfo');
            if($validate->check($data)){
                // 获取自增ID
                // $data['id'] = getAutoId(1);
                $db= \think\Db::name('game_info')->insert($data);
                if($db){
                    return $this->success('添加游戏视频成功！','lst');
                }else{
                    unlink($info->getRealPath());
                    return $this->error('添加游戏视频失败！');
                }
            }else{
                unlink($info->getRealPath());
                return $this->error($validate->getError());
            }
            return;
        }
        return $this->fetch();
    }

    public function edit(){
        if(request()->isPost()){
            $data=[
                'id'=>input('id'),
                'video_name'=>input('video_name'),
                'director'=>input('director'),
                'roles'=>input('roles'),
                'area'=>input('area'),
                'start_time'=>input('start_time'),
                'kind_name'=>input('kind_name'),
                'suffix'=>input('suffix'),
                'link'=>input('link'),
                'cover_img'=>input('old_cover_img'),
                'src_type'=>input('src_type'),
                'intro'=>input('intro'),
            ];

            // 判断图片是否重新上传
            $again_flag = 0;
            if($_FILES['cover_img']['tmp_name']){
                $file = request()->file('cover_img');
                $info = $file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'/static/video_imgs/game');
                if($info){
                    $again_flag = 1;
                    $data['cover_img'] = 'static/video_imgs/game/'.$info->getFilename();
                }else{
                    echo $info->getError();
                }
            }

            // 验证数据
            $validate = \think\Loader::validate('GameInfo');
            if($validate->check($data)){
                // 更新数据库
                $db=\think\Db::name('game_info')->where('id',$data['id'])->update($data);
                if($db){
                    // 删除之前的图片文件
                    if($again_flag && file_exists(ROOT_PATH.'public/'.input('old_cover_img'))){
                        unlink(ROOT_PATH.'public/'.input('old_cover_img'));
                    }
                    return $this->success('修改游戏视频成功！','lst');
                }else{
                    if($again_flag){
                        unlink($info->getRealPath());
                    }
                    return $this->error('修改游戏视频失败！');
                }
            }else{
                if($again_flag){
                    unlink($info->getRealPath());
                }
                return $this->error($validate->getError());
            }
            return;
        }

        $id=input('id');
        $games=db('game_info')->where('id',$id)->find();
        $this->assign('games',$games);
        return $this->fetch();

    }

    public function del(){
        $id=input('id');
        $data = db('game_info')->where('id', $id)->column('cover_img');
        if(db('game_info')->delete($id)){
            if(file_exists(ROOT_PATH.'public/'.$data[0])){
                unlink(ROOT_PATH.'public/'.$data[0]);
            }
            return $this->success('删除游戏视频成功！','lst');
        }else{
            return $this->error('删除游戏视频失败！');
        }
    }
}
