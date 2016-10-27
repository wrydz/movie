<?php

// 获取自增ID
function getAutoId($type = '0')
{
    $data = ['kind_type'=>$type];
    return db('id')->insertGetId($data);
}