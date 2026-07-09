$(document).ready(function () {
   
	$(document).on('change', "#countryFee", function () {
		var countryFee = $(this).val();
		$.ajax({
            url:'php_action/custom_action.php',
            type:"POST",
            data:{countryFee:countryFee},
            dataType:"json",
            success:function(response) {
                var country_ports = "<option>~~SELECT~~</option>";
                $.each(response, function (index, value) {
                    country_ports += '<option class="text-capitalize" value="'+value['country_regulation_id']+'">'+value['country_regulation_destination_port']+'</option>';
                });
            	console.log(country_ports)
                $("#countryPorts").empty().append(country_ports);
            }
		});
	});//get Fee


	$(document).on('change', '#countryPorts', function () {
		var countryPorts = $(this).val();
		var amt = $("#est_price").html();
		alert(amt)
		$.ajax({
            url:'php_action/custom_action.php',
            type:"POST",
            data:{countryFee:countryPorts},
            dataType:"json",
            success:function(response) {
            	var portplusamt = Number(response[0].country_regulation_fee) + Number(amt);
            	$("#portplusamt").val(portplusamt);
            	$("#ttl_amount").html(portplusamt);
            }
		});
	});

     $(document).on('change',".country_name",function () {

        var country_name = $(this).val();
       // alert(country_name);
        $.ajax({
            url:'admin/php_action/custom_action.php',
            type:'post',
            data:{country_name1:country_name},
            dataType:'json',
            success:function(response){  
                 var country_ports = "<option>Select Port</option>";
                $.each(response, function (index, value) {
                    country_ports += '<option value="'+value['country_regulation_destination_port']+'">'+value['country_regulation_destination_port']+'</option>';
                });
                
                $(".port_name").empty().append(country_ports);
            }
        });
    });
    //Save Data into Database
    $("#formData").on('submit',function(e) {
        e.preventDefault();
        var form = $('#formData');
        alert()
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success:function (msg) {
                $('#formData').each(function(){
                    this.reset();
                });    
                $('#formData').css("opacity","");   
                alert()
                manageAuctiongGrade.ajax.reload(null, false);
            }
        });//ajax call
    });//main
    
    
    
    $(document).on('change', '#makers', function () {
    var makers = $(this).val();
        $.ajax({
            url:'php_action/custom_action1.php',
            type:"POST",
            data:{makers:makers},
            dataType:"json",
            success:function(response) {
                var model = "<option value="+'null'+">~~SELECT~~</option>";
                $.each(response, function (index, value) {
    model += '<option class="text-capitalize" value="'+value['brand_id']+'">'+value['brand_name']+'</option>';
                });
                $("#model").empty().append(model);
            }
        });
});

$(document).on('change', '#model', function () {
    var model_id = $(this).val();
        $.ajax({
            url:'php_action/custom_action1.php',
            type:"POST",
            data:{model_id:model_id},
            dataType:"json",
            success:function(response) {
                console.log(response)
                var chassis = "<option value="+'null'+">~~SELECT~~</option>";
                $.each(response, function (index, value) {
    chassis += '<option class="text-capitalize" value="'+value['model_id']+'">'+value['model_name']+'</option>';
                });
                $("#chassis").empty().append(chassis);
            }
        });
});


$(document).on('change', '#makers', function () {
    var makers = $(this).val();
        $.ajax({
            url:'php_action/custom_action1.php',
            type:"POST",
            data:{makers:makers},
            dataType:"json",
            success:function(response) {
                var model = "<option value="+'null'+">~~SELECT~~</option>";
                $.each(response, function (index, value) {
    model += '<option class="text-capitalize" value="'+value['brand_id']+'">'+value['brand_name']+'</option>';
                });
                $("#model").empty().append(model);
            }
        });
});



});//Document Ready

function addWarn(amt) {
	var portplusamt = $("#portplusamt").val();
	ttl = Number(portplusamt) + Number(amt);
	$("#portplusamt").val(ttl)
   	$("#ttl_amount").html(ttl)
}

function addService(amt) {
	var portplusamt = $("#portplusamt").val();
	ttl = Number(portplusamt) + Number(amt);
	$("#portplusamt").val(ttl);
   	$("#ttl_amount").html(ttl);	
}

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

