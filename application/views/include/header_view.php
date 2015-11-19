<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/general.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/spin.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.spin.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/noty/jquery.noty.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/noty/layouts/top.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/noty/themes/default.js" ></script>
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/sticky-footer.css" rel="stylesheet">
<?php if(isset($color) && $color): ?>
<link href="<?php echo base_url(); ?>css/jquery-ui-1.10.3.custom.min_<?php echo $color; ?>.css" type="text/css" rel="stylesheet" >
<link href="<?php echo base_url(); ?>css/<?php echo $color; ?>.css" type="text/css" rel="stylesheet" >
<?php else: ?>
<link href="<?php echo base_url(); ?>css/jquery-ui-1.10.3.custom.min_greenyellow.css" type="text/css" rel="stylesheet" >
<link href="<?php echo base_url(); ?>css/principal.css" type="text/css" rel="stylesheet" >
<?php endif; ?>
<link href="<?php echo base_url(); ?>css/general.css" type="text/css" rel="stylesheet" >
</head>
<body>
    <div id="dialog" style="z-index: 400 !important;"></div>
    <input id="base_url" type="hidden" value="<?php echo base_url(); ?>" />
    <div id="wrap">
    <div id="content">