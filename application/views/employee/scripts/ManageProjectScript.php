<script type="text/javascript">

	$(function(){

		var startTime = "";
		var endTime = "";
		$("#datepicker").datepicker().on("change",function(e){
			var date = e.target.value;

			if(date!="")
			{
				$("#previousDetails").find("tbody").html("");
				var formData = new FormData();
				formData.append("date",date);
				var request = new XMLHttpRequest;
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var html = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success!=="undefined")
							{
								for(var i=0; i<result.success.length;i++)
								{
									html += "<tr class='exist'>";
									html += "<td>"+result.success[i].startTime+"</td>";
									html += "<td>"+result.success[i].endTime+"</td>";
									html += "<td>"+result.success[i].clientName+"</td>";
									html += "<td>"+result.success[i].contractName+"</td>";
									html += "<td>"+result.success[i].serviceName+"</td>";
									// html += "<td>"+result.success[i].locationName+"</td>";
									// html += "<td>"+result.success[i].activityName+"</td>";
									// html += "<td>"+result.success[i].budgetedHours+"</td>";
									// html += "<td>"+result.success[i].consumedHours+"</td>";
									html += "<td>"+result.success[i].totalWorkingHours+"</td>";
									html += "<td>"+result.success[i].locationName+"</td>";
									if(result.success[i].attachment!="")
									{
										html += "<td><a href='<?php echo base_url(); ?>/uploads/"+result.success[i].attachment+"' target='_blank'>Click here</a></td>";
									}
									else
									{
										html += "<td></td>";
									}
									
									html += "<td>"+result.success[i].remarks+"</td>";
									html += "<td><a href='#' class='btn btn-primary btn-xs activityDetails' client='"+result.success[i].clientId+"' contract='"+result.success[i].contractId+"' service='"+result.success[i].serviceId+"' startTime='"+result.success[i].startTime+"' endtime='"+result.success[i].endTime+"'><i class='material-icons'>info_outline</i></a></td>";
									html += "</tr>";
								}							

								$("#previousDetails").find("tbody").html(html);
							}
							else
							{
								html += "<tr>";
								html += "<td>No record found</td>";
								html += "</tr>";
								$("#previousDetails").find("tbody").html(html);
							}
						}
						else
						{
							html += "<tr>";
							html += "<td colspan='12' align='center'>No record found</td>";
							html += "</tr>";
							$("#previousDetails").find("tbody").html(html);
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?>/Employee/getTimeSheetDetails");
				request.send(formData);
			}
			$("body").click();
		});

		$(document).on("change",".startTime",function(){
			var index = $(".startTime").index(this);
			calculateTimediff(index);
		});

		$(document).on("change",".endTime",function(){
			var index = $(".endTime").index(this);
			calculateTimediff(index);
		});

		$(document).on("change","select.client",function(){

			var index = $("select.client").index(this);
			var clientId = $(this).val();
			var des = $('option:selected', this).attr('des');
			if(clientId!="")
			{
				var request = new XMLHttpRequest;
				var formData = new FormData();

				formData.append("clientId",clientId);
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var contractHtml = "";
						var locationHtml = "";
						var serviceHtml = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success!=="undefined")
							{
								for(var i=0;i<result.success.length;i++)
								{
									contractHtml += "<option value='"+result.success[i].contractId+"'>"+result.success[i].contract_name+"</option>";
								}
								$("select.contract").eq(index).html(contractHtml);
								// $("select.contract").eq(index).selectpicker('refresh');

								setTimeout(function(){
									$("select.contract").change();	
								},500);

								setTimeout(function(){
									$("select.location").change();	
								},1000);

								setTimeout(function(){
									$("select.service").change();	
								},1500);
							}
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?>Employee/getContract",true);
				request.send(formData);
			}
		});

		$(document).on("change","select.contract",function(){

			var index = $("select.contract").index(this);
			var contractId = $(this).val();
			var clientId = $("select.client option:selected").val();
			if(contractId!="")
			{
				var request = new XMLHttpRequest;
				var formData = new FormData();

				formData.append("contractId",contractId);
				formData.append("clientId",clientId);
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var locationHtml = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success!=="undefined")
							{
								for(var i=0;i<result.success.length;i++)
								{
									locationHtml += "<option value='"+result.success[i].locationId+"'>"+result.success[i].locationName+"</option>";
								}
								$("select.location").eq(index).html(locationHtml);
								// $("select.contract").eq(index).selectpicker('refresh');
							}
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?>Employee/getLocations",true);
				request.send(formData);
			}
		});

		$(document).on("change","select.location",function(){

			var index = $("select.location").index(this);
			var clientId = $("select.client option:selected").val();
			var contractId = $("select.contract option:selected").val();
			var locationId = $(this).val();
			if(locationId!="")
			{
				var request = new XMLHttpRequest;
				var formData = new FormData();

				formData.append("locationId",locationId);
				formData.append("contractId",contractId);
				formData.append("clientId",clientId);

				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var serviceHtml = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success!=="undefined")
							{
								for(var i=0;i<result.success.length;i++)
								{
									serviceHtml += "<option value='"+result.success[i].serviceId+"'>"+result.success[i].serviceName+"</option>";
								}
								$("select.service").eq(index).html(serviceHtml);
								// $("select.contract").eq(index).selectpicker('refresh');
							}
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?>Employee/getServices",true);
				request.send(formData);
			}
		});


		// $(document).on("change","select.contract",function(){
		// 	var index = $("select.contract").index(this);
		// 	var contractId = $(this).val();
		// 	var clientId = $("select.client").eq(index).val();

		// 	$("select.service").eq(index).html("");

		// 	if(contractId!="")
		// 	{
		// 		var request = new XMLHttpRequest;
		// 		var formData = new FormData();

		// 		formData.append("contractId",contractId);
		// 		formData.append("clientId",clientId);
		// 		request.onreadystatechange = function(){
		// 			if(this.readyState==4 && this.status==200)
		// 			{
		// 				var content = request.responseText.trim();
		// 				var result = "";
		// 				var serviceHtml = "";
		// 				var activityHtml = "";
		// 				var locationHtml = "";
		// 				try
		// 				{
		// 					result = JSON.parse(content);
		// 				}
		// 				catch(e){}

		// 				if(result!="")
		// 				{
		// 					if(typeof result.success.serviceDetails!=="undefined")
		// 					{
		// 						// serviceHtml += "<option value=''>Select Service</option>";
		// 						for(var i=0;i<result.success.serviceDetails.length;i++)
		// 						{
		// 							serviceHtml += "<option value='"+result.success.serviceDetails[i][0].serviceId+"' des='"+result.success.serviceDetails[i][0].contractDescription+"'>"+result.success.serviceDetails[i][0].serviceName+"</option>";
		// 						}
		// 						// alert(html);
		// 						// $("select.service").eq(index).find('option').remove().end().append(serviceHtml);
		// 						$("select.service").eq(index).html(serviceHtml);
		// 						// $("select.service").eq(index).selectpicker('refresh');
		// 					}
		// 				}
		// 			}
		// 		}
		// 		request.open("POST","<?php echo base_url(); ?>Employee/getServices",true);
		// 		request.send(formData);
		// 	}			
		// });

		// $(document).on("change","select.contract",function(){
		// 	var index = $("select.contract").index(this);
		// 	var contractId = $(this).val();
		// 	var clientId = $("select.client").index(this);

		// 	if(contractId!="")
		// 	{
		// 		var request = new XMLHttpRequest;
		// 		var formData = new FormData();

		// 		formData.append("contractId",contractId);
		// 		formData.append("clientId",clientId);
		// 		request.onreadystatechange = function(){
		// 			if(this.readyState==4 && this.status==200)
		// 			{
		// 				var content = request.responseText.trim();
		// 				var result = "";
		// 				var serviceHtml = "";
		// 				try
		// 				{
		// 					result = JSON.parse(content);
		// 				}
		// 				catch(e){}

		// 				if(result!="")
		// 				{
		// 					if(typeof result.success!=="undefined")
		// 					{
		// 						if(typeof result.success.serviceDetails!=="undefined")
		// 						{
		// 							serviceHtml += "<option value=''>Select Service</option>";
		// 							for(var i=0;i<result.success.serviceDetails.length;i++)
		// 							{
		// 								serviceHtml += "<option value='"+result.success.serviceDetails[i][0].serviceId+"' des='"+result.success.serviceDetails[i][0].contractDescription+"'>"+result.success.serviceDetails[i][0].serviceName+"</option>";
		// 							}

		// 							$("select.service").eq(index).html(serviceHtml);
		// 							// alert(html);
		// 							// $("select.service").eq(index).find('option').remove().end().append(serviceHtml);
		// 							// $("select.service").eq(index).selectpicker('refresh');
		// 						}

		// 					}
		// 				}
		// 			}
		// 		}
		// 		request.open("POST","<?php echo base_url(); ?>Employee/getServices",true);
		// 		request.send(formData);
		// 	}
		// });

		$(document).on("change","select.service",function(){

			var index = $("select.service").index(this);
			var serviceId = $(this).val();
			var clientId = $("select.client option:selected").eq(index).val();
			var contractId = $("select.contract option:selected").eq(index).val();
			var locationId = $("select.location option:selected").eq(index).val();

			if(serviceId!="")
			{
				var request = new XMLHttpRequest;
				var formData = new FormData();

				formData.append("contractId",contractId);
				formData.append("clientId",clientId);
				formData.append("serviceId",serviceId);
				formData.append("locationId",locationId);
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var activityHtml = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success.details!=="undefined")
							{
								var consomedHours = result.success.details.consumedHours;
								if(consomedHours==0)
								{
									$("#consumed").eq(index).text(consomedHours);
								}
								else
								{
									consomedHours = parseFloat(consomedHours).toFixed(2);
									consomedHours = consomedHours.split(".");
									consomedHours = consomedHours[0]+":"+consomedHours[1];
									$("#consumed").eq(index).text(consomedHours);
								}								
							}

							if(typeof result.success.activityDetails!=="undefined")
							{
								activityHtml += "<option value=''>Select Activity</option>";
								for(var i=0;i<result.success.activityDetails.length;i++)
								{
									activityHtml += "<option value='"+result.success.activityDetails[i].activityId+"'>"+result.success.activityDetails[i].activityName+"</option>";
								}
								$("#budgetedHours").eq(index).text(result.success.activityDetails[0].budgetedHours+":00");
								$("select.activity").html(activityHtml);
								// $("select.activity").find('option').remove().end().append(activityHtml);
								// $("select.activity").selectpicker('refresh');
							}
						}
					}
				}
				request.open("POST","<?php echo base_url(); ?>Employee/getBudgetedHours",true);
				request.send(formData);
			}

		});

		$("#submit").click(function(){

			var date = $("[name=date]").val();
			var startTime = $("[name=startTime]").val();
			var endTime = $("[name=endTime]").val();
			var client = $(".client option:selected").val();
			var contract = $(".contract option:selected").val();
			var service = $(".service option:selected").val();
			var locationId = $(".location option:selected").val();

			var diffHours = $("#diffHours").text();
			var budgetedHours = $("#budgetedHours").text();
			var consumed = $("#consumed").text();

			var length = $(".hours").length;
			var timesheetDetails = [];

			var hoursLength = $(".hours").length;
			var totalHours = 0;
			if(hoursLength>0)
			{
				for(var j=0;j<hoursLength;j++)
				{
					var newHours = $(".hours").eq(j).val();
					var newActivity = $(".activity option:selected").eq(j).val();
					if(newActivity!="" && newHours!="")
					{
						totalHours += parseInt(newHours[0]);
					}
				}
			}

			var newDiff = diffHours.split(":");
			newDiff = parseInt(newDiff[0]);

			if(newDiff<totalHours)
			{
				alert("Sum of activity hours should not be different than Total Hours.");
				return false;
			}

			var formData = new FormData();
			formData.append("date",date);
			formData.append("startTime",startTime);
			formData.append("endTime",endTime);
			formData.append("client",client);
			formData.append("contract",contract);
			formData.append("service",service);
			formData.append("location",locationId);
			formData.append("diffHours",diffHours);
			formData.append("budgetedHours",budgetedHours);
			formData.append("consumed",consumed);
			
			if(length>1)
			{
				for(var i=0;i<length;i++)
				{
					// var startTime = $(".startTime").eq(i).val();
					// var endTime = $(".endTime").eq(i).val();
					// var client = $(".client option:selected").eq(i).val();
					// var contract = $(".contract option:selected").eq(i).val();
					// var service = $(".service option:selected").eq(i).val();
					var activity = $(".activity option:selected").eq(i).val();
					// var activity = $(".location option:selected").eq(i).val();
					var hours = $(".hours").eq(i).val();
					// var tillHours = $(".tillHours").eq(i).val();
					// var diffHours = $(".diffHours").eq(i).val();
					// var attchment = document.getElementsByClassName('attchment')[i].files;
					var attchment = $(".attchment").eq(i).prop("files")[0];
					var remark = $(".remarks").eq(i).val();
					if(remark==null)
					{
						remark = "";
					}

					
					if(activity!="")
					{
						// formData.append("startTime[]",startTime);
						// formData.append("endTime[]",endTime);
						// formData.append("client[]",client);
						// formData.append("contract[]",contract);
						// formData.append("service[]",service);
						// formData.append("location[]",service);
						formData.append("activity[]",activity);
						formData.append("hours[]",hours);
						// formData.append("tillHours[]",tillHours);
						// formData.append("diffHours[]",diffHours);
						formData.append("attchment[]",attchment);
						formData.append("remark[]",remark);
					}
				}
			}

			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Employee/saveTimesheet",
				data:formData,
				cache: false,
			    contentType: false,
			    processData: false,
			    success:function(data){
			    	var content = $.trim(data);
			    	var result = "";

			    	try
			    	{
			    		result = JSON.parse(content);
			    	}
			    	catch(e){}

			    	if(result!="")
			    	{
			    		if(typeof result.success!=="undefined")
			    		{
			    			alert(result.success);
			    			location.reload();
			    		}

			    		if(typeof result.error!=="undefined")
			    		{
			    			alert(result.error);
			    		}
			    	}
			    }
			});
		});

		// $(".remarks").on("click",function(){
		// 	var index = $(".remarks").index(this);
		// 	$("#defaultModal").modal("show");
		// 	console.log(index);
		// 	$(document).on("click","#save",function(){
		// 		var remarks = $("[name=remarks]").val();
				
		// 		$(".remarks").eq(index).attr("remark",remarks);
		// 		$("[name=remarks]").val("");
		// 		$("#defaultModal").modal("hide");
		// 	});
		// });

		$("#addAnotherLine").click(function(){
			
			var blankRow = $('.blank_row').clone();
			blankRow.removeClass("blank_row");
			// blankRow.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
			// blankRow.find('select').attr("data-live-search",'true');
			// blankRow.find('select').selectpicker();
			$("#mainTable").find("tbody").append(blankRow);
			$('.timepicker2').timepicker({
                defaultTime: 'value',
                minuteStep: 15,
                disableFocus: true,
                template: 'dropdown',
                showMeridian:false
            });
			// $('.timepicker2').timepicker();
		});

		$(document).on("click",".activityDetails",function(e){
			e.preventDefault();
			var clientId = $(this).attr("client");
			var contractId = $(this).attr("contract");
			var serviceId = $(this).attr("service");
			var startTime = $(this).attr("starttime");
			var endTime = $(this).attr("endtime");
			var date = $("[name=date]").val();

			if(clientId!="" && contractId!="" && serviceId!="")
			{
				var request = new XMLHttpRequest;
				var formData = new FormData();

				formData.append("clientId",clientId);
				formData.append("contractId",contractId);
				formData.append("serviceId",serviceId);
				formData.append("startTime",startTime);
				formData.append("endTime",endTime);
				formData.append("date",date);
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var html = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(typeof result.success!=="undefined")
						{
							for(var i=0;i<result.success.length;i++)
							{
								var workingHours = result.success[i].workingHours.split(":");
								html += "<tr>";
								html += "<td>"+result.success[i].activityName+"</td>";
								html += "<td>"+workingHours[0]+":"+workingHours[1]+"</td>";
								html += "</tr>";
							}
							$("#activityModal").modal("show");
							$(".activityDetailRow").find("tbody").html(html);
						}

						if(typeof result.error!=="undefined")
						{

						}
					}
				}

				request.open("POST","<?php echo base_url(); ?>Employee/getActivityDetails",true);
				request.send(formData);
			}
		});

		function calculateTimediff(index) 
		{
			var start = $(".startTime").eq(index).val();
			var end = $(".endTime").eq(index).val();

			var startTime = start.split(" ");
			var endTime = end.split(" ");

			var startAMPM = startTime[1];
			var endAMPM = endTime[1];

		    start = startTime[0].split(":");
		    end = endTime[0].split(":");

		    if(startAMPM!=endAMPM)
			{
				end[0] = parseInt(end[0])+12;
			}
			else
			{
				// console.log(start[0]);
				// console.log(end[0]);
				if(start[0]>end[0])
				{
					$(".endTime").eq(index).val(start[0]+":"+start[1]);
					return false;
				}
			}

		    var startDate = new Date(0, 0, 0, start[0], start[1], 0);
		    var endDate = new Date(0, 0, 0, end[0], end[1], 0);
		    var diff = endDate.getTime() - startDate.getTime();
		    var hours = Math.floor(diff / 1000 / 60 / 60);
		    diff -= hours * 1000 * 60 * 60;
		    var minutes = Math.floor(diff / 1000 / 60);

		    // If using time pickers with 24 hours format, add the below line get exact hours
		    if (hours < 0)
		       hours = hours + 24;

		    var diff = (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
		    $("#diffHours").eq(index).text(diff);
		}

		$("select.client").change();

		setTimeout(function(){
			$("select.contract").change();	
		},500);

		setTimeout(function(){
			$("select.location").change();	
		},1000);

		setTimeout(function(){
			$("select.service").change();	
		},1500);
		
	});
</script>