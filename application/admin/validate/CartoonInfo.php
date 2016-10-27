<?php
namespace app\admin\validate;

use think\Validate;

class CartoonInfo extends Validate
{
    protected $rule = [
        'video_name' => 'require',
        'volume_num' => 'number',
        'volume_name' => 'require',
        'director' => 'require',
        'roles' => 'require',
        'area' => 'require',
        'start_time' => 'require',
        'kind_name' => 'require',
        'cover_img' => 'require',
        'link'  => 'require',
    ];

    protected $message = [
        'video_name.require'  => '电视剧名称不能为空',
        'volume_num.number' => '电视剧剧集只能是数字',
        'volume_name.require' => '剧集名称不能为空',
        'director.require' => '导演不能为空',
        'roles.require' => '演员不能为空',
        'area.require' => '地区不能为空',
        'start_time.require' => '上映时间不能为空',
        'kind_name.require' => '电视剧类型不能为空',
        'cover_img.require' => '电视剧封面不能为空',
        'link.require'   => '电视剧链接不能为空',
    ];
}
