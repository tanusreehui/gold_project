
  
  $(document).ready(function() {

    $('#generate-random').click(function(){
        eel.random_python()(function(number){
          $('.random_number').text(number);
        });
    });

    $("#add-numbers").click(function() {
      var data_1 = $("#int1").val();  
      var data_2 = $("#int2").val();  
      eel.add(data_1, data_2)(function(output){
          $('#res').val(output);
      })
    });
    
    $("#fetch-request").click(function() { 
      eel.fetchTagDetails('JOB-00001-2122')(function(requestData){
        var jsonobj = requestData;
        console.log(jsonobj);
          $('#request-output').text(jsonobj.modelNumber);
      })
    });


    $('body').on('click', '#test', function() {
        eel.fillTable()(function(data){
          $("#test-output").html(data);
        })
    });


    // $("#test").click(function(){
    //   eel.fillTable()(function(data){
    //       $("#test-output").html(data);
    //   })
    // });
});