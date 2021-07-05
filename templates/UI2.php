<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Prediction</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href= "{{ url_for('static',filename='styles/UIStyle.css') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<div class="header">
		<div class="header-left">
			<h3>Speech Emotion Recognition</h3>
		</div>
		<div class="flow"></div>
		<div class="header-right">
			<a href=""><i class="fa fa-info-circle"></i></a>
		</div>
	</div>
	<div class="container">
		<div class="left">
		<form  method="POST" id="myForm" enctype="multipart/form-data">
  			<h4 >Select an audio file:</h4><br><br>
  			<input type="file" id="myFile" name="file"><br><br>
  			<button type="button" onclick="myFunction()">Submit</button>
  			<!-- <input onclick="myFunction()" type="submit"> -->
		</form>
		<div class="showName">
			<p id="demo"></p>
<!--			<p >-->
<!--				<audio id="audio" controls="controls" autoplay>-->
<!--					<source id="sourceAudio" src="" type="audio/wav">-->
<!--				</audio>-->
<!--			</p>-->
		</div>
		<div class="showResult">
			<p id="result">{{content}}</p>
		</div>
		</div>

		<div class="box">
				<br>
				<br>
			<h1>Disclaimer</h1>
			<br>
			<br>
			<p style="font-weight: bold; color: #f9ebeb;">Please upload all files in the .wav format or else use the below link to convert other file formats to .wav format</p>
			<br>
			<div class="content">
				<br>
		   		 <a href="https://mp3towave.com/">CONVERTER</a>
		    </div>
		</div>
	</div>
	<div class="footer">
		<h4>Supritha M Bhatt</h4>
		<h4>Yashaswini M K</h4>
		<h4>Vinutha Vishwanatha Devadiga</h4>
		<h4>Shravya M S</h4>
	</div>


	<script>
function myFunction() {
  	var form_data = new FormData($('#myForm')[0]);
  	console.log(form_data);
  	var x = document.getElementById("myFile").value;
  	document.getElementById("demo").innerHTML = x;
 	var len = x.length;
 	var ext = x.slice(len - 4, len);
 	if(ext.toUpperCase() == ".WAV"){
   		//var audio = document.getElementById('audio');
   		var ary=x.split("\\");
   		//document.getElementById("sourceAudio").setAttribute('src', ary[2]);
   		//console.log(document.getElementById("sourceAudio").src);
   		//audio.load();
   		//audio.play();
		$.ajax({
			type: 'POST',
            url: "/callPredictor",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log('Success!');
                console.log(data);
                document.getElementById("result").innerHTML = data;
            },
		});
 	}
 	else{
   		formOK = false;
   		alert("Only .wav files allowed.");
 	}
}
</script>	
</body>
</html>