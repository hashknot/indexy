<?php

$EXTENSIONS_IMAGE = array('png', 'jpg', 'jpeg', 'bmp', 'gif');
$EXTENSIONS_AUDIO = array('mp3', 'aac', 'flac', 'ogg');
$EXTENSIONS_VIDEO = array('mp4', 'avi', 'mpeg', 'mpg', 'mkv', '3gp', 'wmv');

define('TYPES_UNKNOWN', -1);
define('TYPES_AUDIO'  , 0);
define('TYPES_DIR'    , 1);
define('TYPES_IMAGE'  , 2);
define('TYPES_VIDEO'  , 3);

define('ACCESS_DIR', $_SERVER['DOCUMENT_ROOT'].rawurldecode($_SERVER['REQUEST_URI']));
define('SCRIPT_DIR', dirname($_SERVER['SCRIPT_NAME']));

$GLYPHICONS_CLASS = array(
    TYPES_UNKNOWN => "glyphicon glyphicon-file",
    TYPES_AUDIO   => "glyphicon glyphicon-music",
    TYPES_DIR     => "glyphicon glyphicon-folder-open",
    TYPES_IMAGE   => "glyphicon glyphicon-picture",
    TYPES_VIDEO   => "glyphicon glyphicon-film"
);

$TYPES_CLASS = array(
    TYPES_UNKNOWN => "types-unknown",
    TYPES_AUDIO   => "types-audio",
    TYPES_DIR     => "types-dir",
    TYPES_IMAGE   => "types-image",
    TYPES_VIDEO   => "types-video"
);

function human_filesize($file, $decimals = 2) {
    $bytes = filesize($file);
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Index of <?php echo basename(rawurldecode($_SERVER['REQUEST_URI']))."/"; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo SCRIPT_DIR; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SCRIPT_DIR; ?>/css/swipebox.min.css" rel="stylesheet">
    <link href="<?php echo SCRIPT_DIR; ?>/img/app-16x16.ico" rel="shortcut icon">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <ol class="breadcrumb" style="z-index:100;width:100%;position:fixed;top:0px;left:0px">
        <?php
        $levels = explode("/", $_SERVER['REQUEST_URI']);
        $lc = count($levels);

        echo '<li><a href="/"><span class="glyphicon glyphicon-home">&nbsp;</span></a></li>';
        $prefix = "/";
        for($i=1; $i<$lc-2; $i++){
            $prefix = $prefix.$levels[$i]."/";
            echo '<li><a href="'.$prefix.'">'.rawurldecode($levels[$i]).'</a></li>';
        }
        echo '<li class="active">'.rawurldecode($levels[$i]).'</li>';
        ?>
    </ol>

    <div class="container" style="padding-top:50px;padding-bottom:15px">
        <div class="row">
            <div class="list-unstyled">
            <?php
            $dirContents = scandir(ACCESS_DIR, SCANDIR_SORT_ASCENDING);
            $fileNames = array();
            foreach ($dirContents as $fileName)
            {
                if(substr($fileName, 0, 1) === '.'){
                    continue;
                }

                $filePath = ACCESS_DIR.DIRECTORY_SEPARATOR.$fileName;

                if(!is_dir($filePath)){
                    $fileNames[] = $fileName;
                    continue;
                }

                $url = $fileName;
                echo '<a href="'.$url.'" class="list-group-item '.$TYPES_CLASS[TYPES_DIR].'">';
                echo '<span class="'.$GLYPHICONS_CLASS[TYPES_DIR].'"></span>&nbsp;&nbsp;&nbsp;'.$fileName;
                echo '</a>';
            }

            foreach ($fileNames as $fileName)
            {
                $filePath = ACCESS_DIR.DIRECTORY_SEPARATOR.$fileName;
                $type = TYPES_UNKNOWN;
                $extension = '';
                if (preg_match('/([^.]+)$/', $fileName, $match))
                    $extension = $match[1];
                if (in_array($extension, $EXTENSIONS_VIDEO))
                    $type = TYPES_VIDEO;
                else if (in_array($extension, $EXTENSIONS_AUDIO))
                    $type = TYPES_AUDIO;
                else if (in_array($extension, $EXTENSIONS_IMAGE))
                    $type = TYPES_IMAGE;

                $url = rawurlencode($fileName);
                echo '<a href="'.$url.'" class="list-group-item '.$TYPES_CLASS[$type].'">';
                echo '<span class="'.$GLYPHICONS_CLASS[$type].'"></span>';
                echo '<span class="pull-right">'.human_filesize($filePath).'</span>';
                echo '&nbsp;&nbsp;'.$fileName;
                echo '</a>';
            } ?>
            </div>
        </div>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo SCRIPT_DIR; ?>/js/jquery-1.11.0.min.js"></script>
    <script src="<?php echo SCRIPT_DIR; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo SCRIPT_DIR; ?>/js/jquery.swipebox.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
                $(".types-image").swipebox();
                })
    </script>
  </body>
</html>
