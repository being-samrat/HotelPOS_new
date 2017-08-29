$(document).ready(function()
{
	$("#getSalePrint_btn").click(function(){ 
		var from = $("#print_saleFrom").val();  
		var to = $("#print_saleTo").val();  
		var data = {
			from:from,
			to:to
		};
		$("#graph_data").show();
		$.ajax({  
			url:"getSale_Report.php",  
			method:"GET",
			data:data,  
			success:function(data)  
			{  
				$("#Report_title").html("Sales Report <br><i class='w3-small'>[X-axis: Dates, Y-axis: Sales/day]</i>");
				$("#report_info").hide();
				$("#print_action").show();
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
						label: 'Rs',
						data: count,
						backgroundColor: [
						'rgba(0, 0, 0, 0.2)',
						'rgba(0, 0, 0, 0.2)',
						'rgba(0, 0, 0, 0.2)',
						'rgba(0, 0, 0, 0.2)',
						'rgba(0, 0, 0, 0.2)',
						'rgba(0, 0, 0, 0.2)'
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
				var ctx = document.getElementById("Report_Chart").getContext("2d");
				var url_base64jp = document.getElementById("Report_Chart").toDataURL("image/jpg");
				var Graph=new Chart(ctx,{
					type:'line',
					data:chartdata,
					plugins: [{
						afterRender: function () {
							renderIntoImage()
						},
					}],
					options: {

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
const renderIntoImage = () => {
	const canvas = document.getElementById('Report_Chart')
	const imgWrap = document.getElementById('chart_img')
	var img = new Image();
	img.src = canvas.toDataURL()
	imgWrap.appendChild(img)
	canvas.style.display = 'none'
}