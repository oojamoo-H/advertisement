$(function () {
    var uploadVideoInst = Helper.upload.render({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-SESSION-TOKEN' :$('meta[name="session-token"]').attr('content')
        },
        size:'2048',
        accept : 'video',
        elem: '#videoBtn',
        field: 'video',
        url : '/upload',
        done : function (res) {
            if (res.code === 1){
                $('video').prop('controls', 'controls');
                $('video').prop('src', res.data.url);
                $('video').data('video-id', res.data.id);
            }
        }
    });

    var index = 0
    var uploadImageInst = Helper.upload.render({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-SESSION-TOKEN' :$('meta[name="session-token"]').attr('content')
        },
        accept: 'images',
        elem : '#imageBtn',
        field: 'image',
        url : '/upload',
        multiple:true,
        number:5,
        done : function (res) {
            $('.img-list').find('img').eq(index).data('image-id', res.data.id);
            $('.img-list').find('img').eq(index).prop('src', res.data.url);
            index++;
        }
    })
})