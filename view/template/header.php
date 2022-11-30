<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->includeAllFiles(); ?>
    <title>CRUD - PHP</title>
    <link rel="icon" type="image/png" href="data:image/png;base64,<?php echo base64_encode(file_get_contents('./favicon.png')); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- <link rel="shortcut icon"  type="image/x-icon"> -->
</head>

<body>
<script> const HOME_PATH =" <?php echo application::HOME_PATH; ?>"</script>