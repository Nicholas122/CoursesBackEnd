$(document).ready(function() {
    

    $('.dropdown-toggle').dropdown();
    
    $(document).on('click', '.btn-delete', function() {
        $('#deleteConfirmation .modal-body').html($(this).data('confirm-body'));
        deleteUrl = $(this).data('delete-url');
    });

    $(document).on('click', '.confirm-deleting', function() {

        if( !deleteUrl || deleteUrl === null || deleteUrl === '' )
        {
            $('#deleteConfirmation').modal('toggle');
            showFlashMessage(error_message, 'warning');
        }
        else
        {
            window.location.href = deleteUrl;
        }

    });
    
    $('.unbind').unbind();
      
    if($( window ).width() < 768){
        $('#collapse_summary').removeClass('in');
        $('#collapse_summary').addClass('collapse');
    }
    else{
        $('#collapse_summary').removeClass('collapse');
        $('#collapse_summary').addClass('in');
    }
    $("#deleteTest").on('click', function(){
        $('#deleteConfirmTest').modal('toggle');
        if( !deleteUrl || deleteUrl === null || deleteUrl === '' )
        {
            showFlashMessage(error_message, 'warning');
        } else {
            $.ajax({
                type:'post',
                url:deleteUrl,
                success:function(){
                        location.reload();
                }
            })
        }
    });

    //$('#data_table').dataTable( {
    //    "iDisplayLength" : 10,
    //    "bFilter": false,
    //    "bLengthChange": false,
    //    "aaSorting": []
    //} );

//    $('#cource_rating span').click(function(){
//
//        $('html,body').animate({
//        scrollTop: $("#review").offset().top},
//        'slow');
//        var position = $(this).index() + 1;
//        $('#open-review-box').click();
//        $('#form_stars span:nth-child(' + position + ')').click();
//
//        return false;
//   });
//
//
//    $(document).on('click', '.subscribe, .unsubscribe', function(index) {
//        var id = $(this).attr('data-course-id');
//        var url = ( $(this).attr('href') === '#subscribe' ) ? subscribeUrl + id : unsubscribeUrl + id;
//        var isSubscribe = ( $(this).attr('href') === '#subscribe' ) ? true : false;
//        var element = this;
//        //console.log(index);
//        $.ajax({
//            type: 'GET',
//            url: url,
//            dataType: 'JSON',
//            beforeSend: function()
//            {
//                $(element).button('loading');
//            },
//            error: function()
//            {
//                $(element).button('reset');
//                showFlashMessage(response['message'], response['message_type']);
//            },
//            success: function(response)
//            {
//                $(element).button('reset');
//                if( response )
//                {
//                    if( isSubscribe && response['message_type'] === 'success')
//                    {
//
//                        $(element).removeClass('btn-default');
//                        $(element).removeClass('subscribe');
//                        $(element).addClass('btn-success');
//                        $(element).addClass('unsubscribe');
//                        $(element).data('loading-text', unsubscribeLoadingLable);
//                        $(element).html(unsubscribeLable);
//                        $(element).attr('href', '#unsubscribe');
//
//                        //localStorage.setItem('subscribetions', id);
//                        //setTimeout( location.href = viewCourseUrl +"/"+id, 100);
//                    }
//                    else
//                    {
//                        $(element).removeClass('btn-success');
//                        $(element).removeClass('unsubscribe');
//                        $(element).addClass('btn-default');
//                        $(element).addClass('subscribe');
//                        $(element).data('loading-text', subscribeLoadingLable);
//                        $(element).html(subscribeLable);
//                        $(element).attr('href', '#subscribe');
//                        location.reload();
//                    }
//                    //if (response['message_type'] === 'success' && isSubscribe) {
//                    //
//                    //    //localStorage["ids"] = JSON.stringify(id);
//                    //    localStorage.setItem('subscribetions', id);
//                    //    setTimeout( location.href = viewCourseUrl +"/"+id, 100);
//                    //    //location.reload();
//                    //    //return;
//                    //    //location.href = viewCourseUrl +"/"+id;
//                    //} else if (response['message_type'] === 'success' && !isSubscribe) {
//                    //    location.reload();
//                    //}
//                    if (response['message_type'] !== 'success') {
//                        showFlashMessage(response['message'], response['message_type']);
//                    }
//                }
//            }
//        });
//
//    });

    //if(locationStor)
    //var linksId =localStorage.getItem("subscribetions");
    //console.log(localStorage['prev']);
    //var linksId =localStorage.getItem("ids");
    //console.log(linksId);
    //for(var i= 0; i < linksId.length; i++) {
    //    var linkId = linksId[i];
    //    if (linkId !== null) {
    //        //localStorage.setItem("subscribetions", null);
    //        var element = $(".subscribe[data-course-id='"+linkId+"']");
    //        if(element.hasClass('subscribe')) {
    //            $(element).removeClass('btn-default');
    //            $(element).removeClass('subscribe');
    //            $(element).addClass('btn-success');
    //            $(element).addClass('unsubscribe');
    //            $(element).data('loading-text', unsubscribeLoadingLable);
    //            $(element).html(unsubscribeLable);
    //            $(element).attr('href', '#unsubscribe');
    //        }
    //    }
    //}
    //var linkId =localStorage.getItem("subscribetions");
    //    var element = $(".subscribe[data-course-id='"+linkId+"']");
    //
    //    if(element.hasClass('subscribe')) {
    //        $(element).removeClass('btn-default');
    //        $(element).removeClass('subscribe');
    //        $(element).addClass('btn-success');
    //        $(element).addClass('unsubscribe');
    //        $(element).data('loading-text', unsubscribeLoadingLable);
    //        $(element).html(unsubscribeLable);
    //        $(element).attr('href', '#unsubscribe');
    //        localStorage.removeItem('subscribetions');
    //    }
    //else {
    //if (element.hasClass('unsubscribe')) {
    //
    //$(element).removeClass('btn-success');
    //$(element).removeClass('unsubscribe');
    //$(element).addClass('btn-default');
    //$(element).addClass('subscribe');
    //$(element).data('loading-text', subscribeLoadingLable);
    //$(element).html(subscribeLable);
    //$(element).attr('href', '#subscribe');
    //}
    //}
});