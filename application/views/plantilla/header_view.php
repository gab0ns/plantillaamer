<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AMER AC</title>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jssor.slider.mini.js"></script>
<script>
        jQuery(document).ready(function ($) {
            
            var jssor_1_options = {
              $AutoPlay: true,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 5,
                $SpacingX: 0,
                $SpacingY: 0,
                $Orientation: 2,
                $Align: 0
              }
            };
            
            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
            
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 910);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="site">

<div class="header">
    <div class="top-header" align="right">
    	
    	<span>Iniciar Sesi&oacute;n</span>
        <input type="text" placeholder="Usuario" />
        <input type="text" placeholder="Contrase&ntilde;a" />
        <a class="login" href="#">Login</a>
    </div>
    <div class="header-medio">
        <div class="logo">
            <img width="100px" src="amer/imagenes/modifucadas/logo.png" />
        <span>AMER</span>
        <span class="subtitulo">Asociaci&oacute;n Mexicana de Estudios Rurales A.C.</span>
        </div>
        <div class="clear"></div>
        <div class="menu">
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Quienes Somos</a></li>
                <li><a href="#">Actividades</a></li>
                <li><a href="#">Publicaciones</a></li>
                <li><a href="#">Miembros</a></li>
                <li><a href="#">Contacto</a></li>                 
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
     </div>
</div>
<div class="cuerpo">