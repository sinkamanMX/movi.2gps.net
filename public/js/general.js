// JavaScript Document
function deleteAllCookies() {
	//alert("deleteAllCookies")
    var cookies = document.cookie.split(";");
	//alert(cookies.length)
    for (var i = 0; i < cookies.length; i++) {
    	var cookie = cookies[i];
    	var eqPos = cookie.indexOf("=");
    	var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    	document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}
//---------------------------------------------------------------------------
function gral_btn_edit(){
	$( ".edit" ).button({
      icons: {
        primary: "ui-icon-pencil"
      },
      text: false
    })
	}
//-----------------------------------
function gral_btn_note(){
	$( ".note" ).button({
      icons: {
        primary: "ui-icon-note"
      },
      text: false
    })
	}	
//-----------------------------------
function gral_boton(){
	$(".boton").button();
	}	
//-----------------------------------
function gral_btn_gear(){
	$( ".gear" ).button({
      icons: {
        primary: "ui-icon-gear"
      },
      text: false
    })
	}
//-----------------------------------
function gral_btn_add(){
	$( ".add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: false
    })
	}			