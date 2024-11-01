<?php

namespace WP_Post_Has_Archive;

class Admin_Controller
{
    public function __construct()
    {
        // 管理メニューに追加
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    /**
     * メニューを表示.
     */
    public function admin_menu()
    {
        $admin_setting = new Admin_Setting_Controller();
        add_options_page(
            'Post has archive', //ページのタイトル
            'Post has archive', //管理画面のメニュー
            'manage_options', //ユーザーレベル
            Config::SLUG, //URLに入る名前
            array($admin_setting, 'register') //機能を提供する関数
        );
    }
}
