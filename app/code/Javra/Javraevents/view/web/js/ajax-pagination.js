define([
    "jquery"
], function($) {
    "use strict";
    $.widget('javra_javraevents.eventlist', {
        _create: function() {
            /*this.options contain all variables which you pass in it for
             use in your javascript code */
            debugger;
            var load = $('#load-more');
            var page = parseInt(this.options.currentPage);
            var totalPages = parseInt(this.options.totalPages);

            load.click(function(e) {
                e.preventDefault();
                load.html('Loading');
                if (page < totalPages) {
                    page++;
                    debugger;
                    if(page === totalPages){
                        load.attr("disabled", '');
                    }
                } else {
                    load.attr("disabled", '');
                    return false;
                }
                $.ajax({
                    type:"get",
                    url:"news-events.html?p="+page,
                    success: function(data) {
                        load.html('Load More');
                        var result = $(data).find('.lists > li');
                        $('.lists').append(result);

                    }});
            });
        }
    });
    return $.javra_javraevents.eventlist;
});
