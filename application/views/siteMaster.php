<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>     
        <meta charset="utf-8">
            <title><?php if (isset($title)) echo ucwords($title); ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <meta name="description" content=""/>
            <meta name="keyword" content=""/>
            <meta name="author" content=""/> 
            
            <!--CSS-->
            <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css" />
            
            
            <!--JS-->
            <script type="text/javascript">
               var base_url = '<?php echo base_url() ?>';
            </script>
            <script type="text/javascript" src="<?php echo base_url() ?>scripts/core/jquery-1.9.1.js"></script>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.js"></script>
            <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/main.js"></script>
    </head>
    <body>
        <!--header -->
        <?php
        if (isset($header)) {
            echo $header;
        }
        ?>
        <!--header end-->
        <!--header -->
        <?php
        if (isset($menu)) {
            echo $menu;
        }
        ?>
        <!--header end-->
        <div class="main">
            <div class="extra">
                <div class="main-indent">
                    <div id="mainContent">
                        <?php
                        if (isset($content)) {
                            echo $content;
                        }
                        ?>
                    </div>
                    <!--footer -->
                    <?php
                    if (isset($footer)) {
                        echo $footer;
                    }
                    ?>
                </div>
            </div>
        </div>
        <!--footer end-->
    </body>

</html>
