<?php

@$db = new mysqli('localhost','root','',"travel");
$db->set_charset('utf8');
if(mysqli_connect_errno()){

    echo '<p>Error:Could not connect to database.<br/>
              Please try again later.</p>';
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 14</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />



    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />

</head>

<body>
<?php include 'header.inc.php'; ?>



<!-- Page Content -->
<main class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Filters</div>
        <div class="panel-body">

            <form action="Lab10.php" method="get" class="form-horizontal">
                <div class="form-inline">
                    <select name="continent" class="form-control">
                        <option value="0">Select Continent</option>
                        <?php


                        $query = "SELECT * FROM `continents`" ;
                        $result =$db->query($query);
                        while($row = $result->fetch_assoc()) {
                            echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
                        }
                        $continent=$_GET['continent'];
                        ?>
                    </select>

                    <select name="country" class="form-control">
                        <option value="0">Select Country</option>
                        <?php
                        $query = "SELECT * FROM `countries`" ;
                        $result =$db->query($query);
                        while($row = $result->fetch_assoc()) {
                            echo '<option value=' . $row['ISO'] . '>' . $row['CountryName'] . '</option>';
                        }
                        $country=$_GET['country'];
                        $title=$_GET['title'];

                        ?>
                    </select>
                    <input type="text"  placeholder="Search title" class="form-control" name=title>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>

        </div>
    </div>


    <ul class="caption-style-2">

        <?php


        if(!isset($continent)&&!isset($country)&&!isset($title)) {
            $query = "SELECT * FROM `imagedetails` ";
            $result = $db->query($query);
            $rows=array();
            while($row = $result->fetch_assoc()){
                $rows[]=$row;
            }
            display($rows);
        }
        else if($continent!='0'&&$country=='0'&&$title==''){
            $query = "SELECT * FROM `imagedetails` WHERE ContinentCode='$continent' " ;
            $result =$db->query($query);
            $rows=array();
            while($row = $result->fetch_assoc()){
                $rows[]=$row;
            }
            display($rows);
        }
        else if($continent=='0'&&$country!='0'&&$title==''){
            $query = "SELECT * FROM `imagedetails` WHERE CountryCodeISO='$country'" ;
            $result =$db->query($query);
            $rows=array();
            while($row = $result->fetch_assoc()){
                $rows[]=$row;
            }
            display($rows);
        }
        else if($continent!='0'&&$country!='0'&&$title==''){
            $query = "SELECT * FROM `imagedetails` WHERE  ContinentCode='$continent' AND CountryCodeISO='$country'" ;
            $result =$db->query($query);
            $rows=array();
            while($row = $result->fetch_assoc()){
                $rows[]=$row;
            }
            display($rows);
        }
        else if($title!=''){
//            $result00=0;
//            $title01="SELECT CountryCodeISO FROM `countries` WHERE  CountryName='$title' ";
//            $result01 =$db->query($title01);
//            while($row = $result01->fetch_assoc()){
//                if($row){
//                    $result00=$row;
//                }
//            }
//            $title02="SELECT Continenet FROM `continents` WHERE  ContinentsName='$title' ";
//            $result02 =$db->query($title02);
//            while($row = $result02->fetch_assoc()){
//                if($row){
//                    $result00=$row;
//                }
//            }

            $query = "SELECT * FROM `imagedetails` WHERE  ContinentCode='$title' OR CountryCodeISO='$title'" ;
            $result =$db->query($query);
            $rows=array();
            while($row = $result->fetch_assoc()){
                $rows[]=$row;
            }
            display($rows);
        }


        function display($rows){
            foreach ($rows as $row) {
                echo "
            <li>
              <a href='detail.php?id=????' class='img-responsive'>
                <img src='images/square-medium/$row[Path]' alt='????'>
                <div class='caption'>
                  <div class='blur'></div>
                  <div class='caption-text'>
                    <p>$row[Title]</p>
                  </div>
                </div>
              </a>
            </li>
            ";
            }

}
        ?>
    </ul>

</main>

<footer>
    <div class="container-fluid">
        <div class="row final">
            <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
            <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
        </div>
    </div>


</footer>


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
