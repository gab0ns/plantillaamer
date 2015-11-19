<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/three.min.js"></script>
<link href="<?php echo base_url(); ?>css/waiting.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/sticky-footer.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="dialog" style="z-index: 400 !important;"></div>
    <input id="base_url" type="hidden" value="<?php echo base_url(); ?>" />
    <div id="wrap">
    <div id="content">