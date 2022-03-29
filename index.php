<?php 
    session_start();
    if(!array_key_exists('isConnected', $_SESSION)){
        header('Location: http://www.nicolas-anjorand.com/autobonplan/connexion.php');
    }
    if(isset($_POST['deco'])){
        unset($_SESSION['isConnected']);
        unset($_SESSION['nom']);
        unset($_SESSION['level']);
        header('Location: connexion.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="main.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autobonplan - ARRIVAGE</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <div class="header">
        <div class="jour"><?php setlocale(LC_TIME, 'fr_FR');
        date_default_timezone_set('Europe/Paris');
        echo substr(utf8_encode(strftime('%A %d %B %Y, %H:%M')), 0, -7) ;?></div>
        <div class="nom"><?php echo $_SESSION['nom'];?></div>
        <div class="deconnexion"><form method="post"><input type=submit name="deco" id="deco" value="Déconnexion"></form></div>
    </div>
    <?php 
        use Shuchkin\SimpleXLSX;

        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', true);

        require_once 'xlsx.php';

        if ( $xlsx = SimpleXLSX::parse('xlsx/arrivages.xlsx') ) {
            //echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
            foreach( $xlsx->rows() as $r ) {
                if($r[2]!="Fournisseur"){
                    $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
                    $requete2="SELECT id FROM ARRIVAGE";
                    $result = $co->query($requete2);
                    $dateArrivage=substr($r[45], 6).'-'.substr($r[45], 3, 2).'-'.substr($r[45], 0, 2);
                    $dateMec=substr($r[4], 6).'-'.substr($r[4], 3, 2).'-'.substr($r[4], 0, 2);
                    $dateAchat=substr($r[21], 6).'-'.substr($r[21], 3, 2).'-'.substr($r[21], 0, 2);
                    $dateLivraison=substr($r[49], 0, 10);
                    $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
                    $requete = $co->prepare("INSERT INTO ARRIVAGE values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
                    $requete->bind_param("ssssisssisissisissssisiisiissiisiiisssss",$r[1],$r[2],$r[3],$dateMec,$r[5],$r[6],$r[8],$r[9],$r[10],$r[11],$r[12],$r[13],$r[14],$r[15],$r[16],$r[17],$r[18],$r[19],$r[20],$dateAchat,$r[24],$r[25],$r[26],$r[27],$r[28],$r[29],$r[31],$r[32],$r[34],$r[35],$r[38],$r[39],$r[40],$r[42],$r[43],$r[44],$r[46],$dateLivraison,$dateArrivage,$r[7]);
                    $requete->execute();

                    //$requete = $co->prepare("INSERT INTO ARRIVAGE values (?,?);");
                    //requete->bind_param("id",$id,$dateArrivage);
                    //$requete->execute();*/
                }             
                //echo '<tr><td>'.implode('</td><td>', $r ).'</td></tr>';
            }
            //echo '</table>';
            //1
            //2
        } else {
            echo SimpleXLSX::parseError();
        }

        if (isset($_FILES['file'])) {
            if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {


                foreach ($xlsx->readRows() as $r) {
                    if($r[2]!="Fournisseur"){
                        $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
                        $requete2="SELECT id FROM ARRIVAGE";
                        $result = $co->query($requete2);
                        $dateArrivage=substr($r[45], 6).'-'.substr($r[45], 3, 2).'-'.substr($r[45], 0, 2);
                        $dateMec=substr($r[4], 6).'-'.substr($r[4], 3, 2).'-'.substr($r[4], 0, 2);
                        $dateAchat=substr($r[21], 6).'-'.substr($r[21], 3, 2).'-'.substr($r[21], 0, 2);
                        $dateLivraison=substr($r[49], 0, 10);
                        $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
                        $requete = $co->prepare("INSERT INTO ARRIVAGE values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
                        $requete->bind_param("ssssisssisissisissssisiisiissiisiiisssss",$r[1],$r[2],$r[3],$dateMec,$r[5],$r[6],$r[8],$r[9],$r[10],$r[11],$r[12],$r[13],$r[14],$r[15],$r[16],$r[17],$r[18],$r[19],$r[20],$dateAchat,$r[24],$r[25],$r[26],$r[27],$r[28],$r[29],$r[31],$r[32],$r[34],$r[35],$r[38],$r[39],$r[40],$r[42],$r[43],$r[44],$r[46],$dateLivraison,$dateArrivage,$r[7]);
                        $requete->execute();

                        //$requete = $co->prepare("INSERT INTO ARRIVAGE values (?,?);");
                        //requete->bind_param("id",$id,$dateArrivage);
                        //$requete->execute();*/
                    }
                }
            } else {
                echo SimpleXLSX::parseError();
            }
        }


        $temps = [];
        $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
        $requete3="SELECT dateArrivage FROM ARRIVAGE ORDER BY dateArrivage";
        $result = $co->query($requete3);
        $id=0;
        if ($result) {
            while($row = $result->fetch_assoc()) {
                array_push($temps, $row['dateArrivage']);

            }
        }
        $mois = ['janvier','février','mars','avril','mai','juin','juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        for($i=0; $i<count($temps); $i++){
            $temps[$i] = $mois[intval(substr($temps[$i], 5, 2))-1].' '. substr($temps[$i], 0, 4);
        }
        $temps = array_unique($temps);
        $nombre = [];
        $valeurFournisseur = [];
        $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
        $requete5="SELECT DISTINCT(CONCAT(Year(dateArrivage),' ',Month(dateArrivage))) As Mois, Count(*) As nombre FROM ARRIVAGE GROUP BY Mois ORDER BY Mois;";
        $result = $co->query($requete5);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                array_push($nombre, $row['nombre']);
            }
        }

        $moisAnnee = [];
        $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
        $requete5="SELECT DISTINCT(CONCAT(Year(dateArrivage),' ',Month(dateArrivage))) As Mois FROM ARRIVAGE ORDER BY Mois;";
        $result = $co->query($requete5);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                array_push($moisAnnee, $row['Mois']);
            }
        }


        $fournisseur = [];
        $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
        $requete5="SELECT DISTINCT(fournisseur) from ARRIVAGE;";
        $result = $co->query($requete5);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                array_push($fournisseur, $row['fournisseur']);
            }
        }

        $tabFinal = [];
        for ($i=0; $i < count($fournisseur); $i++) { 
            $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
            $requete5="SELECT DISTINCT(CONCAT(Year(dateArrivage),' ',Month(dateArrivage))) As Mois, Count(*) As nombre, fournisseur FROM ARRIVAGE WHERE fournisseur = '".$fournisseur[$i]."' GROUP BY Mois ORDER BY Mois;";
            $result = $co->query($requete5);
            if ($result) {
                $temp = [];
                $temp2 = [];
                $temp3 = [];
                while($row = $result->fetch_assoc()) {
                    array_push($temp, $row['nombre']);
                    array_push($temp2, $row['Mois']);
                }
                for ($j=0; $j < count($moisAnnee); $j++) {
                    $verif = false; 
                    for($h=0; $h < count($temp); $h++){
                        if($moisAnnee[$j] == $temp2[$h]){
                            $verif = true;
                            array_push($temp3, $temp[$h]);
                        }
                    }
                    if($verif == false) {
                        array_push($temp3, 0);
                    }
                }
                array_push($tabFinal, $temp3);
            }
        }


        ?>
    <div class="grid">
        <div class="graph" id="container"></div>
        <script>
            <?php echo "var tab = '".implode("<>", $temps)."'.split('<>');"; ?>
            <?php echo "var nombre = '".implode("<>", $nombre)."'.split('<>');"; ?>
            <?php echo "var fournisseur = '".implode("<>", $fournisseur)."'.split('<>');"; ?>
            <?php
            function construisTableauJS($tableauPHP, $nomTableauJS){
               echo $nomTableauJS." = new Array();";
               for($i = 0; $i < count($tableauPHP); $i++){
                  if(!is_array($tableauPHP[$i])){
                     echo $nomTableauJS."[".$i."] = ".$tableauPHP[$i].";";
                  }
                  else{
                     construisTableauJS($tableauPHP[$i], $nomTableauJS."[".$i."]");
                  }
               }
               return;
            }
            ?>
            <?php construisTableauJS($tabFinal, "tabFinalJS");?>
            const valeur = nombre.map(str => {
              return Number(str);
            });
            series = [];
            for (i = 0; i < fournisseur.length; i++) {
                series.push({
                    name: fournisseur[i],
                    data: tabFinalJS[i]
                });
            }
            Highcharts.chart('container', {
              chart: {
                type: 'column'
              },
              title: {
                    text: 'Véhicules par fournisseur par mois'
                },
              xAxis: {
                    categories: tab
                },
                yAxis: {
                    title: {
                        text: 'Nombre de véhicules'
                    },
                },
              plotOptions: {
                column: {
                  stacking: 'normal',
                  /*dataLabels: {
                    enabled: true
                  }*/
                }
              },
              series: series
            });
        </script>
        <script>
            // Change the selector if needed
        var $table = $('table.scroll'),
            $bodyCells = $table.find('tbody tr:first').children(),
            colWidth;

        // Adjust the width of thead cells when window resizes
        $(window).resize(function() {
            // Get the tbody columns width array
            colWidth = $bodyCells.map(function() {
                return $(this).width();
            }).get();
            
            // Set the width of thead columns
            $table.find('thead tr').children().each(function(i, v) {
                $(v).width(colWidth[i]);
            });    
        }).resize(); // Trigger resize handler
        </script>
        <div class="tableau">
            <table class="fl-table">
                <thead>
                    <tr>
                        <th>État</th>
                        <th onclick='window.location = "http://www.nicolas-anjorand.com/autobonplan/index.php?tri=marque"'>Marque</th>
                        <th onclick='window.location = "http://www.nicolas-anjorand.com/autobonplan/index.php?tri=modele"'>Modèle</th>
                        <th onclick='window.location = "http://www.nicolas-anjorand.com/autobonplan/index.php?tri=energie"'>Énergie</th>
                        <th onclick='window.location = "http://www.nicolas-anjorand.com/autobonplan/index.php?tri=date"'>Date d'arrivage</th>
                        <th onclick='window.location = "http://www.nicolas-anjorand.com/autobonplan/index.php?tri=fournisseur"'>Fournisseur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
                    if(isset($_GET['tri'])){
                        switch ($_GET['tri']) {
                            case 'marque':
                                $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE ORDER BY marque;";
                                break;
                            case 'modele':
                                $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE ORDER BY modele;";
                                break;
                            case 'energie':
                                $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE ORDER BY energie;";
                                break;
                            case 'date':
                                $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE ORDER BY dateArrivage;";
                                break;
                            case 'fournisseur':
                                $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE ORDER BY fournisseur;";
                                break;
                            
                            default:
                                case 'marque':
                                $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE;";
                                break;
                        }
                    } else {
                        $requete5="SELECT etat, marque, modele, energie, dateArrivage, fournisseur from ARRIVAGE;";
                    }
                    $result = $co->query($requete5);
                    if ($result) {
                        while($row = $result->fetch_assoc()) {
                           echo "<tr><td>".$row['etat']."</td><td>".$row['marque']."</td><td>".$row['modele']."</td><td>".$row['energie']."</td><td>".$row['dateArrivage']."</td><td>".$row['fournisseur']."</td></tr>"; 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="formulaire">
            <?php if($_SESSION['level'] > 1 ){
                echo '<form method="post" enctype="multipart/form-data" class="upload">
          <input type="file" id="file" name="file">
          <p id="file-label">Déposer ici ou cliquer pour choisir un fichier.</p>
          <button type="submit">Déposer le fichier</button>
        </form>';
            }?>
        </div>
        <script>
            $('#file').change(function() {
              var i = $(this).prev('label').clone();
              var file = $('#file')[0].files[0].name;
              document.getElementById('file-label').textContent = file;
            });
        </script>
         <div id="container2" class="graph2"></div>

 <?php 
 $fournisseurListe = [];
 $nombreListe = [];
$co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
$requete5="SELECT COUNT(*) as nombre, fournisseur FROM ARRIVAGE GROUP BY fournisseur; ";
$result = $co->query($requete5);
if ($result) {
    while($row = $result->fetch_assoc()) {
        array_push($fournisseurListe, $row['fournisseur']);
        array_push($nombreListe, $row['nombre']);
    }
}
?>

<script>
<?php echo "var fournisseurListe = '".implode("<>", $fournisseurListe)."'.split('<>');"; ?>
<?php echo "var nombreListe = '".implode("<>", $nombreListe)."'.split('<>');"; ?>
const valeurListe = nombreListe.map(str => {
  return Number(str);
});
var final = [];

for(var i=0; i < fournisseurListe.length; i++) {
  final.push({
      name: fournisseurListe[i],
      y: valeurListe[i]           
  });        
} 
Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Pourcentage des véhicules par fournisseur'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Fournisseur',
        colorByPoint: true,
        data: final
    }]
});
</script>
</div>
    <div class="footer">
        <img src="images/logo.png" href="https://www.autobonplan.com" class="logo">
    </div>
</body>
</html>
