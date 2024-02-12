# Process documentation

## Overview 

The goal of this project is to create a website on which users can interact with a map of the world (because of limited availability of traffic data and because of the scope of this project, only Debrecen will have the features implemented) and see historical traffic data. Many maps include real-time traffic data for example: right now, this and that street is crowded, better not go that way. This site tries to face the problem from a different direction. Instead of relying on the current state of traffic it aims to look at what traffic is usually like at a given location. The website will include a “hotspot view” which will allow a user to see which parts of the city are usually crowded at a given time. There website should also include a search function in which the user could search a specific street and time and the website would show the main direction of traffic (e.g., at 8 am traffic flows mainly inwards towards the city while at 4 pm a similar amount of cars exit the city). 

The website will be a basic HTML/CSS site with a map on one side and a search bar and view selector on the right. The map will be displayed by Leaflet which is an open source JS library made for deploying slippy maps(interactive maps) on websites, it also provides tools for drawing over the map which will be immensely helpful during data visualization.

The map data will be provided by OpenStreetMap which is a community driven project aimed at providing geographic data.

Traffic data will be provided by Waze.
## Current state
In our everyday lives all of us have to deal with traffic at one point or another. Even if someone bikes or walks or takes public transport, they are affected by it. A personal example of mine, which I’m sure many can relate is getting to work, my daily commute is 15 minutes by car without traffic and twice that in morning traffic. To get in on time one day I decided to leave 20 minutes earlier and to my surprise I got there in 15 minutes instead of 30. The traffic that is there at 7:20 is simply non-existent at 7:00. And that is where real time traffic data falls short. There is no convenient way to see when it would be most optimal time to leave. I’m sure many people would find that by leaving ten minutes early they could get to their destination in half the time. 

## Desired state
This website aims to make accessible the data on which users can make informed decisions about their day-to-day time management. The site will have no log in function as it would only make user experience worse. As this is site is not meant for day-to-day usage, it encourages checking something once, when the question arises, and when the site provides the information trying to make our routine trips less of a hassle. The site will have an interactive map, on which the user will be able to zoom in and look at the visualized data on a smaller scale. Upon opening the site, the map won’t have any data displayed, only when the user inputs a desired timeframe and a view option will the map show information. The timeframe can be given either as a complete date (i.e., 20yy-mm-dd , hh:mm) this will of course show how traffic looked like on the given date at the given hour and minutes, or the user can input a weekday, time and a range, (i.e., 20xx-mm-dd-20yy-mm-dd , Weekday, hh:mm) this will show an average of the traffic data that will indicate, for example that in the past six months on every Monday at 8:00 there is a large amount of cars at some points of the city. If the user doesn’t give a full input data will be averaged to at least try to approximate a result. This way a user can decide what data is he interested in. The site intends to help users make their own choices not tell them what they should know or not or influence them on a decision.   
After giving the time, the user will have an option to choose a view, there will be a “hotspot view” which will indicate general information like a red circular overlay will show a large amount of cars with its opacity indicating how severe the traffic is.
Other than hotspot view there will be a “directional view” which will tell you the main direction of the traffic with colored arrows, red meaning heavy traffic, yellow meaning medium and green meaning negligible traffic, the arrow will either point in one direction or appear as two lines without arrow heads, this will display that the amount of cars are no more than 10% apart, so roughly equal.
The site will include a street search function as well which will allow the user to only check the given street.
## Copyright
As OpenStreetMap data falls under “Open Data Commons Open Database License”.
 “OpenStreetMap® is open data, licensed under the Open Data Commons Open Database License (ODbL) by the OpenStreetMap Foundation (OSMF).
You are free to copy, distribute, transmit and adapt our data, as long as you credit OpenStreetMap and its contributors. If you alter or build upon our data, you may distribute the result only under the same licence. The full legal code explains your rights and responsibilities.” 
- https://www.openstreetmap.org/copyright
## Model of the desired product
The goal of the project is to create a site that makes it easy for everyday people to plan their routines more efficiently, using python to approximate the given dataset and pair it to the OpenStreetMap road data. Which will then be visualized based on the needs of the user. For this the following steps must be taken:
* Creating the basic wireframe of the website
* Writing a python code that will generate a simplified graph file of the dataset
* Linking the data to the website
* Implementing the needed features to a satisfactory level

## Feature list

### Interactive map (Slippy map)
A map displayed on the site that will serve as a medium for displaying the requested traffic data allowing the user to zoom and look around the city. Also being in accordance with copyright attributions (Leaflet and OpenStreetMap)
### UI
A readable and user-friendly UI which the visitors of the site can intuitively recognize as an input where they can specify what data they need. The UI will include a search function for streets, a date input and a button which changes the default hotspot view to directional view and back.

### Reducing the Waze dataset
Python code that will take the complex and large amount data and remove all unnecessary nodes from the graph. Reasoning for this is that if at the end of the street there is traffic then logically the whole street has traffic and including it would only make the site slower and more resource intensive.
### Time and date specification
In the UI the user will have the option to give timeframe they want to specify, and the site will display that data only. The specification will be pretty loose considering the user will be able to input just about any information and the site will “try it’s best” to give results. Examples:
- 2023-01-01: the site will show all of Debrecen and display the hotspots around the city, the traffic data will be averaged so for any given node all timestamps from that day will be included. This will of course reduce accuracy but even this data can be useful for the user so they should have the option to see it.
- 2023-01-01 – 2023-02-1: Same with the single date but will average the result day by day.
- 2023-01-01 ; 12:00: Only data from 2023 January 1st at noon will be displayed
- 2023-01-01 – 2023-02-01 ; 12:00: the result with the timestamp of noon will be averaged from January 1st to February 1st.
- 12:00: All data will be used but only with the timestamp of noon.
- Monday: All available data origination from a Monday will be used.
- Monday 12:00: All available data origination from a Monday with a timestamp of noon will be used.
- 2023-01-01 – 2023-02-01 Monday: All data which originates from a Monday between January 1st and February 1st will be averaged.


### Hotspot view(default)
This view will show a red circular overlay over the map where the traffic data indicates a large number of vehicles. The opacity of the overlay will indicate how intense the traffic is.

### Directional view
This view will show in which direction does the traffic travel towards. This will be useful considering how often we see that on one side of the road there is bumper-to-bumper traffic and other side of the road is empty. This will allow the user to see whether the traffic would even affect them.
### Street search
The street search function will allow the user to find a specific street without having to find it on the map. Just enter the address and the map will automatically zoom and pan there allowing the user to view traffic without having to fiddle with the map trying to find the location they are interested in.
  
## Dictionary

JavaScript - JavaScript is a programming language which allows us to create dynamic websites. The language is easy to pick up, widely used and supported by all modern browsers. 

Python - Python is a scripting language which works well with large sets of data and will allow us to simplify our traffic data.

OpenStreetMap - OpenStreetMap is a free, editable map of the whole world that is being built by volunteers largely from scratch and released with an open-content license.

Leaflet - Leaflet is the leading open-source JavaScript library for mobile-friendly interactive maps. Weighing just about 42 KB of JS, it has all the mapping features most developers ever need. 
