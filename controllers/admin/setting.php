<?php

namespace WP_Post_Has_Archive;

class Admin_Setting_Controller extends Controller
{
    private $result = null;
    private $view;

    public function register()
    {
        if (isset($_POST['save_setting'])) {
            $this->save_setting();
            $this->assign('result', $this->result);
        }
        $this->view();
    }

    /**
     * 基本設定.
     */
    public function view()
    {
        flush_rewrite_rules();
        $this->view = 'detail';
        $option = get_option(Config::OPTION);
        $this->assign('option', $option);
        $this->assign('post_archive_url', home_url('/').$option['has_archive'].'/');
        $this->render('admin/setting');
    }

    /**
     * 保存処理.
     */
    public function save_setting()
    {
        // 保存処理
        if (isset($_POST['save_setting']) && $_POST['save_setting'] == true && wp_verify_nonce($_POST['_wpnonce'], Config::NONCE)) {
            $option = array(
                'has_archive' => Functions::input('has_archive'),
            );
            $result = Functions::save_option($option);
            if (!is_wp_error($result)) {
                $option = get_option(Config::OPTION);
                $args = array();
                $args['has_archive'] = $option['has_archive'];
                Functions::set_post_archive($args, 'post');
                $this->result = $result;
            }
        }
    }
}
