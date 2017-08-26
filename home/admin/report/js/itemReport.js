$(document).ready(function()
{
	$("#getItem_btn").click(function(){ 
		var from = $("#item_fromDate").val();  
		var to = $("#item_toDate").val();  
		var menuitem = $("#Report_menu").val();  
		var data = {
			from:from,
			to:to,
			menuitem:menuitem
		};
		
		$.ajax({  
			url:"report/getItem_Report.php",  
			method:"GET",
			data:data,  
			success:function(data)  
			{  
				$("#Report_title").html("Item Report <i class='w3-small'>[X-axis: Dates, Y-axis: Number of times]</i>");
				var date=[];
				var count=[];
				var records='0';

				for(var i in data){
					date.push(data[i].date);
					count.push(data[i].count);
					records++;
				}

				var chartdata={
					labels: date,
					datasets: [{
						label: 'Order Count ',
						data: count,
						backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
						],
						borderColor: [
						'rgba(255,99,132,1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
						],
						borderWidth: 1
					}]
				};
				var ctx = document.getElementById("Report_Chart");
				var Graph=new Chart(ctx,{
					type:'line',
					data:chartdata,
					options: {
						title: {
							display: true,
							position:top,
							text: 'Custom Chart Title'
						},
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:true
								}
							}]
						}
					}
				});
			},
			error:function(data){
				console.log(data);
			} 
		});  
	});
});
