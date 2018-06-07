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
    if ( !empty($routes[2]) ){
        $action_name = $routes[2];
    }
    else {
        $action_name = "index";
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
		<link rel="stylesheet" href="<?php echo $host; ?>css/adminpanel_template.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $host; ?>css/<?php echo $controller_name; ?>.css" type="text/css" />
		<script src="<?php echo $host; ?>js/jquery.min.js" type="text/JavaScript"></script>
		<script src="<?php echo $host; ?>js/jquery.easing.js" type="text/JavaScript"></script>
		<script src="<?php echo $host; ?>js/bootstrap.min.js" type="text/JavaScript"></script>
    </head>
    <body>
        <div class="adminpanel-wrapper">
            <div class="adminpanel-sidebar">
                <div class="adminpanel-top">
                    <a href="<?php echo $host; ?>" class="btn btn-info" title="Вернуться на сайт"><span class="glyphicon glyphicon-chevron-left"></span></a>
                    <a href="<?php echo $host; ?>logout" class="btn btn-danger" title="Выйти с учётной записи"><span class="glyphicon glyphicon-log-out"></span></a>
                </div>
                <div class="adminpanel-menu">
                    <a href="<?php echo $host; ?>adminpanel/banners" class="btn btn-primary btn-block <?php echo ($action_name == "banners") ? "active" : ""; ?>">Баннеры</a>
				    <a class="btn btn-primary btn-block">Link 2</a>
				    <a class="btn btn-primary btn-block">Link 3</a>
                </div>
            </div>
            <div class="adminpanel-content">
                <?php include '../application/views/'.$content_view; ?>
            </div>
        </div>
        <script src="<?php echo $host; ?>js/<?php echo $controller_name; ?>.js" type="text/JavaScript"></script>
    </body>
</html>