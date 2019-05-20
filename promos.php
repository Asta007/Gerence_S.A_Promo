<?php 
ini_set("display_errors",1);
$class_name = "";
$last_id = 0;

    // $opened = fopen("promos.txt","r");
    //     while(!feof($opened)){
    //         $line = fgets($opened);
    //         $myfile_arr = explode(',',$line);
    //         $last_id = $myfile_arr[0];
    //     }
    // fclose($opened);
    $id_add_promos = file_get_contents("id_promos.txt");

if(isset($_POST['sub_promo_ajout'])){
    $id = $id_add_promos + 1;
    $nom = ($_POST['nom']);
    $mois = ($_POST['mois']);
    $an = ($_POST['an']);

    if(($nom == "") or ($an == "")){
        $err = "Veillez remplir tout les champs";
    }
    else{
        $opened = fopen("promos.txt","a+");
        $the_text = $id.",".$nom.",".$mois.",".$an.",1\n";
        fwrite($opened,$the_text);
        fclose($opened);
        file_put_contents("id_promos.txt",$id);
    }
    header("location:promos.php");

}

if(isset($_POST['sub_promo_modif'])){
    $id = ($_POST['id']);
    $nom = ($_POST['nom']);
    $mois = ($_POST['mois']);
    $an = ($_POST['an']);

    if(($nom == "") or ($an == "")){
        $err = "Veillez remplir tout les champs";
    }
    else{
        $opened = fopen("promos.txt","a+");
        while(!feof($opened)){
            $line = fgets($opened);
            if($line != ""){
                $line_arr = explode(',',$line);
                if($line_arr[0] == $id ){
                    ($line_arr[1] = $nom);
                    ($line_arr[2] = $mois);
                    ($line_arr[3] = $an);

                    $newline = $id.",".$nom.",".$mois.",".$an.",1"."\n";
                }
                else{
                    $newline = $line;
                }

                $content .= $newline;
            }
            
        }

        file_put_contents("promos.txt",$content);
        fclose($opened);
    }
    header("location:promos.php");

}

