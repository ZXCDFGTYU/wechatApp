<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create User-微我勒个去</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css">
    
    <link href="/Admin/Home/View/Index/css/signin.css" rel="stylesheet" type="text/css">

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
                <h1>Create User</h1>

            <form id="createForm">
                <div class="login-fields">
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="用户名" class="login username-field" />
                    </div> <!-- /field -->
                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="密码" class="login password-field"/>
                    </div> <!-- /password -->
                    <div class="field">
                        <span style="font-size: 16px">Level:</span>
                        <select name="level" id="level" style="width: 85%;">
                            <option value="0">user</option>
                            <option value="1">admin</option>
                            <option value="2">root</option>
                        </select>
                    </div> <!-- /password -->
                </div> <!-- /login-fields -->
            </form>
                <div class="login-actions">
                    <div class="button btn btn-success btn-large CreateBtn">Create!</div>
                </div> <!-- .actions -->
        </div> <!-- /content -->
    </div> <!-- /account-container -->
    <div class="login-extra">
        <a href="http://www.miitbeian.gov.cn/">京ICP备15058363号-1</a>|
        <span style="color:#19bc9c;">CopyRight 2015-<?php echo date('Y',time());?> By <a href="http://blog.zzz80.cn">Mr.Z</a></span>
    </div> <!-- /login-extra -->

<script src="/Public/Admin/js/jquery-1.7.2.min.js"></script>
<script src="/Public/Admin/js/bootstrap.js"></script>

    <script src="/Admin/Home/View/Index/js/create.js"></script>

</body>
</html>