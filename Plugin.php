<?php
/**
 * 一款专属于Handsome的信息提示插件
 * @package HandsomeCall
 * @author Wibus
 * @version 4.1.1
 * @link https://blog.iucky.cn
 */
    header("content-type:text/html;charset=utf-8");
    date_default_timezone_set("PRC");//设置时区


class HandsomeCall_Plugin implements Typecho_Plugin_Interface
{
	public static function activate()
	{
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
        return _t('插件已启用，请访问前台查看效果～');
    }

	/* 禁用插件方法 */
	public static function deactivate()
	{
        return _t('插件已禁用，感谢使用～');
	}


     /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
    
    
    
    
        // 插件信息与更新检测
        function check_update($version)
        {
            $tooday = date("m-d");
            echo "<style>.info{text-align:center; margin:20px 0;} .info > *{margin:0 0 15px} .buttons a{background:#467b96; color:#fff; border-radius:4px; padding: 8px 10px; display:inline-block;}.buttons a+a{margin-left:10px}</style>";
            echo "<div id='tip'></div>";
            echo "<div class='info'>";
            echo "<h2>一款专属于Handsome的信息提示插件 (" . $version . ")</h2><small>今日是". $tooday . "</small>";

            echo "<h3>最新版本：<span style='padding: 2px 4px; background-image: linear-gradient(90deg, rgba(73, 200, 149, 1), rgba(38, 198, 218, 1)); background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgba(255, 255, 255, 1); border-width: 0.25em 0' id='ver'>获取中...</span>&nbsp;&nbsp;当前版本：<span id='now'>".$version. "</span></h3>";
            echo "<h3 style='color: rgba(255, 153, 0, 1)' id='description'></h3>";
            echo "<p>By: <a href='https://blog.iucky.cn'>Wibus</a></p>";
            echo "<p><span class='buttons'><a href='https://blog.iucky.cn/Y-disk/10.html'>插件说明</a></span>
            <span id='btn' class='buttons'><a id='description'>获取更新说明</a></span></p>";
            echo "<script src='https://api.iucky.cn/plugins/update/handsomecall.js'></script>";
            echo "</div>";

        }
        check_update("4.0.0");
        
        
        // 是否启动复制功能
        $copy = new Typecho_Widget_Helper_Form_Element_Radio(
            'copy',
            array(
                '0' => _t('否'),
                '1' => _t('是'),
            ),
            '1',
            _t('是否启动复制提示功能'),
            _t('使用handsome自带的提示弹窗实现复制提醒，如果启动了Pjax，请将下面的选项勾选为 是')
        );
        $form->addInput($copy);
        
        // 是否启动Pjax
        $pjax = new Typecho_Widget_Helper_Form_Element_Radio(
            'pjax',
            array(
                '0' => _t('否'),
                '1' => _t('是'),
            ),
            '1',
            _t('主题是否启动了Pjax'),
            _t('如果主题启动了Pjax，插件将会自动在Pjax回调函数里添加 kaygb_copy(); 函数')
        );
        $form->addInput($pjax);
        
        // 作者信息
        $author = new Typecho_Widget_Helper_Form_Element_Text(
            'author',
            NULL,
            'wibus',
            _t('作者名字：'),
            _t('复制操作时将会显示信息，没启动复制功能的直接忽略')
        );
        $form->addInput($author);

        // 是否启动节日提示
        $season = new Typecho_Widget_Helper_Form_Element_Radio(
            'season',
            array(
                '0' => _t('否'),
                '1' => _t('是'),
            ),
            '1',
            _t('主题是否启动节日提示'),
            _t('主题将会在一些节日进行提示，但在节日当天 外部来源提示 将会强制关闭')
        );
        $form->addInput($season);
        
        $echo1 = new Typecho_Widget_Helper_Form_Element_Text('echo1',NULL,'下面的选项请不要随意修改！！如果修改导致错误重新启动插件即可',_t(''),_t(''));
        //$form->addInput($echo1);
        
