var Guess_maxNum = 50;
var Guess_minNum = 0;
var Guess_count = 0;
var Guess_super_password = Math.floor(Math.random()*100%50);

function guess_number(pelement){
	guessButton.src=pettie.url + "images/guessButton_click.png";
	setTimeout('guessButton.src=pettie.url + "images/guessButton.png";',100);
	
	if((document.getElementById("password").value <= Guess_minNum)||(document.getElementById("password").value >= Guess_maxNum)){
		console.log("The value should be in the range of Min. and Max. number.");
	}
	console.log(document.getElementById("password").value <= Guess_minNum);
	if(document.getElementById("password").value <= Guess_minNum){
		alert("The value should greater than "+ Guess_minNum);
	}
	if(document.getElementById("password").value >= Guess_maxNum){
		alert("The value should less than "+ Guess_maxNum);
	}
	else if((document.getElementById("password").value < Guess_super_password)&&(document.getElementById("password").value > Guess_minNum)){
		Guess_minNum=parseInt(document.getElementById("password").value);
		Guess_count = Guess_count + 1;
		if(Guess_count==10){
			console.log("Game over win 1");
			alert("You win and got 5 exp.");
			Guess_minNum = 0;
			Guess_maxNum = 50;
			Guess_super_password = Math.floor(Math.random()*100%50);
			pettie.pet.exercise(5);
			$("#dialog").remove();
		}
	}else if((document.getElementById("password").value > Guess_super_password)&&(document.getElementById("password").value < Guess_maxNum)){
		Guess_maxNum=parseInt(document.getElementById("password").value);
		Guess_count = Guess_count + 1;
		if(Guess_count==10){
			console.log("Game over win 1");
			alert("You win and got 5 exp.");
			Guess_super_password = Math.floor(Math.random()*100%50);
			pettie.pet.exercise(5);
			$("#dialog").remove();
		}
	}else if(document.getElementById("password").value == Guess_super_password){
		if(Guess_count<10){
			console.log("Game over lose");
			alert("You lose!");
			//alert("You guess for"+" "+count+" "+"time");
			Guess_super_password = Math.floor(Math.random()*100%50);
			pettie.pet.exercise(1);
			$("#dialog").remove();
		}	
		Guess_minNum = 0;
		Guess_maxNum = 50;
	}
	if(Guess_maxNum-Guess_minNum ==2){
		console.log("Game over win 2");
		alert("You got a perfect win and got 5 exp.");
		Guess_minNum = 0;
		Guess_maxNum = 50;
		Guess_super_password = Math.floor(Math.random()*100%50);
		pettie.pet.exercise(5);
		$("#dialog").remove();
	}
	document.getElementById("password").value="";
	document.getElementById("minLabel").innerHTML = Guess_minNum;
	document.getElementById("maxLabel").innerHTML = Guess_maxNum;
}


PetInfosubmit = function (){
	pettie.post(pettie.url+"api/pet/pet_edit/",{father:$("#father").val(),mother:$("#mother").val(),Spouse:$("#Spouse").val(),Birthplace:$("#Birthplace").val(),Introduction:$("#Introduction").val()})
	alert("Profile edited success.");
}
/*
$('.flip-card').click(function () {
	if ($(this).attr('face') == 'front') {
		$(this).css('-webkit-transform', 'rotateY(-180deg)');
		$(this).attr('face', 'back');
		$(".front").css("display", "none");
		$(".back").css("display", "block");
	}else {
		$(this).css('-webkit-transform', 'rotateY(0deg)');
		$(this).attr('face', 'front');
	$(".front").css("display", "block");
		$(".back").css("display", "none");
	}
	});
*/
