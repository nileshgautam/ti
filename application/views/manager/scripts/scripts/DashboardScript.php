<script type="text/javascript">
	$(function() {

		var projectData = '<?php echo ($projectData); ?>';
		var result = '';
		var projects = [];
		var tasks = [];

		try {
			result = JSON.parse(projectData);
		} catch (e) {}

		if (result != "") {
			for (var i = 0; i < result.length; i++) {
				projects.push({
					name: result[i].projectName,
					y: result[i].totalHours,
					drilldown: result[i].projectName
				});

				taskArray = result[i].details;
				var taskData = [];
				if (taskArray) {
					for (var j = 0; j < taskArray.length; j++) {
						// alert(taskArray[j].taskName);
						// taskData[j] = taskArray[j].taskName;
						// taskData[j+1] = taskArray[j].taskHours;
						taskData.push([
							taskArray[j].taskName,
							taskArray[j].taskHours
						]);
					}
				}

				tasks.push({
					name: result[i].projectName,
					id: result[i].projectName,
					data: taskData
				});
			}
		}

		// console.log(JSON.stringify(tasks));
		console.log(tasks, projects);
		// Create the chart
		Highcharts.chart('projectData', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Timesheet data project wise'
			},
			subtitle: {
				text: 'Click the columns to view tasks'
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Total consumed hours'
				}

			},
			legend: {
				enabled: false
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

			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} hrs</b> of total<br/>'
			},

			series: [{
				name: 'Projects',
				colorByPoint: true,
				data: projects
			}],
			drilldown: {
				series: tasks
			}
		});

	});
</script>

<script type="text/javascript">
	$(function() {
		Highcharts.chart('container', {
			data: {
				table: 'datatable'
			},
			chart: {
				type: 'column'
			},
			title: {
				text: 'Project budegeted and consumed hours'
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Hours'
				}
			},
			tooltip: {
				formatter: function() {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + ' hrs';
				}
			}
		});
	});
</script>

<script type="text/javascript">
	$(function() {
		var projectAndRemainingDays = <?php echo $projectAndRemainingDays; ?>;
		var result = '';
		var projects = [];

		// try
		// {
		// 	result = JSON.parse(projectAndRemainingDays);
		// }
		// catch(e){}

		// if(result!="")
		// {
		// 	for(var i=0;i<result.length;i++)
		// 	{
		// 		projects.push([
		// 			result[i].projectName,
		// 			parseFloat(result[i].days)
		// 		]);
		// 	}
		// }

		// var newData = JSON.stringify(projects);
		// console.log(newData);
		Highcharts.chart('projectRemainingDays', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Open Projects'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				type: 'category',
				labels: {
					rotation: -45,
					style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Days until end date'
				}
			},
			legend: {
				enabled: false
			},
			tooltip: {
				pointFormat: 'Remaining days: <b>{point.y}</b>'
			},
			series: [{
				name: 'Projects',
				data: projectAndRemainingDays,
				dataLabels: {
					enabled: true,
					rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '13px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			}]
		});
	});
</script>

<script type="text/javascript">
	$(function() {

		var billable = <?php if (isset($billableExpenses)) {
							echo $billableExpenses;
						} else {
							echo '[]';
						} ?>;
		var nonBillable = <?php if (isset($nonBillableExpenses)) {
								echo $nonBillableExpenses;
							} else {
								echo '[]';
							} ?>;
		var projectExpenses = <?php if (isset($projectExpenses)) {
									echo $projectExpenses;
								} else {
									echo '[]';
								} ?>;

		Highcharts.chart('expense', {
			// data: {
			//     table: 'expenseTable'
			// },
			chart: {
				type: 'column'
			},
			title: {
				text: 'Project billable and non-billable expenses'
			},
			xAxis: {
				categories: projectExpenses
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'INR'
				}
			},
			series: [{
				name: 'Billable',
				data: billable
			}, {
				name: 'NoN-Billable',
				data: nonBillable
			}]
			// tooltip: {
			//     formatter: function () {
			//         return '<b>' + this.series.name + '</b><br/>' +
			//             this.point.y + ' hrs' ;
			//     }
			// }
		});


	});
</script>

<!-- <script>
	Highcharts.chart('containerSummuary', {
	chart: {
		type: 'column'
	},
	title: {
		text: 'Monthly Average Rainfall'
	},
	subtitle: {
		text: 'Source: WorldClimate.com'
	},
	xAxis: {
		categories: [
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		],
		crosshair: true
	},
	yAxis: {
		min: 0,
		title: {
			text: 'Rainfall (mm)'
		}
	},
	tooltip: {
		headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			'<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
		footerFormat: '</table>',
		shared: true,
		useHTML: true
	},
	plotOptions: {
		column: {
			pointPadding: 0.2,
			borderWidth: 0
		}
	},
	series: [{
		name: 'Tokyo',
		data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

	}, {
		name: 'New York',
		data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

	}, {
		name: 'London',
		data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

	}, {
		name: 'Berlin',
		data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

	}]
	});

	});
</script> -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>