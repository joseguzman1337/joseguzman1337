/*function UpdateTableHeaders() {
       $(".persist-area").each(function() {
           console.log("1");
           var el             = $(this),
               offset         = el.offset(),
               scrollTop      = $(window).scrollTop(),
               floatingHeader = $(".floatingHeader")
           console.log(scrollTop);
           console.log(offset.top);
           console.log(el.height());
           if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
           console.log("entre");
               console.log("entre mal");
               floatingHeader.css({
                "visibility": "visible"
               });
           } else {
               console.log("entre mal");
               floatingHeader.css({
                "visibility": "hidden"
               });      
           };
       });
    }
    
    // DOM Ready      
    $(function() {
    
       var clonedHeaderRow;
    
       $(".persist-area").each(function() {
           clonedHeaderRow = $(".persist-header", this);
           /*clonedHeaderRow
             .before(clonedHeaderRow.clone())
             .css("width", clonedHeaderRow.width())
             .addClass("floatingHeader");*/
             
         /*    $("#floatTable").html(clonedHeaderRow.clone()).css("width", clonedHeaderRow.width()).addClass("floatingHeader");
             
       });
             
       $(window)
        .scroll(UpdateTableHeaders)
        .trigger("scroll");
       
    });*/

/**
 * Usage: Call ActivateFloatingHeader with a CSS selector(string) matching
 *        table elements that should have a floating header
 *
 *  $(document).ready(function() {
 *      ActivateFloatingHeaders("table.tableWithFloatingHeader");
 *  });
 */


function _UpdateTableHeadersScroll() {
    $("div.divTableWithFloatingHeader").each(function() {
        var originalHeaderRow = $(".tableFloatingHeaderOriginal", this);
        var floatingHeaderRow = $(".tableFloatingHeader", this);
        var offset = $(this).offset();
        var scrollTop = $(window).scrollTop();
        // check if floating header should be displayed
        if ((scrollTop > offset.top) && (scrollTop < offset.top + $(this).height() - originalHeaderRow.height())) {
            floatingHeaderRow.css("visibility", "visible");
            floatingHeaderRow.css("left", -$(window).scrollLeft());
        }
        else {
            floatingHeaderRow.css("visibility", "hidden");
        }
    });
}


function _UpdateTableHeadersResize() {
    $("div.divTableWithFloatingHeader").each(function() {
        var originalHeaderRow = $(".tableFloatingHeaderOriginal", this);
        var floatingHeaderRow = $(".tableFloatingHeader", this);

        // Copy cell widths from original header
        $("th", floatingHeaderRow).each(function(index) {
            var cellWidth = $("th", originalHeaderRow).eq(index).css('width');
            $(this).css('width', cellWidth);
        });

        // Copy row width from whole table
        floatingHeaderRow.css("width", Math.max(originalHeaderRow.width(), $(this).width()) + "px");

    });
}


function ActivateFloatingHeaders(selector_str){
    $(selector_str).each(function() {
        $(this).wrap("<div class=\"divTableWithFloatingHeader\" style=\"position:relative\"></div>");

        // use first row as floating header by default
        var floatingHeaderSelector = "thead:first";
        var explicitFloatingHeaderSelector = "thead.floating-header"
        if ($(explicitFloatingHeaderSelector, this).length){
            floatingHeaderSelector = explicitFloatingHeaderSelector;
        }

        var originalHeaderRow = $(floatingHeaderSelector, this).first();
        var clonedHeaderRow = originalHeaderRow.clone()
        originalHeaderRow.before(clonedHeaderRow);

        clonedHeaderRow.addClass("tableFloatingHeader");
        clonedHeaderRow.css("position", "fixed");
        // not sure why but 0px is used there is still some space in the top
        clonedHeaderRow.css("top", "-2px");
        clonedHeaderRow.css("margin-left", $(this).offset().left);
        clonedHeaderRow.css("visibility", "hidden");

        originalHeaderRow.addClass("tableFloatingHeaderOriginal");
    });
    _UpdateTableHeadersResize();
    _UpdateTableHeadersScroll();
    $(window).scroll(_UpdateTableHeadersScroll);
    $(window).resize(_UpdateTableHeadersResize);
}

$(document).ready(function() {
            ActivateFloatingHeaders("table.tableWithFloatingHeader");
        });