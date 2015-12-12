$(function() {
    var $contextMenu = $("#contextMenu");

    $("#plz").on("contextmenu",function(e) {
        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
        return false;
    });

    $("body").on("click", function() {
        $contextMenu.hide();
    })

    $contextMenu.on("click", "a", function(e) {
        alert(e.pageX + ", " + e.pageY);
        $contextMenu.hide();
    });
});