if(isset($_POST['submit_aff'])){
    $class = ($_POST['promos']);
    $opened = fopen("promos.txt","r");
        while(!feof($opened)){
            $line = fgets($opened);
            $myfile_arr = explode(',',$line);
            if($myfile_arr[0] == $class){
                $class_name = $myfile_arr[1];
            }
        }
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
        <h1> Promotion </h1>
        <div id="nav">
            <a href="index.php"> Home </a>
            <a href="ajout_apprenant.php"> Apprenant </a>
            <a href="promos.php"> Promo </a>
        </div>
    </div>

    <div id="content_body">
            <div class="form_promos">  
                <h2 class="form_title"> Ajouter Promo </h2>
                <form action="#" method="POST">
                    
                    <label for="nom"> Nom </label> <br>
                    <input type="text" name="nom"> <br>

                   <label for="mois"> Mois </label>
                    <select name="mois" id="">
                       <option value="janvier"> Janvier </option>
                       <option value="fevier"> Fevrier </option>
                       <option value="mars"> Mars </option>
                       <option value="avril"> Avril </option>
                       <option value="mais"> Mais </option>
                       <option value="juin"> Juin </option>
                       <option value="juillet"> Juiller </option>
                       <option value="aout"> Aout </option>
                       <option value="septembre"> Septembre </option>
                       <option value="octobre"> Octobre </option>
                       <option value="novembre"> Novembre </option>
                       <option value="decembre"> Decembre </option>
                   </select>

                   <label for="an"> Année </label> <br>
                    <input type="number" name="an"> <br>

                    <input type="submit" name="sub_promo_ajout" value="Ajouter">
                </form>
            </div>

            <div id="tables_promos">
                <?php
                    $opened = fopen("promos.txt","r");
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
                                echo'</tr>';
                            }
                            else{
                                echo('<tr>');
                                    $promo ="P00".$myfile_arr[0];
                                    echo'<td>'.$promo.'</td>';
                                    echo'<td>'.$myfile_arr[1].'</td>';
                                    echo'<td>'.$myfile_arr[2].'</td>';
                                    echo'<td>'.$myfile_arr[3].'</td>';
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
            </div>

            <div class="form_promos">
                <h2 class="form_title"> Modifier un promo </h2>
                <form action="#" method="POST">
                <label for="id"> Id </label> <br>
                        <select name="id" id="">
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

                    <label for="nom"> Nom </label> <br>
                    <input type="text" name="nom"> <br>

                   <label for="mois"> Mois </label>
                    <select name="mois" id="">
                       <option value="janvier"> Janvier </option>
                       <option value="fevier"> Fevrier </option>
                       <option value="mars"> Mars </option>
                       <option value="avril"> Avril </option>
                       <option value="mais"> Mais </option>
                       <option value="juin"> Juin </option>
                       <option value="juillet"> Juiller </option>
                       <option value="aout"> Aout </option>
                       <option value="septembre"> Septembre </option>
                       <option value="octobre"> Octobre </option>
                       <option value="novembre"> Novembre </option>
                       <option value="decembre"> Decembre </option>
                   </select>

                   <label for="an"> Année </label> <br>
                    <input type="number" name="an"> <br>

                    <input type="submit" name="sub_promo_modif" value="Modifier">
                </form>
            </div>

        <hr>

        <div id="listin">
            <form action="#" method="POST">
                <select name="promos" id="">
                    <option value="0"> Choisissez </option>
                    <?php
                        $cmpt1 = 0;
                        $opened = fopen("promos.txt","r");
                        while(!feof($opened)){
                            $line = fgets($opened);
                            $myfile_arr = explode(',',$line);
                            if(($myfile_arr[0] != "Id") and ($line != "")){
                                $the_name = $myfile_arr[1];
                                $the_id = $myfile_arr[0];
                                ?>
                                    <option value="<?php echo($the_id)?>">
                                        <?php echo($the_name)?>
                                    </option>
                                <?php
                            }
                        }
                    ?>
                </select>
                <input type="submit" value="Afficher" name="submit_aff">
            </form>

            <p class="par_promos">
                <!-- Liste des apprenants de la Promo, -->
                <?php echo $class_name ?>
            </p>
            <div id="tables_par_promos">
    
                <?php
                if(isset($_POST['submit_aff'])){
                    $class = ($_POST['promos']);
                    $opened = fopen("apprenants.txt","r");
                    echo'<table>';
                    $cmpt1=0;
                    $nbr = 0;
                    while(!feof($opened)){
                        $line = fgets($opened);
                        if($line != ""){
                            $myfile_arr = explode(',',$line);
                        if($cmpt1 == 0){
                            echo('<tr class = "table_head">');
                                echo'<td>'.$myfile_arr[0].'</td>';
                                echo'<td>'.$myfile_arr[2].'</td>';
                                echo'<td>'.$myfile_arr[3].'</td>';
                                echo'<td>'.$myfile_arr[4].'</td>';
                                echo'<td>'.$myfile_arr[5].'</td>';
                                echo'<td>'.$myfile_arr[6].'</td>';
                            echo'</tr>';
                        }
                        else if($myfile_arr[1] == $class){
                            $nbr ++;
                            echo('<tr>');
                                echo'<td>'.$myfile_arr[0].'</td>';
                                echo'<td>'.$myfile_arr[2].'</td>';
                                echo'<td>'.$myfile_arr[3].'</td>';
                                echo'<td>'.$myfile_arr[4].'</td>';
                                echo'<td>'.$myfile_arr[5].'</td>';
                                echo'<td>'.$myfile_arr[6].'</td>';
                            
                            echo'</tr>';
                        }                 
                        $cmpt1 ++;
                        }
                        
                    }
                    echo'</table>';
                    echo'<p class="nbr">'."Cette promotion compte ".$nbr." apprenants".'</p>';
                }
                ?>

            </div>
        </div>

    </div>

</body>
</html>