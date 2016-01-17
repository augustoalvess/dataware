function popupImage(url) 
{
    var width = 800;
    var height = 500;
    var left = (screen.width / 2) - (width / 2);
    var top = (screen.height / 2) - (height / 2);
    
    window.open(url, null, 'width='+width+', height='+height+', left='+left+', top='+top+', scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, titlebar=no, resizable=yes, fullscreen=no');
}
