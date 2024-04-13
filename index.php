<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic tracker</title>
    <link rel="stylesheet" href="https://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
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
                            <td><input type="time" id="time1" name="timeFrom" /></td>
                            <td>
                                <select id="weekDay" name="DayOfWeek">
                                    <option value="None">---</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>

                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr style="width: 135%;">

                <input type="text" id="streetSearch" placeholder="Search for a street" title="Type in an address"
                    style="border-radius: 10px; width: 135%;"> <!--Replace this with Nominatim implementation-->

                <hr style="width: 135%;">

                <button style="width: 135%;">Switch to directional view</button>

                <hr style="width: 135%;">

                <button style="width: 135%;">Search</button>

            </div>

        </div>
    </div>



    <script src="https://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
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
   
     echo ("test");
   
?>
