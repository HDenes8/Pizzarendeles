<?php
    session_start();
    if(isset($_SESSION['elado_user'])){}
    else {
        header("Location: loginpage.php");
	    die;
    }
    if (isset($_POST['logout'])) {
        unset($_SESSION['elado_user']);
        header("Location: loginpage.php");
	    die;
    }
?>
<html lang="en">
<head>
    <link rel="shortcut icon" href="images/pizza-1.jpg" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <style>
        body{
            background-image: url("images/bg_1.jpg");
            padding:20px
        }
        .content{
            background-color: rgba(0,0,0,0.6);
            margin-left:auto;
            margin-right:auto;
            height:45vw;
        }
        .menubutton{
            padding:5px;
            cursor:pointer;
            margin:5px
        }
        .flexdiv{
            display: flex;
            height: 100%
        }
        #progress, #finished{
            height:80%;
            width: 40%;
            padding: 20px;
            margin-left:50px;
            background-color: rgba(255,255,255,0.8);
            border: none;
            border-radius: 10px;
            overflow-y:auto;
        }
        #title{
            text-align:center;
        }
        #row{
            text-align:right;
        }
        table{
            border-spacing:5px;
        }
        td{
            border:solid thin black;
            padding:5px
        }
        .button_lezart{
            background-color:transparent;
            border:none;
            cursor:pointer;
            color:blue;
            text-decoration:underline;
        }
    </style>
</head>
<body>
    <div class="content">
        <form method="post">
            <input type="submit" value="Rendeléstörténet" name="orderhistory" class="menubutton">
            <input type="submit" value="Kijelentkezés" name="logout" class="menubutton">
        </form>

        <?php
            include("connection.php");
            if (isset($_POST['orderhistory'])) {
                echo "<div class='flexdiv'>";
                    echo "<div id='progress'>";
                        echo "<h2>Folyamatban lévő megrendelések</h2>";
                        $sql = "SELECT * FROM rendelesek WHERE rendeles_statusz <> 'kiszállítva' ORDER BY rendeles_ideje ASC";
                        $result = $conn->prepare($sql);
                        $result->execute();
                        if ($result->rowCount() > 0) {
                            
                            echo "<table>";
                            echo "<tr id='title'> <td>id</td> <td>Pizzanév</td> <td>Feltétnév</td> <td>Méret</td> <td>Ár</td> <td>Mennyiség</td> <td>Rendelés ideje</td> </tr>";
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $nev = $row['pizzanev'];
                                $id = $row['id'];
                                echo "<form action=''>";
                                echo "<tr id='row'> <td><input type='button' value='$id' class='button_lezart' onclick='folyamat(this.value)'></td> <td>$nev</td> <td>{$row['feltetnev']}</td> <td>{$row['meret']}</td> <td>{$row['ar']}</td> <td>{$row['mennyiseg']}</td> <td>{$row['rendeles_ideje']}</td> </tr> <input type='hidden' name='id' value='$id'>";
                                echo "</form>";
                            }
                            echo "</table>";
                            
                            

                        }else {
                            echo "Sajnos nincs folyamatban lévő megrendelés...";
                        }
                    echo "</div>";


                    echo "<div id='finished'>";
                        echo "<h2>Lezárt megrendelések</h2>";
                        $sql = "SELECT * FROM rendelesek WHERE rendeles_statusz = 'kiszállítva' ORDER BY rendeles_ideje DESC";
                        $result = $conn->prepare($sql);
                        $result->execute();
                        if ($result->rowCount() > 0) {
                            
                            echo "<table>";
                            echo "<tr id='title'> <td>id</td> <td>Pizzanév</td> <td>Feltétnév</td> <td>Méret</td> <td>Ár</td> <td>Mennyiség</td> <td>Rendelés ideje</td> </tr>";
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $nev = $row['pizzanev'];
                                $id = $row['id'];
                                echo "<form action=''>";
                                echo "<tr id='row'> <td><input type='button' value='$id' class='button_lezart' onclick='lezart(this.value)'></td> <td>$nev</td> <td>{$row['feltetnev']}</td> <td>{$row['meret']}</td> <td>{$row['ar']}</td> <td>{$row['mennyiseg']}</td> <td>{$row['rendeles_ideje']}</td> </tr> <input type='hidden' name='id' value='$id'>";
                                echo "</form>";
                            }
                            echo "</table>";
                            

                        }else {
                            echo "Sajnos nincs lezárt megrendelés...";
                        }
                    echo "</div>";
                echo "</div>";
            }
            if (isset($_POST['mentes'])) {
                $rendeles = $_POST['rendeles'];
                $kezbesites = $_POST['kezbesites'];
                $id = $_POST['hidden_id'];

                $sql = "UPDATE rendelesek SET kezbesites_statusz = '$kezbesites', rendeles_statusz = '$rendeles' WHERE id='$id'";
                $result = $conn->prepare($sql);
                $result->execute();
                    echo "<script>alert('Sikeres mentés!')</script>";
                
                
            }
        ?>
    </div>
    <script src="index_elado.js"></script> 
    
</body>
</html>