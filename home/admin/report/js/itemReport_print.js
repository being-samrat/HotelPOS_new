$(document).ready(function()
{
	$("#getItemPrint_btn").click(function(){ 
		var menuitem = $("#print_item").val();  
		var from = $("#print_itemFrom").val();  
		var to = $("#print_itemTo").val();  
		var data = {
			from:from,
			to:to,
			menuitem:menuitem
		};
		$("#Item_graph_data").show();
		$.ajax({  
			url:"getItem_Report.php",  
			method:"GET",
			data:data,  
			success:function(data)  
			{  
				$("#Item_Report_title").html("Item Report <i class='w3-small'>[X-axis: Dates, Y-axis: Number of times ordered]</i>");
				$("#item_report_info").hide();
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
						label: 'ordered count',
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
				var ctx = document.getElementById("Item_Report_Chart").getContext("2d");
				var url_base64jp = document.getElementById("Item_Report_Chart").toDataURL("image/jpg");
				var Graph=new Chart(ctx,{
					type:'line',
					data:chartdata,
					plugins: [{
						afterRender: function () {
							Item_renderIntoImage()
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
const Item_renderIntoImage = () => {
	const canvas = document.getElementById('Item_Report_Chart')
	const imgWrap = document.getElementById('Item_chart_img')
	var img = new Image();
	img.src = canvas.toDataURL()
	imgWrap.appendChild(img)
	canvas.style.display = 'none'
}