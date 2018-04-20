var uploadImageInst = null;
$(function () {
    mui.init();

    mui(".mui-scroll-wrapper").scroll({
        deceleration : 0.0005,
        indicators: false,
    });

    mui('body').on('tap', '.cover', function (e) {
        var imageA = $(this);
        var field = 'image';
        uploadImageInit(field, {isCover:1}, function (res) {
            Helper.layer.closeAll('loading');
            if (res.code === 1) {
                var img = document.createElement('img');
                $(img).attr('data-preview-src', '');
                $(img).attr('data-preview-group', "1");
                $(img).css({"height": "inherit", "width": "inherit"});
                $(img).data('image-id', res.data.media_id);
                var width = $('#cover-container').width();
                var height = (res.data.height / res.data.width) * width;
                $('#cover-container').height(height);
                $(img).prop('src', res.data.url);
                imageA.html(img);
            }
        })
        $(this).siblings('.imageButton').trigger('click')
    })

    mui('body').on('tap', '.imageup', function (e) {
        var imageA = $(this);
        var field = 'image';
        uploadImageInit(field, {isCover: 0}, function (res) {
            Helper.layer.closeAll('loading');
            if (res.code === 1) {
                var img = document.createElement('img');
                $(img).attr('data-preview-src', '');
                $(img).attr('data-preview-group', "1");
                $(img).css({"height": "inherit", "width": "inherit"});
                $(img).data('image-id', res.data.media_id);
                $(img).prop('src', res.data.url);
                imageA.html(img);
            }
        })
        $(this).siblings('.imageButton').trigger('click')
    })


    var uploadVideoInst = Helper.upload.render({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-SESSION-TOKEN' :$('meta[name="session-token"]').attr('content')
        },
        size:'2048',
        elem: '#videoBtn',
        accept:'file',
        field: 'video',
        url : '/upload',
        before:function () {
            Helper.layer.load(2);
        },
        done : function (res) {
            Helper.layer.closeAll('loading');
            if (res.code === 1){
                $('video').prop('controls', 'controls');
                $('video').prop('src', res.data.url);
                $('video').data('video-id', res.data.media_id);
            } else {
                mui.alert(res.msg, 'Alert', res.msg);
            }
        },
        error:function () {
            Helper.layer.closeAll('loading');
        }
    });
    function uploadImageInit(field, data, success) {
        if (!uploadImageInst) {
            uploadImageInst = Helper.upload.render({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-SESSION-TOKEN': $('meta[name="session-token"]').attr('content')
                },
                accept: 'images',
                elem: '.imageButton',
                field: field,
                data : data,
                url: '/upload',
                multiple: true,
                number: 1,
                done: success,
                error: function (index, upload) {
                    Helper.layer.closeAll('loading');
                }
            });
        } else {
            uploadImageInst.config.field = field;
            uploadImageInst.config.done = success;
            uploadImageInst.config.data = data;
        }
    }

    mui('body').on('tap', '#cityBtn', function () {
        Ajax.get_city({}, function (res) {
            if (res.code === 1){
                var cities = res.data;
                var data = []
                $.each(cities, function (i, v) {
                    var city = {text : v.city_name, value : v.id};
                    if (v.children.length > 0){
                        city.children = [];
                        $.each(v.children, function (i, v) {
                            city.children.push({text : v.city_name, value : v.id})
                        })
                    }
                    data.push(city);
                });

                var picker = new mui.PopPicker({layer: 2, buttons:['cancle','ok']});
                picker.setData(data);
                picker.pickers[0].setSelectedIndex(0);
                picker.pickers[1].setSelectedIndex(0);
                picker.show(function(SelectedItem) {
                    $('#parent_city').data('city_id', SelectedItem[0].value).text(SelectedItem[0].text)
                    $('#sub_city').data('city_id', SelectedItem[1].value).text(SelectedItem[1].text)
                })
            }

        })
    });

    mui('body').on('tap', '#submit', function () {
        var media = []
        var video = $('video').data('video-id');

        if (video){
            media.push(video);
        }

        $('.img-list').find('img').each(function(){

            if ($(this).data('image-id')){
                media.push($(this).data('image-id'));
            }
        });

        media = media.join('|');
        var title = $('input[name="title"]').val();
        var content = $('textarea[name="content"]').val()
        Helper.layer.load(2);
        Ajax.submit_post_ad({
            media_ids : media,
            title : title,
            content:content,
            parent_city_id : $('#parent_city').data('city_id'),
            sub_city_id : $('#sub_city').data('city_id')
        }, function (res) {
            if (res.code === 1){
                Helper.redirect('/index');
            } else {
                Helper.layer.closeAll('loading');
                mui.alert(res.msg, 'Alert', 'ok');
            }
        })
    });
})