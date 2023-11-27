<html lang="en">
<head>
    <link rel="shortcut icon" href="images/pizza-1.jpg" type="image/x-icon">    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <style>
        body{
            background-image: url("images/bg_1.jpg");
        }
        .input_login{
            border-radius:5px;
            border:none;
            padding:3px;
            height: 50px;
            font-size:1.2em;
            text-align:center;
            background-color: rgba(255,255,255,0.7);
        }
        .input_login:focus{
            background-color: rgba(255,255,255,0.9);
        }
        .button_login{
            padding:8px;
            font-size:1em;
            text-align:center;
            border-radius:5px;
            border:none;
            cursor:pointer;
            background-color: rgba(255,255,255,0.7);
            transition-duration:0.6s;
        }
        .button_login:hover{
            background-color: rgba(255,255,255,1);
        }
        .content{
            padding-top:30px;
            padding-bottom:30px;
            padding-left:100px;
            padding-right:100px;
            background-color: rgba(0,0,0,0.6);
            width:fit-content;
            border:none;
            border-radius:5px;
            margin-left:auto;
            margin-right:auto;
            margin-top:150px
        }
    </style>
</head>
<body>
    <div class="content">
        <h2 style="color:white">Bejelentkezés</h2>
        <form action="" method="post">
            <input type="text" name="felhasznalo" class="input_login" placeholder="felhasználónév" maxlength="10" required><br><br>
            <input type="password" name="jelszo" class="input_login" placeholder="jelszó" maxlength="16" required><br><br>
            <input type="submit" value="Bejelentkezés" class="button_login" name="login">
        </form>
        <div style="color:red">
            <?php
                include("api.php");
                if (isset($_POST['login'])) {
                    $felhasznalo = $_POST['felhasznalo'];
                    $jelszo = $_POST['jelszo'];
                    $jelszo_hash = hash("sha256", $jelszo);
                    $admin = new Admin($felhasznalo, $jelszo_hash);
                    $admin->belep_user();
                }
            ?>
        </div>
    </div>
    
</body>
</html>