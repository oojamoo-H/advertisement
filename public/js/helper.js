const Helper = function () {}


Helper.layer = layui.layer;
Helper.laytpl = layui.laytpl;
Helper.upload = layui.upload;
Helper.showLoading = function () {
    Helper.layerIndex = Helper.layer.load(1, {shade: [0.8,'#000']});
};

Helper.hideLoading = function () {
    Helper.layer.close(Helper.layerIndex);
};

Helper.render = function (view, tpl, data, method) {
    Helper.laytpl(tpl.html()).render(data, function(html){
        if (method === 0){
            view.html(html);
        }

        if (method === 1){
            view.append(html);
        }
    })
};

Helper.redirect = function (url, data) {
    if (! data){
        location.href = url;
        return;
    }

    var params = Object.keys(data).map(function (key) {
        return encodeURIComponent(key) + "=" + encodeURIComponent(data[key]);
    }).join("&");
    location.href = url + '?' + params;

}