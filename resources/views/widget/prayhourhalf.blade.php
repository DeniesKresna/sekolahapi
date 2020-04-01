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
		<div style="width: 70px;">
			<div>
				<table>
					<tr>
						<td style="font-size: 1px;">Dhr</td>
						<td style="font-size: 1px;">{{$Dhuhr}}</td>
					</tr>
					<tr>
						<td style="font-size: 1px;">Asr</td>
						<td style="font-size: 1px;">{{$Asr}}</td>
					</tr>
					<tr>
						<td style="font-size: 1px;">Mgb</td>
						<td style="font-size: 1px;">{{$Maghrib}}</td>
					</tr>
					<tr>
						<td style="font-size: 1px;">Isya</td>
						<td style="font-size: 1px;">{{$Isha}}</td>
					</tr>
				</table>
			</div><!--
			<div style="font-size: 1px; background-color:blue; margin-top:0.5px;">
				latest football information
			</div>-->
		</div><!--
		<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>-->
	</body>
</html>