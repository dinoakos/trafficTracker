<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic tracker</title>
    <!--<link rel="stylesheet" href="https://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" /> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./website/stylesheet.css">
</head>

<body>


    <div class="container" id="bodyCont">
        <div class="row" id="welcome">
            <h1>Welcome to Traffic Tracker!</h1>
        </div>
        <div class="row gx-4" id="rowCont">
            <div class="col-md-8 style='border: 1px solid red">
                <div id="map"></div>
            </div>

            <div class="col-md-4 style='border: 1px solid red">
                <form method='post'>
                    <table cellpadding="1" id="ui">
                        <tbody>

                            <tr id="iPLab">
                                <td>From date</td>
                                <td>To date</td>
                                <td>From time</td>
                                <td>To time</td>
                                <td>Day</td>
                            </tr>
                            <tr>
                                <td><input type="date" id="startDate" name="date-start" /></td>
                                <!-- value="2023-01-01" min="2023-01-01" max="2023-12-31" -->
                                <td><input type="date" id="endDate" name="date-end" /></td>
                                <!-- value="2023-01-01" min="2023-01-01" max="2023-12-31" -->
                                <td><input type="time" id="time1" name="timeFrom" /></td>
                                <td><input type="time" id="time2" name="timeTo" /></td>
                                <td>
                                    <select id="weekDay" name="DayOfWeek">
                                        <option value="" disabled selected>Select a day</option>
                                        <option value="2">Monday</option>
                                        <option value="3">Tuesday</option>
                                        <option value="4">Wednesday</option>
                                        <option value="5">Thursday</option>
                                        <option value="6">Friday</option>
                                        <option value="7">Saturday</option>
                                        <option value="1">Sunday</option>

                                    </select>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <hr style="width: 135%;">

                    <input type="text" id="streetSearch" placeholder="Search for a street" title="Type in an address"
                        style="border-radius: 10px; width: 135%;" name="Street">
                    <!--Replace this with Nominatim implementation-->

                    <hr style="width: 135%;">

                    <input type="submit" style="width: 135%;" name="switch" value="Switch to directional view">

                    <hr style="width: 135%;">

                    <input type="submit" style="width: 135%;" name='submit' value="search">
                </form>
            </div>


        </div>
    </div>




    <!--<script src="https://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>  -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

    <script src="./website/index.js"></script>

</body>

</html>

<?php

$DBPW = getenv('DBPW');


