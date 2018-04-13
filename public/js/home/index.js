$(function($) {
    mui.init({
        swipe: false,
    });
	Helper.showLoading();

	Ajax.get_index_content({}, function (res) {
		Helper.hideLoading();
		if (res.code === 1){
            Helper.render($('#aside-menu'), $('#aside-city'), res.data, 1)
			Helper.render($('#parent-cities'), $('#parent-city'), res.data, 1);
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 1);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
		} else {
			alert(res.msg);
		}
    });

    mui('body').on('tap', '.parent-cities', function () {
        Helper.showLoading();
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({parent_city:$(this).data('id')}, function (res) {
            Helper.hideLoading();
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 0);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
        })
    })

    mui('body').on('tap', '.aside-parent-cities', function () {
        Helper.showLoading();
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({parent_city:$(this).data('id')}, function (res) {
            Helper.hideLoading();
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 0);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);

            mui('#offCanvasWrapper').offCanvas('close');
        })
    });

    mui('body').on('tap', '.mui-control-item', function () {

    });

    mui('body').on('tap', '.sub-cities', function () {
        Helper.showLoading();
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({sub_city:$(this).data('id')}, function (res) {
            Helper.hideLoading();
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);

        })
    });

	mui('body').on('tap', '.news-list li', function () {

		Helper.redirect('/ad/detail', {
			ad_id : $(this).data('id'),
			user_id : $(this).data('user-id')
		})
    });
	
	mui('body').on('tap', '#linkPage', function () {
		Helper.redirect('/ad/post');
    })
});