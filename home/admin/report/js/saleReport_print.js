$(document).ready(function()
{
	$("#getSalePrint_btn").click(function(){ 
		var from = $("#print_saleFrom").val();  
		var to = $("#print_saleTo").val();  
		var data = {
			from:from,
			to:to
		};
		$("#Sale_graph_data").show();
		$.ajax({  
			url:"getSale_Report.php",  
			method:"GET",
			data:data,  
			success:function(data)  
			{  
				$("#Sale_Report_title").html("Sales Report <i class='w3-small'>[X-axis: Dates, Y-axis: Sales/day]</i>");
				$("#sale_report_info").hide();
				$("#print_action").show();
				var date=[];
				var count=[];

				for(var i in data){
					date.push(data[i].date);
					count.push(data[i].count);
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
				var ctx = document.getElementById("Sale_Report_Chart").getContext("2d");
				var url_base64jp = document.getElementById("Sale_Report_Chart").toDataURL("image/jpg");
				var Graph=new Chart(ctx,{
					type:'line',
					data:chartdata,
					plugins: [{
						afterRender: function () {
							Sale_renderIntoImage()
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
const Sale_renderIntoImage = () => {
	const canvas = document.getElementById('Sale_Report_Chart')
	const imgWrap = document.getElementById('Sale_chart_img')
	var img = new Image();
	img.src = canvas.toDataURL()
	imgWrap.appendChild(img)
	canvas.style.display = 'none'
}