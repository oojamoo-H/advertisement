const Helper = function(){};

Helper.post = function (url, data, success) {
    $.ajax({
        url: url,
        type:'post',
        dataType:'json',
        data: data,
        success: success
    })
};

Helper.get = function (url, data, success) {
    $.ajax({
        url: url,
        type:'get',
        dataType:'json',
        data: data,
        success: success
    })
};

Helper.showLoading = function () {

}

Helper.generate_code = function (data, success) {
    Helper.get(BaseUri + API_LIST.GENERATE_CODE, data, success)
}

Helper.set_point = function (data, success) {
    Helper.post(BaseUri + API_LIST.UPDATE_POINT, data, success);
}