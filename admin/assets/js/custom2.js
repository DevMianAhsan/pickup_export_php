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
$('#formDatafinal2').submit(function(){
    
    event.preventDefault();
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

$("#formDataIQ").on('submit',function(e) {
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
                $('#formDataIQ_btn').text("Save");
                $('#formDataIQ_btn').prop("disabled",false);
                
            $("#formDataIQTb").load(location.href + " #formDataIQTb > *");


                $('#formDataIQ').each(function(){
                    this.reset();
                });    
                sweeetalert(response.msg,response.sts,2000);
            }
        });//ajax call
    });//main


