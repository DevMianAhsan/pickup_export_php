 manageinterior_grade = $('#leadscustomer').DataTable({
        stateSave: true,
        'autoWidth'   : true,
        "responsive": true,
        "ajax": {
            url: "php_action/custom_action2.php", // json datasource
            data: {action: 'leadsCustomer'},
            type: 'post',  // method  , by default get
        },
        'order': []     
    }); 



  //Save Data into Database
$('#formDatafinal2').off('submit').on('submit', function(e){
    
    e.preventDefault();
     var form = $('#formDatafinal');
        alert("anc");
        
        // event.preventDefault();
        // var form = $('#formData');
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function() {
                alert("abncd");
                $('#saveData').attr("disabled","disabled");
                // $('#saveData').text("Loading...");
                $(".loaderAjax").show(); 
                refereshdocs();
            },
            success:function (msg) {
                
               
            }
        });//ajax call
   });

$("#formDataIQ").off('submit').on('submit',function(e) {
        e.preventDefault();
        e.stopPropagation(); // only neccessary if something above is listening to the (default-)event too
        var form = $('#formDataIQ');
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType:"json",
            beforeSend:function() {
                $('#formDataIQ_btn').prop("disabled",true);
                $('#formDataIQ_btn').text("Loading...");
            },
            success:function (response) {
                $('#formDataIQ_btn').text("Submit");
                $('#formDataIQ_btn').prop("disabled",false);
                
                if ($("#formDataIQTb").length > 0) {
                    $("#formDataIQTb").load(location.href + " #formDataIQTb > *");
                    $('#formDataIQ').each(function(){
                        this.reset();
                    });
                    $('#formDataIQ select.select2').val('').trigger('change');
                }

                if (response.id) {
                    $('input[name="part_id"]').val(response.id);
                    $('input[name="machine_id"]').val(response.id);
                    $('#part_id').val(response.id);
                    $('#machine_id').val(response.id);
                    $('.vehicle_idMain').val(response.id);

                    var currentUrl = window.location.href;
                    if (currentUrl.indexOf('part_id=') === -1 && currentUrl.indexOf('vehicle_parts.php') !== -1) {
                        history.pushState(null, null, 'vehicle_parts.php?part_id=' + response.id);
                    } else if (currentUrl.indexOf('machine_id=') === -1 && currentUrl.indexOf('machines.php') !== -1) {
                        history.pushState(null, null, 'machines.php?machine_id=' + response.id);
                    }
                }

                sweeetalert('Success', response.msg, response.sts, 2000);
            },
            error: function(xhr, status, error) {
                $('#formDataIQ_btn').text("Submit");
                $('#formDataIQ_btn').prop("disabled",false);
                sweeetalert('Error', 'AJAX request failed: ' + error, 'error', 3000);
            }
        });//ajax call
    });//main


