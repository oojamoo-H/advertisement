const Ajax = function(){};

Ajax.post = function (url, data, success) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $(window.parent.document).find('meta[name="csrf-token"]').attr('content'),
            'X-SESSION-TOKEN' : $(window.parent.document).find('meta[name="session-token"]').attr('content')
        },
        url: url,
        type:'post',
        dataType:'json',
        data: data,
        success: success
    })
};

Ajax.get = function (url, data, success) {

    $.ajax({
        headers: {
            'X-SESSION-TOKEN' : $(window.parent.document).find('meta[name="session-token"]').attr('content')
        },
        url: url,
        type:'get',
        dataType:'json',
        data: data,
        success: success
    })
};

Ajax.generate_code = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GENERATE_CODE, data, success)
};

Ajax.set_point = function (data, success) {
    Ajax.post(BaseUri + API_LIST.UPDATE_POINT, data, success);
};