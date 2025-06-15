<?php
/** @var string $title */
/** @var string $content */

ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SnoutPals' ?></title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.4;
            background-color: #dedede;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #98b59e;
            font-weight: bold;
            text-align: center;
            margin-top: 0;
        }
        p {
            color: #333;
        }
        a.button {
            display: inline-block;
            background-color: #ffe0d8;
            color: #292B3F;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #d47c52;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <?= $content ?>
    </div>
    <div class="footer">
        <?= tt('register.email_footer')?>
    </div>
</body>
</html>
<?php return ob_get_clean(); ?>