try {
    $conn = new PDO("sqlsrv:server = tcp:trafficdb.database.windows.net,1433; Database = TrafficDb", "dinoakos", "{$DBPW}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print ("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "dinoakos", "pwd" => $DBPW, "Database" => "TrafficDb", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:trafficdb.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);

if (isset($_POST['submit'])) {

    $start = str_replace("-", ".", $_POST["date-start"]);
    $end = str_replace("-", ".", $_POST["date-end"]);
    echo $_POST["timeFrom"];
    $from = $_POST["timeFrom"];
    $to = $_POST["timeTo"];
    $day = $_POST["DayOfWeek"];
    $street = $_POST["Street"];
    /* //utca delete
    if (!empty($street) &&  empty($start) &&  empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE Street='$street'";
        $getResults = sqlsrv_query($conn, $tsql); 
    }
    //test Monday with street dlete
    if (!empty($street) &&  empty($start) &&  empty($end) &&  empty($from) &&  empty($to) &&  !empty($day)) {
        echo $day;
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DATEPART(weekday ,DataDate) = $day AND Street='$street'";
        $getResults = sqlsrv_query($conn, $tsql); 
    }
   
    //1. 2023.01.01-2023.01.02
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate => CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    
    //2. 2023.01.01 12:00 - 2023-01-02 13:00
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  !empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }

    //3. 2023.01.01 12:00 - 2023-01-02
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  !empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //4. 2023.01.01  - 2023-01-02 12:00
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //5.From Date : 2023.01.01
    if (empty($street) &&  !empty($start) &&  empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate => CONVERT(datetime,'$start')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //6.To Date : 2023.01.01
    if (empty($street) &&  empty($start) &&  !empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate < CONVERT(datetime,'$end')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //7.From Date : 2023.01.01 12:00
    if (empty($street) &&  !empty($start) &&  empty($end) &&  !empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from'";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //8.To Date : 2023.01.01 12:00
    if (empty($street) &&  empty($start) &&  !empty($end) &&  empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //9.From time : 12:00
    if (empty($street) &&  empty($start) &&  empty($end) &&  !empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from'";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //10.To time : 12:00
    if (empty($street) &&  empty($start) &&  empty($end) &&  empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }

    //Mondays

    //1. 2023.01.01-2023.01.02 Monday
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate => CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    
    //2. 2023.01.01 12:00 - 2023-01-02 13:00 Monday
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  !empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }

    //3. 2023.01.01 12:00 - 2023-01-02 Monday
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  !empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //4. 2023.01.01  - 2023-01-02 12:00 Monday
    if (empty($street) &&  !empty($start) &&  !empty($end) &&  empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //5.From Date : 2023.01.01 Monday
    if (empty($street) &&  !empty($start) &&  empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate => CONVERT(datetime,'$start')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //6.To Date : 2023.01.01 Monday
    if (empty($street) &&  empty($start) &&  !empty($end) &&  empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate < CONVERT(datetime,'$end')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //7.From Date : 2023.01.01 12:00 Monday
    if (empty($street) &&  !empty($start) &&  empty($end) &&  !empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate > CONVERT(datetime,'$start') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from'";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //8.To Date : 2023.01.01 12:00 Monday
    if (empty($street) &&  empty($start) &&  !empty($end) &&  empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DataDate < CONVERT(datetime,'$end') AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //9.From time : 12:00 Monday
    if (empty($street) &&  empty($start) &&  empty($end) &&  !empty($from) &&  empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] WHERE DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from'";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    }
    //10.To time : 12:00 Monday
    if (empty($street) &&  empty($start) &&  empty($end) &&  empty($from) &&  !empty($to) &&  empty($day)) {
        $tsql = "SELECT X_cord,Y_cord FROM [dbo].[TrafficD] DATEPART(HOUR,CONVERT(DateTime,DataDate)) <= DATEPART(HOUR, '$to')";
        $getResults = sqlsrv_query($conn, $tsql); 
        echo $start;
    } */

    $starter = "SELECT X_cord,Y_cord,SubType FROM [dbo].[TrafficD] WHERE 1=1 ";

    if (!empty($street)) {
        $streetQuerry = " AND Street='$street'";
    }
    if (!empty($start)) {
        $startQuerry = " AND DataDate >= CONVERT(datetime,'$start')";
    }
    if (!empty($end)) {
        $endQuerry = " AND DataDate < CONVERT(datetime,'$end')";
    }
    if (!empty($from)) {
        $fromQuerry = " AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) >= DATEPART(HOUR, '$from')";
    }
    if (!empty($to)) {
        $toQuerry = " AND DATEPART(HOUR,CONVERT(DateTime,DataDate)) < DATEPART(HOUR, '$to')";
    }
    if (!empty($day)) {
        $dayQuerry = " AND DATEPART(weekday ,DataDate) = $day";
    }
    echo "{$starter}{$streetQuerry}{$startQuerry}{$endQuerry}{$fromQuerry}{$toQuerry}{$dayQuerry}";
    $tsql = "{$starter}{$streetQuerry}{$startQuerry}{$endQuerry}{$fromQuerry}{$toQuerry}{$dayQuerry}";
    $getResults = sqlsrv_query($conn, $tsql);


    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $resultY = $row['Y_cord']; //47
        $resultX = $row['X_cord']; //21
        
        if ($row['SubType'] == 	"Beállt a forgalom") {
            echo "<script type='text/JavaScript'>  
            L.circle([$resultY, $resultX],10,{
            stroke: false,
            color  : '#ff0000',
            fillOpacity: 0.87,}).addTo(map);
            </script>";
        }

        if ($row['SubType'] == 	"Torlódás nagy forgalommal") {
            echo "<script type='text/JavaScript'>  
            L.circle([$resultY, $resultX],10,{
            stroke: false,
            color  : '#f7ff02',
            fillOpacity: 0.87,}).addTo(map);
            </script>";
        }
        
        if ($row['SubType'] == 	"Torlódás mérsékelt forgalommal") {
            echo "<script type='text/JavaScript'>  
            L.circle([$resultY, $resultX],10,{
            stroke: false,
            color  : '#00ff00',
            fillOpacity: 0.87,}).addTo(map);
            </script>";
        }
    }
}


sqlsrv_free_stmt($getResults);



?>