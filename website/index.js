var map = L.map('map').setView([47.5310, 21.6247], 12);
var hotspotView=1;
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    minZoom:0,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

/* L.circle([47.5310, 21.6247],400,{
    stroke: false,
    color  : '#ff4433',
    fillOpacity: 0.7,}).addTo(map);

L.circle([47.4310, 21.6247],400,{
    stroke: false,
    color  : '#ff1234',
    fillOpacity: 0.7,}).addTo(map); */
function viewTog(){
    if(hotspotView==1){
        document.getElementById("switch").innerText("Switch to hotspot view");
        hotspotView=0;
    }else{
        document.getElementById("switch").innerText("Switch to directional view");
        hotspotView=1;
    }
}