<?php $this->load->view('header_view');?>

<link href="<?php echo static_url('static/css/homepage.css')?>" rel="stylesheet" type="text/css"/>    
<link href="<?php echo static_url('static/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo static_url('static/js/jquery-2.1.4.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/bootstrap.min.js');?>" type="text/javascript"></script>

<body>

<?php $this->load->view('top_menu_view');?>
                                    
<div class="item">
    <img src="<?php echo static_url('static/images/help_bg.png')?>" alt="" style="width: 100%;height: 400px;">
    <h3>成功路上<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我们一起同行！</h3>
</div><!--item-->

<div class="panel-group" id="accordion">
    
    <div class="panel-group_text">
        <p>如何加入“途好运”</p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#aa1" >如何注册途好运货老板？</a></h4>
        </div>
        <div class="panel-collapse collapse in" id="aa1">
            <div class="panel-body">
                <h3>新用户注册</h3>
                <ul>
                    <li><span>1</span>&nbsp;&nbsp;&nbsp;点击网站链接  打开途好运货老板注册页面</li>
                    <li><span>2</span>&nbsp;&nbsp;&nbsp;选择新用户注册</li>
                    <li><span>3</span>&nbsp;&nbsp;&nbsp;输入手机号码获取验证码并设置登录密码</li>
                    <li><span>4</span>&nbsp;&nbsp;&nbsp;输入公司名称和公司简介</li>
                    <li><span>5</span>&nbsp;&nbsp;&nbsp;点击注册按钮提交并完成注册</li>
                </ul>
                <h3>已注册公司用户注册</h3>
                <ul>
                    <li><span>1</span>&nbsp;&nbsp;&nbsp;点击网站链接  打开途好运货老板注册页面</li>
                    <li><span>2</span>&nbsp;&nbsp;&nbsp;选择已注册公司的名称</li>
                    <li><span>3</span>&nbsp;&nbsp;&nbsp;获取管理码（管理码会发送到该公司注册时的手机号码上）</li>
                    <li><span>4</span>&nbsp;&nbsp;&nbsp;输入自己的手机号码获取验证码并设置登录密码</li>
                    <li><span>5</span>&nbsp;&nbsp;&nbsp;点击注册按钮提交并完成注册</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"  href="#aa2" >如何加入途好运车队？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa2">
            <div class="panel-body" style="height:150px;">
                <ul>
                    <li>目前途好运车队没有公开注册申请，想加入途好运车队你可以在“加入车队”模块点击申请加入车队按钮并完成
基本的注册信息，这时你已经是我们的途好运货老板了，我们收到你的申请会及时和你联系并对加入途好运车队
的一些事宜进行沟通。<br />你还可以拨打我们的客服电话021-61358385 或者发邮件到wuya136@hotmail.com进行加入途好运车队的
咨询。</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="panel-group_text">
        <p>如何使用“途好运”</p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#aa3" >货老板如何在我的车队加入新的司机？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa3">
            <div class="panel-body-img">
                <ul>
                    <li><img src="<?php echo static_url('static/images/help_img_1.png')?>" /></li>
                    <li><p>打开并登陆“途好运”点击图示处“添加车辆”按钮 </p></li>
                    <li><img src="<?php echo static_url('static/images/help_img_2.png')?>" /></li>
                    <li><p>填写司机基本信息，若司机已注册途好运手机app则添加司机成功
若司机未注册途好运app 我们会短信提示司机尽快注册app并加入车队</p></li>     
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#aa4" >货老板如何给我的车队司机发运单？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa4">
            <div class="panel-body-img">
                <ul>
                    <li><img src="<?php echo static_url('static/images/help_img_3.png')?>" /></li>
                    <li><p>打开并登陆“途好运”点击图示处“添加运单”按钮 </p></li>
                    <li><img src="<?php echo static_url('static/images/help_img_4.png')?>" /></li>
                    <li><p>填写运单起点和运单终点，在指定货车一栏选择一位司机， 被选择的司机在app端将会收到你的指令，担任此次运输任务</p></li>     
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#aa5" >货老板如何查看司机的运输轨迹？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa5">
            <div class="panel-body-img">
                <ul>
                    <li><img src="<?php echo static_url('static/images/help_img_5.png')?>" /></li>
                    <li><p>打开并登陆“途好运”点击图示处“在途车辆”按钮，点击地图上在途的车辆标示</p></li>
                    <li><img src="<?php echo static_url('static/images/help_img_6.png')?>" /></li>
                    <li><p>地图上展示该在途车辆的轨迹信息，包括起点终点，车辆速度，运单轨迹及异常上报信息</p></li>     
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#aa6" >货老板如何查看当前车队可用车辆？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa6">
            <div class="panel-body-img">
                <ul>
                    <li><img src="<?php echo static_url('static/images/help_img_7.png')?>" /></li>
                    <li><p>打开并登陆“途好运”点击图示处“可用车辆”按钮可以清晰查看 当前可用车辆数量以及可用车辆司机信息  </p></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="panel-group_text">
        <p>使用“途好运”遇到问题</p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#aa7" >忘记web登陆密码？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa7">
            <div class="panel-body" style="height:150px;">
                <ul>
                    <li>当你忘记web登录密码的时候，在web登录窗口点击“登陆”按钮下方  忘记密码？链接，在链接的新页面
输入你注册时的手机账号并获取验证码，输入验证码并设置新的登陆密码即可。</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"href="#aa8" >司机位置不准确怎么办？</a></h4>
        </div>
        <div class="panel-collapse collapse" id="aa8">
            <div class="panel-body" style="height:150px;">
                <li>途好运产品目前是通过司机app自动上报位置来获取司机的当前位置及运输轨迹，难免会产生司机未打开app
导致的位置不上报或者位置上报不准确的现象，当出现位置不准确的现象货老板可以要求司机打开途好运app
以及时更新最新最准确的地理位置。</li>
            </div>
        </div>
    </div>
</div><!--panel-group-->

<div class="help_bottom">
    <p>copyright@2015 上海麦速物联网信息科技有限公司  沪ICP备15022775号-2</p>
</div>

</body>

<?php $this->load->view('footer_view');?>