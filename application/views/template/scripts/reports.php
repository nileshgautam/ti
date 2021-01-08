

<script>
	$(function() {
		let projectData = JSON.stringify(<?php echo json_encode($assginTask)?>);
		let result = '';
		// let projects = [];
		let tasks = [];
		// let categories=[];
		try {
			result = JSON.parse(projectData);
			// console.log(result);
		} catch (e) {}

	
		if (result != "") {
			for (let i = 0; i < result.length; i++) {
				console.log(parseFloat(convertMinToHRS(result[i].consumedTime)));
				// categories.push(result[i].title);
				tasks.push({
					name: result[i].title,
					y: parseFloat(convertMinToHRS(result[i].consumedTime)),
					drilldown: result[i].title
				});
			}
		}

		// console.log(projects)
		Highcharts.chart('columnchart_material', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Daily Booked time'
			},
			subtitle: {
				text: 'Source: Troiscon'
			},
			xAxis: {
                type: 'category'
            },
			yAxis: {
				min: 0,
				title: {
					text: 'Booked Times (hrs)'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.2f} hrs</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				series: {
        			borderWidth: 0,
        			dataLabels: {
        				enabled: true,
        				format: '{point.y} hrs'
        			}
        		}
			},
			series: [{
                name: 'Tasks',
                colorByPoint: true,
                data: tasks
            }]
		});
	});
</script>