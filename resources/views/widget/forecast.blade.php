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
		<div style="width: 80px;">
			<div style="font-size: 2px;">{{ date("F d, Y") }} <span class="card-title-1"></span></div>
			<div>
				<table>
					<tr>
						<td>
							<img src="{{ $condition_icon }}" width="15px" id="condition_icon">
						</td>
						<td style="font-size: 1px;" id="condition_text">
							{{ $condition_text }}
						</td>
						<td style="font-size: 1px;" id="temp_c">
							&nbsp{{ $temp_c }} ℃
						</td>
						<td>
							<i style="font-size: 1px;" class="fa fa-thermometer"></i>
						</td>
					</tr>
				</table>
			</div>
			<div>
				<table>
					<tr>
						@for($i=1; $i<=5; $i++)
							<td>
								<img src="{{ ${'condition_icon_'.$i} }}" width="10px">
							</td>
							<td style="font-size: 1px">
								@php
							        echo date('D',strtotime('+'.$i.' days',strtotime(date("Y-m-d"))));
							    @endphp
							</td>
			    		@endfor
					</tr>
			    </table>
			</div>
			<div style="font-size: 1px; background-color:blue;">
				<marquee behavior="scroll" direction="left" scrolldelay="500" id="street_name">{{$street_name}}</marquee>
			</div>
		</div>
		<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/strophe.js/1.2.3/strophe.min.js"></script>
  		<script src="https://rawgit.com/metajack/strophejs-plugins/master/muc/strophe.muc.js"></script>
  		<script>
  			$( document ).ready(function() {

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
			    	//let od = month[jd.getMonth()] + " " + jd.getDate() + ", " + jd.getFullYear() + " " + hr + ":" + mnt + ":" + scd;
			    	let od = hr + ":" + mnt + ":" + scd;
			    	$(".card-title-1").text(od);
			    }, 1000);
			});
  		</script>
	</body>
</html>