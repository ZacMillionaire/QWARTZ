<div id="monthlyGraphContainer">
</div>
<script>
document.addEventListener("DOMContentLoaded", function(event) {

	d3.json("data/graphData.php", function(error, data) {

		var format = d3.time.format("%d-%m-%Y");

		  data = data["monthTestAggregate"];
		  data.forEach(function(d) {
			d.dateEntered = format.parse(d.dateEntered);
			d.totalReps = +d.totalReps;
			d.totalWeight = +d.totalWeight;
			d.avgReps = +d.avgReps;
			d.avgWeight = +d.avgWeight;
			d.participants = +d.participants;
			d.uniqueExerciseCount = +d.uniqueExerciseCount;
		  });

		var margin = {top: 20, right: 20, bottom: 30, left: 50},
			width = 1024 - margin.left - margin.right,
			height = 400 - margin.top - margin.bottom;

		var xMin = data[0].dateEntered;
		var xMax = data[data.length-1].dateEntered;

		var x = d3.time.scale()
			.domain([new Date(data[0].date), d3.time.day.offset(new Date(data[data.length - 1].date), 1)])
			.range([0, width]);
		var xAxis = d3.svg.axis()
			.scale(x)
			.orient("bottom")
			.tickValues(data.dateEntered);

		var y = d3.scale.linear()
			.range([height, 0]);
		var yAxis = d3.svg.axis()
			.scale(y)
			.tickFormat(function (d) { return ''; })
			.orient("left");


		var svg = d3.select("#monthlyGraphContainer").append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
		  .append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");


		  x.domain(d3.extent(data, function(d) { return d.dateEntered; }));

		svg.append("g")
		    .attr("class", "x axis")
		    .attr("transform", "translate(0," + height + ")")
		    .call(xAxis);

		// svg.append("g")
		//     .attr("class", "y axis")
		//     .call(yAxis);
		    

		var keyList = ["totalWeight","totalReps","avgReps","avgWeight","participants","uniqueExerciseCount"];
		var colorList = ["#00ff40","#ff0008","#ffb700","#0fd","#ff00c3","#07f","#80ff00"];

		var div = d3.select("body").append("div")   
			.attr("class", "tooltip")
			.style("opacity", 0);
		var dateString = d3.time.format("%d/%m/%Y");

		for(i = 0; i < keyList.length; i++){

			var line = d3.svg.line()
				.x(function(d) { return x(d.dateEntered); })
				.y(function(d) { return y(d[keyList[i]]); })
				.interpolate("monotone");

			y.domain([0,d3.max(data, function(d) { return d[keyList[i]]; })]);

			svg.append("path")
				.datum(data)
				.attr("class", "line")
				.style("stroke", colorList[i])
				.attr("d", line);
			svg.selectAll(".dot")
				.data(data)
				.enter().append("circle")
				.attr('cx', function(d) { return x(d.dateEntered); })
				.attr('cy', function(d) { return y(d[keyList[i]]); })
				.attr('r', 5)
				.attr('fill', colorList[i])
				.on('mouseover', function(d,i) {
					div.transition()        
		                .duration(200)      
		                .style("opacity", 1);      
		            div.html(
		            	"<div class=\"tooltip-header\">Breakdown for: "+dateString(d.dateEntered)+"</div>"+
		            	"<div class=\"tooltip-row\">Total Weight: "+d.totalWeight+"kg</div>"+
		            	"<div class=\"tooltip-row\">Total Reps: "+d.totalReps+"</div>"+
		            	"<div class=\"tooltip-row\">Average Weight: "+d.avgWeight+"kg</div>"+
		            	"<div class=\"tooltip-row\">Average Reps: "+d.avgReps+"</div>"+
		            	"<div class=\"tooltip-row\">Players Tested: "+d.participants+"</div>"+
		            	"<div class=\"tooltip-row\">Exercises Used: "+d.uniqueExerciseCount+"</div>"
		            )  
	                .style("left", (d3.event.pageX + 10) + "px")     
	                .style("top", (d3.event.pageY) + "px");    
				})
				.on("mouseout", function(d) {
					div.transition()
						.duration(200)
						.style("opacity", 0);
		        });
		}
	});

});
</script>