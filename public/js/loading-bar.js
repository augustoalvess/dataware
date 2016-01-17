$(document).ready( function() 
{    
    $(".loading").click(function()
    {
        loadPopupBox();
    });
  
    $('#popupBoxClose').click( function() 
    {			
        unloadPopupBox();
    });

    function unloadPopupBox() 
    {
        $('#obscure-loading').fadeOut("slow");
    }	

    function loadPopupBox() 
    {
        $('#obscure-loading').fadeIn("slow");
    }
});

$(document).ready(function() 
{
    $('.barlittle').removeClass('stop');
    
    $('.triggerBar').click(function() 
    {
        $('.barlittle').toggleClass('stop');
    });
});

function logoutMessage()
{
    swal(
    {
        title: 'Atenção!',   
        text: 'Você será desconectado, deseja realmente efetuar logout?',   
        type: 'warning',   
        showCancelButton: true,   
        confirmButtonColor: '#DD6B55',   
        confirmButtonText: 'Sim, efetuar logout!',   
        cancelButtonText: 'Não, cancelar!',
        closeOnConfirm: false,   
        closeOnCancel: true
    }, 
    function ( isConfirm )
    {   
        if ( isConfirm ) 
        {   
            window.location.href = "/logout";
        } 
    });
}