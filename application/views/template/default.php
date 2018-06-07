<?php
    $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
    
    $separate_method_GET = explode('?', $_SERVER['REQUEST_URI']);
    $routes = explode('/', $separate_method_GET[0]);
    if ( !empty($routes[1]) ){	
        $controller_name = $routes[1];
    }
    else {
        $controller_name = "main";
    }
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<link rel="shortcut icon" href="<?php echo $host; ?>images/favicon.png" type="image/png" />
		<link rel="stylesheet" href="<?php echo $host; ?>css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $host; ?>css/template.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $host; ?>css/flexslider.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $host; ?>css/<?php echo $controller_name; ?>.css" type="text/css" />
		<script src="<?php echo $host; ?>js/jquery.min.js" type="text/JavaScript"></script>
        <script src="<?php echo $host; ?>js/jquery.easing.js" type="text/JavaScript"></script>
        <script src="<?php echo $host; ?>js/jquery.flexslider.js" type="text/JavaScript"></script>
		<script src="<?php echo $host; ?>js/bootstrap.min.js" type="text/JavaScript"></script>
        <script>
                function banners_flexslider() {

                    // store the slider in a local variable
                    var $window = $(window),
                        flexslider = { vars:{} };

                    // tiny helper function to add breakpoints
                    function getGridSize() {
                        return (window.innerWidth < 640) ? 1 :
                        (window.innerWidth < 960) ? 2 : 3;
                    }

                    $(function() {
                        SyntaxHighlighter.all();
                    });

                    $window.load(function() {
                        $('.flexslider').flexslider({
                            animation: "slide",
                            animationLoop: true,
                            itemWidth: 300,
                            itemMargin: 5,
                            minItems: getGridSize(), // use function to pull in initial value
                            maxItems: getGridSize() // use function to pull in initial value
                        });
                    });

                    // check grid size on resize event
                    $window.resize(function() {
                        var gridSize = getGridSize();

                        flexslider.vars.minItems = gridSize;
                        flexslider.vars.maxItems = gridSize;
                    });
                };
                banners_flexslider();
        </script>
        <?php
            if(!isset($_SESSION['auth'])){
                ?>
                    <style>
                        .input_head_error {
                            border: 1px solid #db4242 !important;
                            box-shadow: 0 0 7px #db4242 !important;
                        }
                        .input_head_success {
                            border: 1px solid #3ab030 !important;
                            box-shadow: 0 0 5px #3ab030 !important;
                        }
                    </style>
                    <script type="text/javascript">
                        function login_form_head(){
                            var formData = new FormData($('#login_form_head').get(0));
                            $.ajax({
                                url: $('#login_form_head').attr('action'),
                                type: $('#login_form_head').attr('method'),
                                contentType: false,
                                processData: false,
                                data: formData,
                                dataType: 'json',
                                success: function(json){
                                    if(json){
                                        if(json.error == "1"){
                                            $('#login_input').addClass('input_head_error');
                                            $('#password_input').addClass('input_head_error');
                                            setTimeout(function(){
                                                $('#login_input').val('');
                                                $('#password_input').val('');
                                                $('#login_input').removeClass('input_head_error');
                                                $('#password_input').removeClass('input_head_error');
                                                window.location.href = "<?php echo $host; ?>login";
                                            }, 1000);
                                        }
                                        else {
                                            $('#login_input').addClass('input_head_success');
                                            $('#password_input').addClass('input_head_success');
                                            window.location.href = "<?php echo $host; ?>";
                                        }
                                    }
                                }
                            });
                        }
                    </script>
                <?php
            }
        ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="content">
                <nav class="navbar navbar-inverse" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" data-target="#navmenu" data-toggle="collapse" class="navbar-toggle">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="<?php echo $host; ?>" class="navbar-brand">Task</a>

                        </div>
                        <div id="navmenu" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li<?php echo ($controller_name == "main") ? " class='active'" : ""; ?>><a href="<?php echo $host; ?>"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;&nbsp;Главная</a></li>
                                <?php
                                    if(!isset($_SESSION['auth'])){
										?>
											<li<?php echo ($controller_name == "registration") ? " class='active'" : ""; ?>><a href="<?php echo $host; ?>registration">Регистрация</a></li>
										<?php
									}
								?>
							</ul>
                            <ul class="nav navbar-nav navbar-right">
                                <?php
                                    if(isset($_SESSION['auth'])){
                                        
                                        if($_SESSION['auth'] == TRUE){
                                            if($_SESSION['auth']['status'] == "admin"){
                                                ?>
                                                    <li<?php echo ($controller_name == "adminpanel") ? " class='active'" : ""; ?>><a href="<?php echo $host; ?>adminpanel">Панель администратора</a></li>
                                                <?php
                                            }
                                            ?>
                                                <li class="dropdown">
                                                    <a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" style="cursor: pointer;">
                                                        <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['auth']['login']; ?>
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                        <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Мой профиль</a></li>
                                                        <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#"><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;&nbsp;Сообщения</a></li>
                                                        <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;Настройки</a></li>
                                                        <li role="presentation" class="divider"></li>
                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $host; ?>logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;&nbsp;Выйти</a></li>
                                                    </ul>
                                                </li>
                                            <?php
                                            
                                        }
                                    }
                                    else{
                                        ?>
											<form class="form-inline" style="margin-top: 8px;" action="<?php echo $host; ?>login/ajax" method="POST" id="login_form_head">
												<div class="form-group">
													<label class="sr-only" for="login_input">Логин</label>
													<input type="text" name="user_login" placeholder="Логин" id="login_input" class="form-control" />
												</div>
												<div class="form-group">
													<label class="sr-only" for="password_input">Пароль</label>
													<input type="password" name="user_password" placeholder="Пароль" id="password_input" class="form-control" />
												</div>
												<button type="button" class="btn btn-info" name="login_submit" onclick="login_form_head();"><span class="glyphicon glyphicon-log-in"></span></button>
											</form>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                <?php
                if(!empty($data['banners'])){
                    ?>
                        <div style="text-align: center;">
                            <div class="flexslider" style="display: inline-block;">
                                <ul class="slides">
                                    <?php
                                        function manner_img_margin($width, $height){
                                            if($width < "300"){
                                                $margin = (300 - $width) / 2;
                                                echo " margin: 0 " . $margin . "px 0 " . $margin . "px; height: 100%;";
                                            }
                                            elseif($height < "250"){
                                                $margin = (250 - $height) / 2;
                                                echo " margin: " . $margin . "px 0 " . $margin . "px 0; width: 100%;";
                                            }
                                            else{
                                                echo " width: 100%;";
                                            }
                                        }
                                        foreach($data['banners'] as $banner){
                                            ?>
                                                <li>
                                                    <div class="slider_banner_img">
                                                        <img style="<?php manner_img_margin($banner['banner_img_width'], $banner['banner_img_height']); ?>" src="<?= $banner['banner_img']; ?>" />
                                                    </div>
                                                    <p class="flex-caption"><a href="<?= $banner['banner_url_protocol']; ?>://<?= $banner['banner_url_link']; ?>" target="_blank"><?= $banner['banner_name']; ?></a></p>
                                                </li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div> 
                    <?php
                }
                ?>
                <div class="container">
                    <?php include '../application/views/'.$content_view; ?>
                </div>
            </div>

            <div class="footer copyright">
                <div class="container">
                    <!-- footer -->
                </div>
            </div>
        </div>
    <script src="<?php echo $host; ?>js/<?php echo $controller_name; ?>.js" type="text/JavaScript"></script>
    </body>
</html>