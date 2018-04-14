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

Ajax.get_advertisement_list = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_ADVERTISEMENT_LIST, data, success);
};

Ajax.get_advertisement_media = function (data, success) {
    Ajax.get(BaseUri + API_LIST.GET_ADVERTISEMENT_MEDIA, data, success);
};

Ajax.system_save = function (data, success) {
    Ajax.post(BaseUri + API_LIST.SYSTEM_SAVE, data, success);
}
