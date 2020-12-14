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
									html += "<td>"+result.success[i].locationName+"</td>";
									html += "<td>"+result.success[i].activityName+"</td>";
									html += "<td>"+result.success[i].budgetedHours+"</td>";
									html += "<td>"+result.success[i].consumedHours+"</td>";
									html += "<td>"+result.success[i].workingHours+"</td>";
									if(result.success[i].attachment!="")
									{
										html += "<td><a href='<?php echo base_url(); ?>/uploads/"+result.success[i].attachment+"' target='_blank'>Click here</a></td>";
									}
									else
									{
										html += "<td></td>";
									}
									
									html += "<td>"+result.success[i].remarks+"</td>";
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
								html += "<option value=''>Select Contract</option>";
								for(var i=0;i<result.success.length;i++)
								{
									html += "<option value='"+result.success[i][0].contractId+"' des='"+result.success[i][0].contractDescription+"'>"+result.success[i][0].contractName+"</option>";
								}
								// alert(html);
								$("select.contract").eq(index).find('option').remove().end().append(html);
								$("select.contract").eq(index).selectpicker('refresh');
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
			var clientId = $("select.client").eq(index).val();

			$("select.service").eq(index).append("");
			$("select.service").eq(index).selectpicker('refresh');

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
						var serviceHtml = "";
						var activityHtml = "";
						var locationHtml = "";
						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success.serviceDetails!=="undefined")
							{
								serviceHtml += "<option value=''>Select Service</option>";
								for(var i=0;i<result.success.serviceDetails.length;i++)
								{
									serviceHtml += "<option value='"+result.success.serviceDetails[i][0].serviceId+"' des='"+result.success.serviceDetails[i][0].contractDescription+"'>"+result.success.serviceDetails[i][0].serviceName+"</option>";
								}
								// alert(html);
								$("select.service").eq(index).find('option').remove().end().append(serviceHtml);
								$("select.service").eq(index).selectpicker('refresh');
							}

							if(typeof result.success.activityDetails!=="undefined")
							{
								activityHtml += "<option value=''>Select Activity</option>";
								for(var i=0;i<result.success.activityDetails.length;i++)
								{
									activityHtml += "<option value='"+result.success.activityDetails[i][0].activityId+"' des='"+result.success.activityDetails[i][0].contractDescription+"'>"+result.success.activityDetails[i][0].activityName+"</option>";
								}
								
								$("select.activity").eq(index).find('option').remove().end().append(activityHtml);
								$("select.activity").eq(index).selectpicker('refresh');
							}

							if(typeof result.success.locationDetails!=="undefined")
							{
								locationHtml += "<option value=''>Select Location</option>";
								for(var i=0;i<result.success.locationDetails.length;i++)
								{
									locationHtml += "<option value='"+result.success.locationDetails[i][0].locationId+"' des='"+result.success.locationDetails[i][0].locationDescription+"'>"+result.success.locationDetails[i][0].locationName+"</option>";
								}
								
								$("select.location").eq(index).find('option').remove().end().append(locationHtml);
								$("select.location").eq(index).selectpicker('refresh');
							}
						}
					}
				}
				request.open("POST","<?php echo base_url(); ?>Employee/getServices",true);
				request.send(formData);
			}			
		});

		$(document).on("change","select.activity",function(){

			var index = $("select.activity").index(this);
			var activityId = $(this).val();
			var clientId = $("select.client").eq(index).val();
			var contractId = $("select.contract").eq(index).val();
			var serviceId = $("select.service").eq(index).val();
			var locationId = $("select.location").eq(index).val();

			if(contractId!="")
			{
				var request = new XMLHttpRequest;
				var formData = new FormData();

				formData.append("contractId",contractId);
				formData.append("clientId",clientId);
				formData.append("activityId",activityId);
				formData.append("serviceId",serviceId);
				formData.append("locationId",locationId);
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";
						var serviceHtml = "";
						var activityHtml = "";
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
								var consomedHours = result.success.consumedHours;
								consomedHours = parseFloat(consomedHours).toFixed(2);
								consomedHours = consomedHours.split(".");
								consomedHours = consomedHours[0]+":"+consomedHours[1];
								$(".hours").eq(index).val(result.success.budgetedHours);
								$(".tillHours").eq(index).val(consomedHours);
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
			var length = $(".startTime").length;
			var timesheetDetails = [];

			var formData = new FormData();
			formData.append("date",date);

			if(length>1)
			{
				for(var i=0;i<length;i++)
				{
					var startTime = $(".startTime").eq(i).val();
					var endTime = $(".endTime").eq(i).val();
					var client = $(".client option:selected").eq(i).val();
					var contract = $(".contract option:selected").eq(i).val();
					var service = $(".service option:selected").eq(i).val();
					var activity = $(".activity option:selected").eq(i).val();
					var activity = $(".location option:selected").eq(i).val();
					var hours = $(".hours").eq(i).val();
					var tillHours = $(".tillHours").eq(i).val();
					var diffHours = $(".diffHours").eq(i).val();
					var attchment = $(".attchment").eq(i).prop("files")[0];
					var remark = $(".remarks").eq(i).attr("remark");
					if(remark==null)
					{
						remark = "";
					}

					
					if(client!="")
					{
						formData.append("startTime[]",startTime);
						formData.append("endTime[]",endTime);
						formData.append("client[]",client);
						formData.append("contract[]",contract);
						formData.append("service[]",service);
						formData.append("location[]",service);
						formData.append("activity[]",activity);
						formData.append("hours[]",hours);
						formData.append("tillHours[]",tillHours);
						formData.append("diffHours[]",diffHours);
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
			    	}
			    }
			});
		});

		// $(document).on("click",".remarks",function(){
		// 	var index = $(".remarks").index(this);
		// 	$("[name=remarks]").val("");
		// 	$("#defaultModal").modal("show");

		// 	$("#save").click(function(){
		// 		var remarks = $("[name=remarks]").val();
		// 		alert(index);
		// 		$(".remarks").eq(index).attr("remark",remarks);
				
		// 		$("#defaultModal").modal("hide");
		// 	});
		// });

		$("#addAnotherLine").click(function(){
			
			var blankRow = $('.blank_row').clone();
			blankRow.removeClass("blank_row");
			blankRow.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
			// blankRow.find('select').attr("data-live-search",'true');
			blankRow.find('select').selectpicker();
			$("#mainTable").find("tbody").append(blankRow);

			$('.timepicker').timepicker();
		});

		function calculateTimediff(index) 
		{
			var start = $(".startTime").eq(index).val();
			var end = $(".endTime").eq(index).val();

			// var startTime = start.split(" ");
			// var startAMPM = startTime[1];
			// var startHours = startTime[0].split(":")[0];
			// var startMinutes = startTime[0].split(":")[1];

			// var endTime = end.split(" ");
			// var endAMPM = endTime[1];
			// var endHours = endTime[0].split(":")[0];
			// var endMinutes = endTime[0].split(":")[1];
			
			// startTime = ConvertTimeformat("24",startHours,startMinutes,startTime[1]);
			// endTime = ConvertTimeformat("24",endHours,endMinutes,endTime[1]);

		    // start = startTime.split(":");
		    // end = endTime.split(":");

		 //    var startDate = new Date(0, 0, 0, start[0], start[1], 0);
			// var endDate = new Date(0, 0, 0, end[0], end[1], 0);
		 //    var diff = startDate.getTime() - endDate.getTime();	
		 	console.log(start);
		  	var startDate = new Date("01/01/2007" + start);
			var endDate = new Date("01/01/2007" + end);

			var diff = (endDate - startDate) / 60000; //dividing by seconds and milliseconds  

			var minutes = diff % 60;
			var hours = (diff - minutes) / 60;
		    
		    // var hours = Math.floor(diff / 1000 / 60 / 60);
		    // diff -= hours * 1000 * 60 * 60;

		    // var minutes = Math.floor(diff / 1000 / 60);
		    // console.log(minutes);
		    // If using time pickers with 24 hours format, add the below line get exact hours
		    // if (hours < 0)
		    //    hours = hours + 24;
		    var diff = hours + ":" + minutes;
		    // var diff = (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
		    
		    
		    console.log(diff);
		    $(".diffHours").eq(index).val(diff);
		}

		function ConvertTimeformat(format, hour,minute,AMPM) 
		{
		    var hours = hour;
		    var minutes = minute;
		    var AMPM = AMPM;
		    if (AMPM == "PM" && hours < 12) hours = parseInt(hours) + parseInt(12);
		    if (AMPM == "AM" && hours == 12) hours = parseInt(hours) - parseInt(12);
		    var sHours = hours.toString();
		    var sMinutes = minutes.toString();
		    if (hours < 10) sHours = "0" + sHours;
		    if (minutes < 10) sMinutes = "0" + sMinutes;
		    return (sHours + ":" + sMinutes);
		}
	});
</script>