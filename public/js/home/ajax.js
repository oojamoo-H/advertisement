const Ajax = function(){};

Ajax.post = function (url, data, success) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-SESSION-TOKEN' :$('meta[name="session-token"]').attr('content')
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
            'X-SESSION-TOKEN' : $('meta[name="session-token"]').attr('content')
        },
        url: url,
        type:'get',
        dataType:'json',
        data: data,
        success: success
    })
};


Ajax.get_index_content = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_INDEX_CONTENT, data, success);
};

Ajax.login = function (data, success) {
    Ajax.post(BaseUri + API_LIST.LOGIN, data, success);
};

Ajax.register_for_temp = function (data, success) {
    Ajax.post(BaseUri + API_LIST.REGISTER_FOR_TEMP, data, success);
};

Ajax.register = function (data, success) {
    Ajax.post(BaseUri + API_LIST.REGISTER, data, success);
};