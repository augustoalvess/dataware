var ALERT = false;

$(document).ready( function() {

	// When site loaded, load the Popupbox First
        if ( ALERT )
        {
            loadPopupBox();
        }

	$('#popupBoxClose').click( function() {			
		unloadPopupBox();
	});

	function unloadPopupBox() {	// TO Unload the Popupbox
		$('#obscure').fadeOut("slow");
	}	
	
	function loadPopupBox() {	// To Load the Popupbox
		$('#obscure').fadeIn("slow");
                
                ALERT = false;
	}
	/**********************************************************/
	
});
