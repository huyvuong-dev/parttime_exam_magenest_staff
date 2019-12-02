define(['jquery','uiComponent','mage/url','ko'], function($,Component,url,ko) {
    return Component.extend({
        initialize: function () {
            this._super();
            $(document).on('change paste keyup','#kosearch',function () {
                var content = $('#kosearch').val();
                $.ajax({
                    type: "POST",
                    url: url.build('manage/staff/ajaxSearch'),
                    data: {content: content},
                    success: function (res) {
                        console.log(res.result);
                        $("#koResult").text(res.result.toString());
                    },
                    error: function () {
                        console.log('error');
                    }
                });
            });
        }
    });
});