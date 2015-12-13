document.observe("dom:loaded", function() {
    var contextMenu = $("contextMenu");
    var coordX = 0;
    var coordY = 0;
    
    $("plz").observe("contextmenu", function(e){
        e.stop();
    });

    $("plz").observe("contextmenu", function(e) {
        coordX = e.pointerX();
        coordY = e.pointerY();
        contextMenu.setStyle({
            display: "block",
            left: coordX + "px",
            top: coordY + "px"
        });
        return false;
    });
    
    document.observe("click", function() {
        contextMenu.setStyle({
            display: "none"
        });
    });
    
    $("write").observe("click", function() {
        alert("click");
        contextMenu.setStyle({
            display: "none"
        });
    });
});