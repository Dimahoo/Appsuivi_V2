<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
include 'includes/conn.php';
// Reset error message
$_SESSION['message'] = '';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$data1 =  '[{"label":"","value":"0"}]';
$data2 =  '[{"label":" ","value":"0"}]';
$data3 = '{"description":" ", count:0}';


if($_SESSION['admin'] == 1) {

    //query to get data from the table
    $query = "select role, count(*) as count from benevole group by role order by id asc";

    //execute query
    $result1 = mysqli_query($conn, $query) or die(mysqli_error());

    //query to get data from the table
    $query = "select count(*) as count from client";

    //execute query
    $result2 = mysqli_query($conn, $query) or die(mysqli_error());

    //loop through the returned data
    $rolevalues1 = array();
    $rolevalues2 = '';
    $clientnumber = array();

    while($row = mysqli_fetch_array($result1)) {

        $rolevalues1[] = array(
            'label'   =>  $row["role"],
            'value'   =>  $row["count"]
        );
        $rolevalues2 .= "{ role:'".$row["role"]."', count:".$row["count"]."}, ";
    }

    while($row = mysqli_fetch_array($result2)) {

        $clientnumber[] = array(
            'label'   =>  "Nbr Clients",
            'value'   =>  $row["count"]
        );
    }

    //free memory associated with result
    $result1->close();
    $result2->close();

    //now print the data
    $data1 = json_encode($clientnumber);
    $data2 = json_encode($rolevalues1);
    $data3 = substr($rolevalues2, 0, -2);
}

if($_SESSION['admin'] == 0) {

    $id_interv = $_SESSION['id'];

    //query to get data from the table
    $query = "select count(*) as count from client where id_interv='$id_interv'";

    //execute query
    $result3 = mysqli_query($conn,$query) or die(mysqli_error());

    $clinumbinterv = array();

    while($row = mysqli_fetch_array($result3)) {

        $clinumbinterv[] = array(
            'label'   =>  " ",
            'value'   =>  $row["count"]
        );
    }

    //free memory associated with result
    $result3->close();

    $data1 = json_encode($clinumbinterv);
}

if($_SESSION['admin'] == 1 or $_SESSION['admin'] == 2) {

    //query to get data from the table
    $query = "select description, count(*) as count from statis group by description order by id asc";

    //execute query
    $result4 = mysqli_query($conn, $query) or die(mysqli_error());

    $statistics = '';

    while($row = mysqli_fetch_array($result4)) {

        $statistics .= "{ description:'".$row["description"]."', count:".$row["count"]."}, ";
    }

    //free memory associated with result
    $result4->close();

    $data3 = substr($statistics, 0, -2);
}

//close connection
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="dist/css/home.css" rel="stylesheet" type="text/css">
    <link href="dist/css/navbar.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="dist/css/jquery-confirm.min.css" rel="stylesheet" />
    <link href="dist/css/morris.css" rel="stylesheet" />
    <link href="dist/css/buttons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="dist/js/jquery.min.js"></script>
    <script src="dist/js/jquery-confirm.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<script>
    if ('<?php echo $_SESSION['addecoute']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle fiche écoute & suivi crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addecoute'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addstatis']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle fiche statistique crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addstatis'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addbene']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle fiche bénevole crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addbene'] = 0 ?>
    }
    if ('<?php echo $_SESSION['addeval']?>' == 1) {
        $.alert({
            title: 'Notification!',
            icon: 'fa fa-warning',
            type: 'orange',
            animation: 'rotate',
            content: 'Nouvelle évaluation crée!',
            buttons: {
                Fermer: function () {
                    this.setCloseAnimation('rotate');
                }
            }
        });
        <?php $_SESSION['addeval'] = 0 ?>
    }
</script>
<body class="loggedin">
<?php include 'includes/navbar.php'; ?>
<div class="content">
    <h2>Acceuil</h2>
