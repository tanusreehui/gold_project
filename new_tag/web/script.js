
  
  $(document).ready(function() {

  // *************************************************************************
    $('body').on('click', '#fetch-request', function() {
      eel.fetchTagDetails('JOB-00001-2122')(function(requestData){
        var jsonobj = requestData;
        console.log(jsonobj);
          $('#request-output').text(jsonobj.modelNumber);
      })
    });
    

    $('body').on('click', '#fetch-finished-jobs', function() {
      eel.fillTable()(function(data){
        $("#finished-jobs-list").html(data);
      })
    });
  // ***************************************************************************
});