<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login-微我勒个去</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css">
    
    <link href="Admin/Home/view/index/css/signin.css" rel="stylesheet" type="text/css">

</head>
<body>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="brand" href="javascript:void(0);">Wechat-AdminPancel-Login</div>
                <div class="nav-collapse">
                    <ul class="nav pull-right"></ul>
                </div><!--/.nav-collapse -->
            </div> <!-- /container -->
        </div> <!-- /navbar-inner -->
    </div> <!-- /navbar -->
    <div class="account-container">
        <div class="content clearfix">
            <form action="#" method="post">
                <h1>Login</h1>
                <div class="login-fields">
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="用户名" class="login username-field" />
                    </div> <!-- /field -->
                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="密码" class="login password-field"/>
                    </div> <!-- /password -->
                </div> <!-- /login-fields -->
                <div class="login-actions">
                    <div class="button btn btn-success btn-large">Login</div>
                </div> <!-- .actions -->
            </form>
        </div> <!-- /content -->
    </div> <!-- /account-container -->
    <div class="login-extra">
        <a href="javascript:void(0);">忘记密码？</a> |
        <a href="http://www.miitbeian.gov.cn/">京ICP备15058363号-1</a>
    </div> <!-- /login-extra -->

<script src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
<script src="/Public/Admin/js/bootstrap.js"></script>

    <script src="Admin/Home/view/index/js/signin.js"></script>

</body>
</html>