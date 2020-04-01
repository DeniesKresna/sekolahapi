<html>
	<head>
		    <!-- Compiled and minified CSS -->
		    <!--<link rel="stylesheet" href="{{asset('/font-awesome/css/font-awesome.min.css')}}">-->
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
			<div style="font-size:0.7px;">{{ date("M d, Y") }}</div>
			<div>
				<table>
					<tr>
						<td colspan="2" text-align="center"><img src="{{ $condition_icon }}" width="13px"></td>
						<td style="font-size: 0.5px;">
							{{ $temp_c }} ℃
						</td><!--
						<td text-align="left">
							<i style="font-size: 0.5px;" class="fa fa-thermometer"></i>
						</td>-->
					</tr>
					<tr>
						<td colspan="4" style="font-size: 0.2px;">{{ $condition_text }}</td>
					</tr><!--
					<tr>
						<td style="font-size: 0.5px;">
							&nbsp{{ $temp_c }} ℃
						</td>
						<td>
							<i style="font-size: 0.5px;" class="fa fa-thermometer"></i>
						</td>
						<td style="font-size: 0.5px;">
							&nbsp{{ $humidity }} %
						</td>
						<td>
							<i style="font-size: 0.5px;" class="fa fa-leaf"></i>
						</td>
					</tr>-->
				</table>
			</div>
			<div style="font-size: 1px; background-color:blue; margin-top:4px;">
				<marquee behavior="scroll" direction="left" scrolldelay="500">{{$street_name}}</marquee>
			</div>
		</div>
		<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  		<script>
  			$( document ).ready(function() {/*
			    setInterval(function(){ 
			    	"use strict";
			    	let jd = new Date;
			    	let month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
			    	let mnt = jd.getMinutes();
			    	let scd = jd.getSeconds();
			    	let hr = jd.getHours();

			    	if(mnt<10){
			    		mnt = "0"+mnt.toString();
			    	}
			    	if(scd<10){
			    		scd = "0"+scd.toString();
			    	}
			    	if(hr<10){
			    		hr = "0"+hr.toString();
			    	}
			    	let od = month[jd.getMonth()] + " " + jd.getDate() + ", " + jd.getFullYear();
			    	$(".card-title-1").text(od);
			    }, 1000);*/
/*
			    setInterval(function(){
			    	$(".card-content p").text((Math.random() * 10).toString());
			    },4000)*/
			});
  		</script>
	</body>
</html>