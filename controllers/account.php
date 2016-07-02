<?php

require 'classes/setup.php';

use Model\Khachhang;
use Model\KhachhangQuery;

class AccountController extends BaseController {

    public function register() {
        $post = filter_input_array(INPUT_POST);
        if ($post == null) {
            $title = "Đăng ký";
            $action = "Register";
            include 'views/Account/Account.php';
        } else {
            $kh = new Khachhang();
            $kh->setEmail($post['InputEmail']);
            $kh->setPassword(crypt($post['InputPassWord']));
            $kh->save();
            header('Location: /WebsiteBanHang/Home');
        }
    }

    public function login() {
        $post = filter_input_array(INPUT_POST);
        if ($post == null) {
            $title = "Đăng nhập";
            $action = "Login";
            include 'views/Account/Account.php';
        } else {
            $khachhang = KhachhangQuery::create()->findByEmail($post['InputEmail'])->getFirst();
            if ($post['InputPassWord'] == $khachhang->getPassword()) {
                session_start();
                $_SESSION['user'] = $khachhang;
                header('Location: /WebsiteBanHang/Home');
            } else {
                $error = true;
                $title = "Đăng nhập";
                $action = "Login";
                include 'views/Account/Account.php';
            }
        }
    }

}
