<?php
namespace app\index\controller;

use think\Controller;

class Play extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
