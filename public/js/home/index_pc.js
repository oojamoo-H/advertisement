var tab = 1;
$(function($){

    Ajax.get_index_content({}, function (res) {
        if (res.code === 1){
            Helper.render($('#aside-menu'), $('#aside-city'), res.data, 1)
            Helper.render($('#parent-cities'), $('#parent-city'), res.data, 1);
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 1);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
            $('#area_text').text('Escort Adult Services');
        } else {
           alert(res.msg);
        }
    });
    Ajax.get_top({}, function (res) {
        Helper.render($('#myCarousel'), $('#vip-advertisement'), res.data, 0);

    })
    $('body').on('click', '.parent-cities', function () {
        $('.parent-cities').removeClass('selected');
        $('.sub-cities').removeClass('selected');
        $(this).addClass('selected');
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({parent_city:$(this).data('id')}, function (res) {
            Helper.render($('#sub-cities'), $('#sub-city'), res.data, 0);
            Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
            $('#area_text').text($('.selected-city').text()+' Escort Adult Services');
        })
    })

    $('body').on('click', '.aside-parent-cities', function () {
        $('.parent-cities').removeClass('selected');
        $('.sub-cities').removeClass('selected');
        $('.parent-cities[data-id="' + $(this).data('id') +'"]').addClass('selected');
        $('.selected-city').text($(this).text())

        Ajax.get_index_content({parent_city:$(this).data('id')}, function (res) {
            trigger.click();
            if (res.code === 1){
                Helper.render($('#sub-cities'), $('#sub-city'), res.data, 0);
                Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
                $('#area_text').text($('.selected-city').text()+' Escort Adult Services');
            } else {
                alert(res.msg);
            }

        })
    });

    $('body').on('click', '.sub-cities', function () {
        $('.sub-cities').removeClass('selected');
        $(this).addClass('selected');
        $('.selected-city').text($(this).text())
        Ajax.get_index_content({sub_city:$(this).data('id')}, function (res) {
            if (res.code === 1){
                Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
                $('#area_text').text($('.selected-city').text()+' Escort Adult Services');
            } else {
                alert(res.msg);
            }
        })
    });

    $('body').on('click','.nav-tabs li',function(){
        tab = $(this).data('index');
    })
})