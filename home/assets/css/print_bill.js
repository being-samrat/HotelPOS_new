
  function save_bill(order_id,id,bill_amt){
    $.confirm({
      title: '<label class="w3-label w3-large">Save Bill! </label>',
      content: 'Save the bill and get print ready',
      buttons: {
        confirm: function () {
          var dataS = 'order_id='+ order_id +'&id='+ id +'&bill_amt='+ bill_amt;
          $.ajax({
          url:"bill/save_bill.php", //the page containing php script
          type: "POST", //request type
          data: dataS,
          cache: false,
          success:function(html){
            $.alert(html);              
          }
        });

        },
        cancel: function () {

        }
      }
    });

  }