        // 初次加载
        $first_load = new Typecho_Widget_Helper_Form_Element_Textarea(
            'first_load',
            NULL,
            '欢迎来到小站里喝茶~  我倍感荣幸啊 嘿嘿 <br / > ',
            _t('初次进入网站时的提示'),
            _t('请使用HTML代码进行编写！')
        );
        $form->addInput($first_load);
        
                
        // 第二次加载
        $second_load = new Typecho_Widget_Helper_Form_Element_Textarea(
            'second_load',
            NULL,
            '欢迎来到小站里喝茶~! 您竟然是直接访问的！莫非您记住了我的<strong>域名</strong>.厉害~ <br / >',
            _t('第二次进入网站时的提示'),
            _t('请使用HTML代码进行编写！')
        );
        $form->addInput($second_load);
        
        
        // // 外部链接来源
        // $outside_load = new Typecho_Widget_Helper_Form_Element_Textarea(
        //     'outside_load',
        //     NULL,
        //     'Hello！<strong>' .$host. '</strong>的朋友！你好哇',
        //     _t('外部链接进入网站时的提示（".$host" 表示来源链接)'),
        //     _t('请使用HTML代码进行编写！不懂请不要修改！')
        // );
        // $form->addInput($outside_load);

            // 来源：百度快照
            $baidu_photo = new Typecho_Widget_Helper_Form_Element_Textarea(
                'baidu_pho',
                NULL,
                '您通过 <strong>百度快照</strong> 找到了我，厉害！<br / > ',
                _t('通过百度快照进入网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($baidu_photo);
        
            // 来源：百度
            $baidu_load = new Typecho_Widget_Helper_Form_Element_Textarea(
                'baidu_load',
                NULL,
                '您通过 <strong>百度</strong> 找到了我，厉害！<br / > ',
                _t('通过百度进入网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($baidu_load);
            
                            
            //来源：好搜
            $haosou_load = new Typecho_Widget_Helper_Form_Element_Textarea(
            'haosou_load',
             NULL,
           '您通过 <strong>好搜</strong> 找到了我，厉害！<br / > ',
            _t('通过好搜进入网站时的提示'),
            _t('请使用HTML代码进行编写！')
                            );
             $form->addInput($haosou_load);
            
            // 来源：google
            $google_load = new Typecho_Widget_Helper_Form_Element_Textarea(
                'google_load',
                NULL,
                '您居然通过 <strong>Google</strong> 找到了我! 一定是个技术宅吧!<br / > ',
                _t('通过百Google进入网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($google_load);
            
            // 来源：yahoo
            $yahoo_load = new Typecho_Widget_Helper_Form_Element_Textarea(
                'yahoo_load',
                NULL,
                '您通过 <strong>Yahoo</strong> 找到了我，厉害！<br / >',
                _t('通过Yahoo<进入网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($yahoo_load);
        
            // 来源：bing
            $bing_load = new Typecho_Widget_Helper_Form_Element_Textarea(
                'bing_load',
                NULL,
                '您通过 <strong>Bing</strong> 找到了我，厉害！<br / >',
                _t('通过Bing进入网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($bing_load);
            
            // 来源：google订阅
            $google_ding = new Typecho_Widget_Helper_Form_Element_Textarea(
                'google_ding',
                NULL,
                '感谢你通过 <strong>Google</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / >',
                _t('通过Google 订阅 网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($google_ding);

            // 来源：鲜果订阅
            $xianguo_ding = new Typecho_Widget_Helper_Form_Element_Textarea(
                'xianguo_ding',
                NULL,
                '感谢你通过 <strong>鲜果</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / >',
                _t('通过鲜果订阅网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($xianguo_ding);

            // 来源：抓虾订阅
            $zhuaxia_ding = new Typecho_Widget_Helper_Form_Element_Textarea(
                'zhuaxia_ding',
                NULL,
                '感谢你通过 <strong>抓虾/strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / >',
                _t('通过抓虾订阅网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($zhuaxia_ding);

            // 来源：哪吒订阅
            $nezha_ding = new Typecho_Widget_Helper_Form_Element_Textarea(
                'nezha_ding',
                NULL,
                '感谢你通过 <strong>哪吒</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / >',
                _t('通过哪吒订阅网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($nezha_ding);

            // 来源：有道订阅
            $youdao_ding = new Typecho_Widget_Helper_Form_Element_Textarea(
                'youdao_ding',
                NULL,
                '感谢你通过 <strong>有道</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / >',
                _t('通过有道订阅网站时的提示'),
                _t('请使用HTML代码进行编写！')
            );
            $form->addInput($youdao_ding);
                
    }
    
    
    

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {

    }

	/* 插件实现方法 */
    /**
     * file for header
     * @return void
     */
    public static function header(){
        
    }
    
    /**
     * 页脚输出相关代码
     *
     * @access public
     * @param unknown render
     * @return unknown
     */
    public static function footer()
    {   
        
        $referer = $_SERVER["HTTP_REFERER"];
        $refererhost = parse_url($referer);
        $host = strtolower($refererhost['host']);
        $ben=$_SERVER['HTTP_HOST'];

		$options = Helper::options();
		$author = $options->plugin('HandsomeCall')->author;
		$copy = $options->plugin('HandsomeCall')->copy;
        $pjax = $options->plugin('HandsomeCall')->pjax;
        $season = $options->plugin('HandsomeCall')->season;
        
		$first_load = $options->plugin('HandsomeCall')->first_load;
		$second_load = $options->plugin('HandsomeCall')->second_load;
        // $outside_load = $options->plugin('HandsomeCall')->outside_load;
        $baidu_photo = $options->plugin('HandsomeCall')->baidu_photo;
        $baidu_load = $options->plugin('HandsomeCall')->baidu_load;
        $haosou_load = $options->plugin('HandsomeCall')->haosou_load;
        $google_load = $options->plugin('HandsomeCall')->google_load;
        $yahoo_load = $options->plugin('HandsomeCall')->yahoo_load;
        $bing_load = $options->plugin('HandsomeCall')->bing_load;
        $google_ding = $options->plugin('HandsomeCall')->google_ding;
        $xianguo_ding = $options->plugin('HandsomeCall')->xianguo_ding;
        $zhuaxia_ding = $options->plugin('HandsomeCall')->zhuaxia_ding;
        $nezha_ding = $options->plugin('HandsomeCall')->nezha_ding;
        $youdao_ding = $options->plugin('HandsomeCall')->youdao_ding;
        //$type = Typecho_Widget::widget('Widget_Options')->plugin('HandsomeCall')->author;
        if($copy == 1){
        echo '<script>
            kaygb_copy();
function kaygb_copy(){$(document).ready(function(){$("body").bind(\'copy\',function(e){hellolayer()})});var sitesurl=window.location.href;function hellolayer(){
    $.message({
        message: "尊重原创，转载请注明出处！<br> 本文作者：' . $author . '<br>原文链接："+sitesurl,
        title: "复制成功",
        type: "warning",
        autoHide: !1,
        time: "5000"
        })
    }}
    </script>';
    if ($pjax == 1){
    echo '<script>$(document).on("ready pjax:end", function () { kaygb_copy(); })</script>';
    echo "<script>console.log('HandsomeCall Pjax-Load SUCCESS ')</script>";
    }
}


        // $hello = $outside_load;
        $hello = "Hello！<strong>' .$host. '</strong>的朋友！你好哇";
            if($referer == ""||$referer == null){
                if(!Typecho_Cookie::get('firstView')){
                    Typecho_Cookie::set('firstView', '1', 0, Helper::options()->siteUrl);
                    //$hello = "欢迎来到小站里喝茶~  我倍感荣幸啊 嘿嘿 <br / > ";
                    $hello = $first_load;
                }else{
                    //$hello = "欢迎来到小站里喝茶~! 您竟然是直接访问的！莫非您记住了我的<strong>域名</strong>.厉害~ <br / > ";
                    $hello = $second_load;
                }
            }elseif(strstr($ben,$host)){ 
                $hello ="host"; 
            }elseif (preg_match('/baiducontent.*/i', $host)){
                $hello = $baidu_photo;
                //$hello = '您通过 <strong>百度快照</strong> 找到了我，厉害！<br / > ';
                $hello = $second_load;
            }elseif(preg_match('/baidu.*/i', $host)){
                $hello = $baidu_load;
                //$hello = '您通过 <strong>百度</strong> 找到了我，厉害！<br / > ';
            }elseif(preg_match('/so.*/i', $host)){
                $hello = $haosou_load;
                //$hello = '您通过 <strong>好搜</strong> 找到了我，厉害！<br / > ';
            }elseif(!preg_match('/www\.google\.com\/reader/i', $referer) && preg_match('/google\./i', $referer)) {
                $hello = $google_load;
                //$hello = '您居然通过 <strong>Google</strong> 找到了我! 一定是个技术宅吧!<br / > ';
            }elseif(preg_match('/search\.yahoo.*/i', $referer) || preg_match('/yahoo.cn/i', $referer)){
                $hello = $yahoo_load;
                //$hello = '您通过 <strong>Yahoo</strong> 找到了我! 厉害！<br / > ';
            }elseif(preg_match('/cn\.bing\.com\.*/i', $referer) || preg_match('/yahoo.cn/i', $referer)){
                $hello = $bing_load;
                //$hello = '您通过 <strong>Bing</strong> 找到了我! 厉害！<br / > ';
            }elseif(preg_match('/google\.com\/reader/i', $referer)){
                $hello = $google_ding;
                //$hello = "感谢你通过 <strong>Google</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / > ";
            } elseif (preg_match('/xianguo\.com\/reader/i', $referer)) {
                $hello = $xianguo_ding;
                //$hello = "感谢你通过 <strong>鲜果</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / > ";
            } elseif (preg_match('/zhuaxia\.com/i', $referer)) {
                $hello = $zhuaxia_ding;
                //$hello = "感谢你通过 <strong>抓虾</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / > ";
            } elseif (preg_match('/inezha\.com/i', $referer)) {
                $hello = $nezha_ding;
                //$hello = "感谢你通过 <strong>哪吒</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / > ";
            } elseif (preg_match('/reader\.youdao/i', $referer)) {
                $hello = $youdao_ding;
                //$hello = "感谢你通过 <strong>有道</strong> 订阅我!  既然过来读原文了. 欢迎留言指导啊.嘿嘿 ^_^<br / > ";
            }
            if($season == 1){
                $year = date(Y);
                $today = date("m-d"); //获取今日的日期
                echo "<script>console.log('HandsomeCall date SUCCESS ')</script>";
                if ($today == "01-01") {
                    $hello = '<strong>元旦</strong>了呢，新的一年又开始了，今年是' .$year. '年～';
                }elseif ($today == "02-14") {
                    $hello = '又是一年<strong>情人节</strong>，{$year}年找到对象了嘛～';
                }elseif ($today == "03-08") {
                    $hello = '今天是<strong>国际妇女节</strong>！';
                }elseif ($today == "03-12") {
                    $hello = '今天是<strong>植树节</strong>，要保护环境呀！';
                }elseif ($today == "04-01") {
                    $hello = '悄悄告诉你一个秘密～<strong>今天是愚人节，不要被骗了哦～</strong>';
                }elseif ($today == "05-01") {
                    $hello = '今天是<strong>五一劳动节</strong>，计划好假期去哪里了吗～';
                }elseif ($today == "06-01"){
                    $hello = '<strong>儿童节</strong>了呢，快活的时光总是短暂，要是永远长不大该多好啊…';
                }elseif ($today == "09-03") {
                    $hello = '<strong>中国人民抗日战争胜利纪念日</strong，铭记历史、缅怀先烈、珍爱和平、开创未来。';
                }elseif ($today == "09-10") {
                    $hello = '<strong>教师节</strong>，在学校要给老师问声好呀～';
                }elseif ($today == "09-24") {
                    $hello = '今天是我家主人<strong>生日</strong>呢，有没有想跟他说的呀？快去留言板说说吧~~~';
                }elseif ($today == "10-01") {
                    $hello = '<strong>国庆节</strong>到了，为祖国母亲庆生！';
                }elseif ($today == "11-11") {
                    $hello = '今年的<strong>双十一</strong>是和谁一起过的呢～';
                }elseif ($today >= "12-20" && $today <= "12-31") {
                    $hello = '这几天是<strong>圣诞节</strong>，去剁手买买买了～';
                }else{
                    echo "<script>console.log('Date false')</script>";
                    
                    }
            }
            if( $hello != "host"){//排除本地访问
                echo "
    <script type=\"text/javascript\">
        function notice(){
            $.message({
                title: '页面加载完毕',
                message: '{$hello}',
                type: 'success',
                autoHide: !1,
                time: '5000'
            });
        };
        $(function(){
            notice();
        });
    </script>
    ";
            }
        


    
    }

}

?>