</div>
<div class="container">
    <br/>
    <div class="row">
        <div class="col-xs-24 col-md-12 col-lg-6">
            <table class="menu">
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'ecoute.php';" name="ecoute" class="btn btn-primary custom">Fiche Écoute & Suivi</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'listecoute.php';" name="listecoute" class="btn btn-primary">Liste Écoute & Suivi</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverecoute.php';" name="exportecoute" class="btn btn-success">Exporter Écoute & Suivi</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'listclient.php';" name="listeclient" class="btn btn-primary">Liste des Clients</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 0 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverclient.php';" name="exportclient" class="btn btn-success">Exporter Clients</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'migrateclient.php';" name="migrateclient" class="btn btn-primary">Migration des Clients</button></td>
                    <?php }?>
                </tr>
            </table>
        </div>
        <div class="col-xs-24 col-md-12 col-lg-6">
            <table class="dashbord1">
                <tr>
                    <td id="nbrclientchart"><div id="clientNumberchart" class="clientNumberchart"></div></td>
                </tr>
            </table>
        </div>
    </div>
    <hr style="width: 100%;">
    <div class="row">
        <div class="col-xs-24 col-md-12 col-lg-6">
            <table class="menu">
                <tr>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'statistic.php';" name="statistic" class="btn btn-primary">Fiche des Statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'liststatis.php';" name="liststatis" class="btn btn-primary">Liste des Statistiques</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 2 OR $_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverstatis.php';" name="exportstatis" class="btn btn-success">Exporter Statistiques</button></td>
                    <?php }?>
                </tr>
            </table>
        </div>
        <div class="col-xs-24 col-md-12 col-lg-6">
            <table class="dashbord2">
                <tr>
                    <td id="statischart"><div id="statisbarchart" class="statisbarchart"></div></td>
                </tr>
            </table>
        </div>
    </div>
    <hr style="width: 100%;">
    <div class="row">
        <div class="col-xs-24 col-md-12 col-lg-6">
            <table class="menu">
                <tr>
                    <?php if($_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'benevole.php';" name="benevole" class="btn btn-primary">Fiche des Bénevoles</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'listbenevole.php';" name="listebenevole" class="btn btn-primary">Liste des Bénevoles</button></td>
                    <?php }?>
                </tr>
                <tr>
                    <?php if($_SESSION['admin'] == 1) {?>
                        <td><button onclick="window.location.href = 'serverbenevole.php';" name="exportbenevole" class="btn btn-success">Exporter Bénevoles</button></td>
                    <?php }?>
                </tr>
            </table>
        </div>
        <div class="col-xs-24 col-md-12 col-lg-6">
            <table class="dashbord3">
                <tr>
                    <td id="benechart"><div id="numBeneStagchart" class="numBeneStagchart"></div></td>
                </tr>
            </table>
        </div>
    </div>
</div>



<script src="dist/js/morris.min.js"></script>
<script src="dist/js/raphael-min.js"></script>


<script>

    $(document).ready(function () {

        clientNumber();
        adminNumBeneStag();
        statistics();

        $("#nbrclientchart").hide();
        $("#statischart").hide();
        $("#benechart").hide();


        if ('<?php echo $_SESSION['admin']?>' == 1)  {

            $("#benechart").show();
            $("#nbrclientchart").show();
            $("#statischart").show();
        }

        if ('<?php echo $_SESSION['admin']?>' == 2)  {

            $("#statischart").show();
        }

        if ('<?php echo $_SESSION['admin']?>' == 0)  {

            $("#nbrclientchart").show();
        }



        function clientNumber() {

            var cliNumber = Morris.Donut({
                element: 'clientNumberchart',
                data: <?php echo $data1; ?>
            });
        }

        function statistics() {

            var statis_bar_chart = Morris.Bar({
                element: 'statisbarchart',
                data: [<?php echo $data3; ?>],
                xkey: 'description',
                ykeys: ['count'],
                labels: ['count'],
                hideHover: 'auto',
                stacked: true
            });
        }

        function adminNumBeneStag() {

            var numBeneStag = Morris.Donut({
                element: 'numBeneStagchart',
                data: <?php echo $data2; ?>
            });
        }
    });

</script>

</body>
</html>
