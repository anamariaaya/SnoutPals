<!DOCTYPE html>
<html lang="<?php echo chooseLanguage(); ?>">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{% meta_description %}">
        <meta property="og:title" content="Pet App Services - {% home.title %}"> 

        <title>Pet App Services - <?php echo tt($title); ?></title>

        <link href="/build/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="/build/css/app.css"/>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>

        <?php
            include_once __DIR__ .'/../templates/header.php';
            echo $content; 
            include_once __DIR__ .'/../templates/footer.php'; 
        ?>

    <script type="module" src="/build/js/app.js"></script>
    
        <?php
            echo $script ?? '';
        ?>
            
    </body>
</html>

