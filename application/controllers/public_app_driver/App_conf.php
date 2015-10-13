<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_conf extends Public_Android_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->data['error'] = array(
            'application' => array(
                'head' => array(
                    'code' => 'E000000000',
                    'description' => '',
                ),
            ),
            'body' => array(),
        );
    }

    public function index()
    {
        
    }

    public function get_score_rule_text()
    {
        $score_rule_text = '好运币是为了回馈广大司机对途好运App的支持，特别设计的奖励产品，您注册，登录，打开，上报，分享，完成运单等操作都会获得相应de好运币奖励。';
        $score_rule_table = array(
            array(
                'field_1' => '第一次发车完成',
                'field_2' => '一次',
                'field_3' => 1,
                'field_4' => 200,
            ),
            array(
                'field_1' => '每完成1单',
                'field_2' => '每天',
                'field_3' => 2,
                'field_4' => 10,
            ),
            array(
                'field_1' => '上报',
                'field_2' => '每天',
                'field_3' => 3,
                'field_4' => 5,
            ),
            array(
                'field_1' => '8小时内升级软件',
                'field_2' => '每个版本',
                'field_3' => '不限',
                'field_4' => 20,
            ),
            array(
                'field_1' => '第一次加入公司',
                'field_2' => '一次',
                'field_3' => 1,
                'field_4' => 50,
            ),
            array(
                'field_1' => '更新软件',
                'field_2' => '每个版本',
                'field_3' => 1,
                'field_4' => 20,
            ),
            array(
                'field_1' => '4个小时位置无更新',
                'field_2' => '每天',
                'field_3' => 2,
                'field_4' => -2,
            ),
            array(
                'field_1' => '公司点赞',
                'field_2' => '每天',
                'field_3' => 1,
                'field_4' => 50,
            ),
            array(
                'field_1' => '邀请朋友成功注册',
                'field_2' => '每天',
                'field_3' => 3,
                'field_4' => 100,
            ),
            array(
                'field_1' => '朋友完成发车第一单',
                'field_2' => '每次',
                'field_3' => '不限',
                'field_4' => 100,
            ),
        );

        $this->data['error']['body']['score_rule_text'] = $score_rule_text;
        $this->data['error']['body']['score_rule_table'] = $score_rule_table;

        echo json_en($this->data['error']);
        exit;
    }
}