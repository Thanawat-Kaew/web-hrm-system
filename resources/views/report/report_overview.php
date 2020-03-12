<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.js"></script>
<head>
	<style type="text/css">
		#js-legend ul {
			list-style: none;
		}

		#js-legend ul li {
			display: block;
			padding-left: 30px;
			position: relative;
			margin-bottom: 4px;
			border-radius: 5px;
			padding: 2px 8px 2px 28px;
			font-size: 14px;
			cursor: default;
			-webkit-transition: background-color 200ms ease-in-out;
			-moz-transition: background-color 200ms ease-in-out;
			-o-transition: background-color 200ms ease-in-out;
			transition: background-color 200ms ease-in-out;
		}

		#js-legend li span {
			display: block;
			position: absolute;
			left: 0;
			top: 0;
			width: 20px;
			height: 100%;
			border-radius: 5px;
		}
	</style>
</head>
<body>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-info">
					<div id="chartContainer" style="height: 300px; width: 100%;"></div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Donut Chart</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<canvas id="pieChart" style="width: 100%; height: auto;"></canvas>
						<div id="js-legend" class="chart-legend"></div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		<!-- /.box -->
	</section>
</body>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
	window.onload = function() {

		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			title: {
				text: "Desktop Search Engine Market Share - 2016"
			},
			data: [{
				type: "pie",
				startAngle: 240,
				yValueFormatString: "##0.00\"%\"",
				indexLabel: "{label} {y}",
				dataPoints: [
				{y: 79.45, 	label: "Google"},
				{y: 7.31, 	label: "Bing"},
				{y: 7.06, 	label: "Baidu"},
				{y: 4.91, 	label: "Yahoo"},
				{y: 1.26, 	label: "Others"}
				]
			}]
		});
		chart.render();

	}
</script>

<script>
	$(function() {
		var pieChartCanvas = document.getElementById("pieChart").getContext("2d");
		var pieChart = new Chart(pieChartCanvas);
		var PieData = [{
			value: 100,
			color: "#f56954",
			highlight: "#f56954",
			label: "Chrome",
			labelColor: 'white',
			labelFontSize: '16'
		}, {
			value: 100,
			color: "#00a65a",
			highlight: "#00a65a",
			label: "IE",
			labelColor: 'white',
			labelFontSize: '16'
		}, {
			value: 100,
			color: "#f39c12",
			highlight: "#f39c12",
			label: "FireFox",
			labelColor: 'white',
			labelFontSize: '16'
		}, {
			value: 100,
			color: "#00c0ef",
			highlight: "#00c0ef",
			label: "Safari",
			labelColor: 'white',
			labelFontSize: '16'
		}, {
			value: 100,
			color: "#3c8dbc",
			highlight: "#3c8dbc",
			label: "Opera",
			labelColor: 'white',
			labelFontSize: '16'
		}, {
			value: 100,
			color: "#d2d6de",
			highlight: "#d2d6de",
			label: "Navigator",
			labelColor: 'white',
			labelFontSize: '16'
		}];
		var pieOptions = {
			segmentShowStroke: true,
			segmentStrokeColor: "#fff",
			segmentStrokeWidth: 2,
			percentageInnerCutout: 50,
			animationSteps: 100,
			animationEasing: "easeOutBounce",
			animateRotate: true,
			animateScale: false,
			responsive: true,
			maintainAspectRatio: true,
			legendTemplate: '<ul>' + '<% for (var i=0; i<segments.length; i++) { %>' + '<li>' + '<span style=\"background-color:<%=segments[i].fillColor%>\"></span>' + '<% if (segments[i].label) { %><%= segments[i].label %><% } %>' + '</li>' + '<% } %>' + '</ul>'
		};

		var myChart = pieChart.Doughnut(PieData, pieOptions);
		document.getElementById("js-legend").innerHTML = myChart.generateLegend();
	});

</script>