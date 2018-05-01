$(function($) {

    mui.init();

    mui(".mui-scroll-wrapper").scroll({
        deceleration : 0.0005,
        indicators: false,
    });

    if (mui.os.plus && mui.os.ios) {
        mui.plusReady(function() { //5+ iOS暂时无法屏蔽popGesture时传递touch事件，故该demo直接屏蔽popGesture功能
            plus.webview.currentWebview().setStyle({
                'popGesture': 'none'
            });
        });
    }

    mui('body').on('tap', '#myAccount', function () {
        Helper.redirect('/login');
    })

    mui('body').on('tap', '#logout', function () {
        Ajax.logout({}, function (res) {
            if (res.code === 1){
                location.reload();
            }
        });
    })

    mui('body').on('tap', '#allBtn', function () {
        Ajax.get_index_content({},function (res) {
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
        })
    })

	Ajax.get_index_content({}, function (res) {
		if (res.code === 1){
            Helper.render($('#aside-menu'), $('#aside-city'), res.data, 1)
			Helper.render($('#parent-cities'), $('#parent-city'), res.data, 1);
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 1);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);

		} else {
            mui.alert(res.msg, 'Alert', 'ok');
		}
    });

	Ajax.get_top({}, function (res) {
        Helper.render($('#slider'), $('#vip-advertisement'), res.data, 0);
        mui('.mui-slider').slider({interval:2000});

    })

    Ajax.get_service_tel({}, function (res) {
	    if (res.code === 1){
            $('#service_tel').prop('href', res.data.value).text(res.data.value);
        }
    })

    Ajax.get_friendly_links({}, function (res) {
        if (res.code === 1){
            Helper.render($('#friendly-links'), $('#friendly-link'), res.data, 1);
        }
    })

    mui('body').on('tap', '.parent-cities', function () {
        $('.parent-cities').removeClass('selected');
        $('.sub-cities').removeClass('selected');
        $(this).addClass('selected');
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({parent_city:$(this).data('id')}, function (res) {
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 0);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);

        })
    })

    mui('body').on('tap', '.aside-parent-cities', function () {
        $('.parent-cities').removeClass('selected');
        $('.sub-cities').removeClass('selected');
        $('.parent-cities[data-id="' + $(this).data('id') +'"]').addClass('selected');
        $('.selected-city').text($(this).text())

        Ajax.get_index_content({parent_city:$(this).data('id')}, function (res) {
            mui('#offCanvasWrapper').offCanvas('close');
            if (res.code === 1){
                Helper.render($('#sub-cities'), $('#sub-city'), res.data, 0);
                Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
            } else {
                mui.alert(res.msg, 'Alert', 'ok');
            }

        })
    });

    mui('body').on('tap', '.search a', function () {
        var keyword =  $('input[name="keyword"]').val();
        if (keyword){
            Ajax.search_advertisement({
                keyword : keyword,
            }, function (res) {
                if (res.code === 1){
                    Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
                } else {
                    mui.alert(res.msg, 'Alert', 'ok');
                }
            })
        }
    });

    mui('body').on('tap', '.sub-cities', function () {
        $('.sub-cities').removeClass('selected');
        $(this).addClass('selected');
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({sub_city:$(this).data('id')}, function (res) {
            if (res.code === 1){
                Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
            } else {
                mui.alert(res.msg, 'Alert', 'ok');
            }
        })
    });

	mui('body').on('tap', '#item1 li', function () {

        Helper.redirect('/ad/detail', {
            ad_id : $(this).data('id')
        })
    });

	mui('body').on('tap', '#linkPage', function () {
        mui('#offCanvasWrapper').offCanvas('close');
		Helper.redirect('/ad/post');
    });

    $('.mui-inner-wrap').on('drag', function(event) {
        event.stopPropagation();
    });

    mui('body').on('tap', '#buyPage', function () {
        var session_user = $('meta[name=session-token]').attr('content')
        if (! session_user){
            Helper.redirect('/login')
        } else {
            mui('#offCanvasWrapper').offCanvas('close');
            mui('#popover').popover('toggle');
        }
    });

    mui('body').on('tap', '.tab', function () {
        var index = $(this).data('index');
        $('.mui-control-content').hide();
        $('#item' + index).show();
    })

    mui('body').on('tap', '.vip-swiper .mui-slider-item', function () {
        location.href = $(this).find('a').prop('href');
    });

    mui('body').on('tap', '#dateOrder', function () {
        $('.mui-control-content').hide();
        $('#item1').show();
        var parent_city_id = $('.parent-cities[class="parent-cities selected"]').data('id');
        var sub_city_id = $('.sub-cities[class="sub-cities selected"]').data('id');
        Ajax.get_index_content({parent_city:parent_city_id, sub_city:sub_city_id, orderby:'date'}, function (res) {
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
        })
    });

    mui('body').on('tap', '#topOrder', function () {
        $('.mui-control-content').hide();
        $('#item1').show();
        var parent_city_id = $('.parent-cities[class="parent-cities selected"]').data('id');
        var sub_city_id = $('.sub-cities[class="sub-cities selected"]').data('id');
        Ajax.get_index_content({parent_city:parent_city_id, sub_city:sub_city_id}, function (res) {
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
        })
    })

    mui.previewImage();

    $(".search-input").focus(function(){
        $(this).addClass('search-active');
    })
    $(".search-input").blur(function(){
        $(this).removeClass('search-active');
    })

    mui('body').on('tap', '#friendly-links a', function () {
        Helper.redirect($(this).data('url'));
    });
});