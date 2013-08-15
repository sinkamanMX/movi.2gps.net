$(document).ready(function(){
  /*try {
    $(document).bind("contextmenu", function(e) {
      e.preventDefault();
      $("#custom-menu").css({ top: e.pageY + "px", left: e.pageX + "px" }).show(100);
    });
    $(document).mouseup(function(e) {
      var container = $("#custom-menu");
      if (container.has(e.target).length == 0) {
        container.hide();
      }
    });
  }catch (err) {
    alert(err);
  }*/
});


$(document).ready(function() {
  $('#wgtTxtSearch').keyup(function(){
      var ourClass =  this.value;      
      searchOfText(ourClass);
  });

  $(".widgetPanel").click(function(){//do something fired 5 times});  
    var idWidgetSelected = $(":input:first",this).val();
      popupConfigWidget(idWidgetSelected,0);
  });
});

function searchOfText(textSearch){
    $('#divListWidgets > div > .widgetTittle').each(function () {
        var searchText = $(this).html();  
        if(searchText.contains(textSearch)){
          $(this).parent().fadeIn();
        }else{
          $(this).parent().fadeOut();
        }
    });
}

function closePopUpWidgets(){
   $('#dialogAddWidget').bPopup().close();
}

function closeNewWidgets(){
   $('#dialogConfigWidget').bPopup().close();
}

$(function() {
  $( ".draggable" ).draggable({  containment: "parent" });
  $("#btnAdd").click( function(){
    $('#dialogAddWidget').bPopup({
      escClose : false,
      modalClose: false,
    });
  });       
});

function popupConfigWidget(idWidget,onUse){
    $.ajax({
      url: "index.php?m=dashboard&c=mConfigWidget",
      type: "GET",
      data: { data: idWidget , id : onUse},
      success: function(data) {
        var result = data; 
        $('#dialogConfigWidget').html('');
        $('#dialogConfigWidget').dialog('open');
        $('#dialogConfigWidget').html(result); 
        
        $('#dialogAddWidget').bPopup().close();
        $('#dialogConfigWidget').bPopup({
          escClose : false,
          modalClose: false,
        });
                
      }
  });
}

function confirmWidgetDelete(idWidget){

}

function deleteWidget(idWidget){

}