<?php
ini_set("display_errors",1);
$err = "";
$content = "";

    $opened = fopen("apprenants.txt","r");
        while(!feof($opened)){
            $line = fgets($opened);
            $myfile_arr = explode(',',$line);
            $last_id = $myfile_arr[0];
        }
        fclose($opened);

    if(isset($_POST['modif_submit'])){
        $id = ($_POST['id']);
        $promo = ($_POST['promo']);
        $prenom = ($_POST['prenom']);
        $nom = ($_POST['nom']);
        $date = ($_POST['date']);
        $tel = ($_POST['tel']);
        $mail = ($_POST['mail']);

        if(($nom == "") or ($prenom == "") or ($tel == "") or ($mail == "")){
            $err = "Veillez remplir tout les champs";
        }
        else{
            $opened = fopen("apprenants.txt","a+");
            while(!feof($opened)){
                $line = fgets($opened);
                if($line != ""){
                    $line_arr = explode(',',$line);
                    if($line_arr[0] == $id ){
                        ($line_arr[1] = $promo);
                        ($line_arr[2] = $prenom);
                        ($line_arr[3] = $nom);
                        ($line_arr[4] = $date);
                        ($line_arr[5] = $tel);
                        ($line_arr[6] = $mail);
    
                        $newline = $id.",".$promo.",".$prenom.",".$nom.",".$date.",".$tel.",".$mail.",1"."\n";
                    }
                    else{
                        $newline = $line;
                    }

                    $content .= $newline;
                }
                
            }

            file_put_contents("apprenants.txt",$content);
            fclose($opened);
        }

    }


    if(isset($_GET['id'])){
        $id = ($_GET['id']);
            $opened = fopen("apprenants.txt","a+");
            while(!feof($opened)){
                $line = fgets($opened);
                if($line != ""){
                    $line_arr = explode(',',$line);
                    if($line_arr[0] == $id ){
                        $promo = $line_arr[1];
                        $prenom = $line_arr[2];
                        $nom = $line_arr[3];
                        $date = $line_arr[4];
                        $tel = $line_arr[5];
                        $mail = $line_arr[6];
    
                        $newline = $id.",".$promo.",".$prenom.",".$nom.",".$date.",".$tel.",".$mail.",0"."\n";
                    }
                    else{
                        $newline = $line;
                    }

                    $content .= $newline;
                }
                
            }

            file_put_contents("apprenants.txt",$content);
            fclose($opened);
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="s_a_promo.css">
    <title>Apprenant</title>
</head>
<body>
    <div id="header">
        <h1> Apprenant </h1>
        <div id="nav">
            <a href="index.php"> Home </a>
            <a href="modif_apprenants.php"> Apprenant </a>
            <a href="promos.php"> Promo </a>
        </div>
    </div>

    <div id="content_body">

        <div class="form" id="form_modif">
                    <h2 class="form_title"> <a href="ajout_apprenant.php"> Ajouter </a> / <u> Modifier </u>     </h2>
                    <form action="#" method="POST">
                        <label for="id"> Id </label> <br>
                        <select name="id" id="">
                            <?php
                                $cmpt1 = 0;
                                $opened = fopen("apprenants.txt","r");
                                while(!feof($opened)){
                                    $line = fgets($opened);
                                    $myfile_arr = explode(',',$line);
                                    if(($myfile_arr[0] != "Id") and ($line != "")){
                                        $the_id = $myfile_arr[0];
                                        ?>
                                            <option value="<?php echo($myfile_arr[0])?>">
                                                <?php echo($the_id)?>
                                            </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                        
                        <br>
    
                        <label for="prenom"> Prenom </label> <br>
                        <input type="text" name="prenom"> <br>
    
                        <label for="nom"> Nom </label> <br>
                        <input type="text" name="nom"> <br>
    
                        <label for="date"> Date de Nais. </label> <br>
                        <input type="date"  value="2019-05-17" name="date"> <br>
    
                        <label for="tel"> Téléphone </label> <br>
                        <input type="number" name="tel"> <br>

                        <label for="mail"> email </label> <br>
                        <input type="email" name="mail"> <br>

                        <label for="promo"> Choisissez un Promo </label> <br>
                        <select name="promo" id="">
                            <?php
                                $cmpt1 = 0;
                                $opened = fopen("promos.txt","r");
                                while(!feof($opened)){
                                    $line = fgets($opened);
                                    $myfile_arr = explode(',',$line);
                                    if(($myfile_arr[0] != "Id") and ($line != "")){
                                        $the_id =  "P00".$myfile_arr[0];
                                        ?>
                                            <option value="<?php echo($myfile_arr[0])?>">
                                                <?php echo($the_id)?>
                                            </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                        
                        <br>
    
                        <input type="submit" name="modif_submit" value="Modifier">
                    </form>
        </div>

        <div id="tables">
            <?php
                $opened = fopen("apprenants.txt","r");
                echo'<table>';
                $cmpt1=0;
                while(!feof($opened)){
                    $line = fgets($opened);
                    if($line != ""){
                        $myfile_arr = explode(',',$line);
                    if($cmpt1 == 0){
                        echo('<tr class = "table_head">');
                            echo'<td>'.$myfile_arr[0].'</td>';
                            echo'<td>'.$myfile_arr[1].'</td>';
                            echo'<td>'.$myfile_arr[2].'</td>';
                            echo'<td>'.$myfile_arr[3].'</td>';
                            echo'<td>'.$myfile_arr[4].'</td>';
                            echo'<td>'.$myfile_arr[5].'</td>';
                            echo'<td>'.$myfile_arr[6].'</td>';
                            echo'<td>'.$myfile_arr[7].'</td>';
                        echo'</tr>';
                    }
                    else if($myfile_arr[7] == 1){
                        echo('<tr>');
                            echo'<td>'.$myfile_arr[0].'</td>';
                            $promo ="P00".$myfile_arr[1];
                            echo'<td>'.$promo.'</td>';
                            echo'<td>'.$myfile_arr[2].'</td>';
                            echo'<td>'.$myfile_arr[3].'</td>';
                            echo'<td>'.$myfile_arr[4].'</td>';
                            echo'<td>'.$myfile_arr[5].'</td>';
                            echo'<td>'.$myfile_arr[6].'</td>';
                                ?>
                                    <td> <a href="modif_apprenants.php?id=<?php echo($myfile_arr[0])?>"> Exclure </a> </td>
                                <?php
                                    //echo'<td>'.$myfile_arr[7].'</td>';
                        
                        echo'</tr>';
                    }                 
                    $cmpt1 ++;
                    }
                    
                }
                echo'</table>';
            
            ?>
            <!-- <table>
                <tr class="table_head">
                    <td> teste1</td>
                    <td> teste2</td>
                    <td> teste3</td>
                    <td> teste4</td>
                    <td> teste5</td>
                    <td> teste6</td>
                    <td> teste7</td>
                    <td> teste8</td>
                </tr>
                <tr>
                    <td> teste1</td>
                    <td> teste2</td>
                    <td> teste3</td>
                    <td> teste4</td>
                    <td> teste5</td>
                    <td> teste6</td>
                    <td> teste7</td>
                    <td> teste8</td>
                </tr>
            </table> -->
            <p class="error"> <?php echo ($err) ?> </p>
        </div>
    </div>


</body>
</html>