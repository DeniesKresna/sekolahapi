<html>
	<head>
		    <!-- Compiled and minified CSS -->
		    <link rel="stylesheet" href="{{asset('/font-awesome/css/font-awesome.min.css')}}">
		    <style>
		    	* {
				    margin: 0;
				    padding: 0;
				} 
				div {
					margin: 0;
				    padding: 0;
				}
				span {
					margin: 0;
				    padding: 0;
				}
		    	table{
		    		border-collapse: initial;
		    	}
		    </style>	    
	</head>
	<body style=" background-color:#004d40; color: white; padding:0px">
		<div style="width: 130px;">
			<div style="font-size: 1px; background-color:blue;">
				<marquee behavior="scroll" direction="left" scrolldelay="500">
					Jam Sholat: Subuh: {{$Fajr}} - Dhuha: {{$Sunrise}} - Dzuhur: {{$Dhuhr}} - Ashr: {{$Asr}} - Maghrib: {{$Maghrib}} - Isya: {{$Isha}}
				</marquee>
			</div>
		</div><!--
		<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>-->
	</body>
</html>