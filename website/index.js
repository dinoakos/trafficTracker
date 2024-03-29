var map = L.map('map').setView([47.5310, 21.6247], 12);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    minZoom:0,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
L.circle([47.5310, 21.6247],400,{
    stroke: false,
    color  : '#ff4433',
    fillOpacity: 0.7,}).addTo(map);
