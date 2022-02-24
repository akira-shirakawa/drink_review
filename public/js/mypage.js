$(function() {
    var file = null; // 選択ファイルが格納される変数
    var blob = null; // 画像(BLOBデータ)が格納される変数
    const THUMBNAIL_MAX_WIDTH = 300; // 画像がヨコ長の場合、横サイズがこの値になるように縮小
    const THUMBNAIL_MAX_HEIGHT = 300; // 画像がタテ長の場合、縦サイズがこの値になるように縮小

    // ファイルが選択されたら実行される関数
    $('input[type=file]').change(function() {
        $('#user_image').remove();
        $('.button').removeClass('is-hide');
        // ファイルを取得する
        file = $(this).prop('files')[0];
        console.log($(this));

        // 画像かどうか判定
        
        if (file.type != 'image/jpeg' && file.type != 'image/png') {
            // 画像でない場合は何もせず終了
            file = null;
            blob = null;
            return;
        }

        // 画像をリサイズ
        var image = new Image();
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e) {
            image.src = e.target.result;
            image.onload = function() {

                // 縮小後のサイズを計算
                var width, height;
                if (image.width > image.height) {

                    // ヨコ長の画像は横サイズを定数にあわせる
                    var ratio = image.height / image.width;
                    width = THUMBNAIL_MAX_WIDTH;
                    height = THUMBNAIL_MAX_WIDTH * ratio;
                } else {

                    // タテ長の画像は縦のサイズを定数にあわせる
                    var ratio = image.width / image.height;
                    width = THUMBNAIL_MAX_HEIGHT * ratio;
                    height = THUMBNAIL_MAX_HEIGHT;
                }

                // 縮小画像を描画するcanvasのサイズを上で算出した値に変更
                var canvas = $('#canvas')
                    .attr('width', width)
                    .attr('height', height);

                var ctx = canvas[0].getContext('2d');

                // canvasに既に描画されている画像があればそれを消す
                ctx.clearRect(0, 0, width, height);

                // canvasに縮小画像を描画する
                ctx.drawImage(image,
                    0, 0, image.width, image.height,
                    0, 0, width, height
                );

                // canvasから画像をbase64として取得する
                var base64 = canvas.get(0).toDataURL('image/jpeg');

                // base64から画像データを作成する
                var barr, bin, i, len;
                bin = atob(base64.split('base64,')[1]);
                len = bin.length;
                barr = new Uint8Array(len);
                i = 0;
                while (i < len) {
                    barr[i] = bin.charCodeAt(i);
                    i++;
                }
                blob = new Blob([barr], {
                    type: 'image/jpeg'
                });

            }

        }

    });


    // アップロードボタンがクリックされたら実行
    $('#upload').click(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $('#upload>i').addClass('fa-spinner').addClass('fa-spin');
        // 送信するフォームデータを作成
        var name, fd = new FormData();
        const userName = $('input[name="name"]').val();
        console.log(userName.length);
        if(userName.length == 0){
            $('#upload>i').removeClass('fa-spinner').removeClass('fa-spin');
            return;
        }
       
        // 先ほど作った縮小済画像データを添付
        if (file && blob) {
            fd.append('file', blob);
            
        }
        
        fd.append('name',userName);

        // ajax でアップロード

        $.ajax({
                url: "/change_user", // 送信先のURL
                type: 'POST',
                dataType: 'text',
                data: fd,
                processData: false,
                contentType: false
            })
            .done(function(data, textStatus, jqXHR) {
                $('#upload>i').removeClass('fa-spinner').removeClass('fa-spin');
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                // 送信失敗
            });

    });

    $('.main_block_item').hover(function(){
      $(this).find('.fa-bars').css('opacity','1')
    },function(){
        $(this).find('.fa-bars').css('opacity','0')
    })

    $('.fa-bars').click(function(e){
        $(this).parent().find('.delete_box').toggleClass('is-active');
        e.preventDefault(); 
    })
    $('.delete').click(function(e){
        $(this).parent().find('form').submit();
        e.preventDefault(); 
    })
    $('input[name="name"]').on('input',function(){
        $('.button').removeClass('is-hide');
    })

});