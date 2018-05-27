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

Ajax.submit_post_ad = function (data, success) {
    Ajax.post(BaseUri + API_LIST.SUBMIT_POST_AD, data, success);
}

Ajax.get_city = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_CITY, data, success);
}

Ajax.search_advertisement = function (data, success) {
    Ajax.post(BaseUri + API_LIST.SEARCH_AD, data, success);
}

Ajax.get_top = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_TOP, data, success);
}

Ajax.get_service_tel = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_SERVICE_TEL, data, success);
}

Ajax.logout = function (data, success) {
    Ajax.get(BaseUri + API_LIST.LOG_OUT, data, success);
}

Ajax.get_friendly_links = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_FRIENDLY_LINKS, data, success);
}

Ajax.email_to_friend = function (data, success) {
    Ajax.post(BaseUri + API_LIST.EMAIL_TO_FRIEND, data, success);
}