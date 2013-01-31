var init_catch = function() {
    if(!$('#Catch_myCanvas').tagcanvas({
        reverse: true,
        depth: 0.5,
        maxSpeed: 1,
        radiusX: 1,
        radiusY: 1,
        radiusZ: 1,
        zoomStep : 0.01,

    },'Catch_tags')) {
    
        // something went wrong, hide the canvas container
        $('#Catch_myCanvasContainer').hide();
    }
	$("#Catch_tags").mouseenter(function () {console.log(Catch_numClick);});
    
};

var Catch_numClick = 0;
var expPt = 0.1;

function Catch_grab(){
	Catch_numClick++;
	console.log(Catch_numClick);
}

function Catch_time(){
	setTimeout('Catch_timeup()', 60*1000);
}
function Catch_timeup()
{
	window.pet.increaseExp(expPt);
	windows.pet.decreaseSatiation(satiation);
}
