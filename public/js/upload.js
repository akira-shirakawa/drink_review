$(function() {
    var file = null; 
    var blob = null; 
    const THUMBNAIL_MAX_WIDTH = 500; // 画像がヨコ長の場合、横サイズがこの値になるように縮小される
    const THUMBNAIL_MAX_HEIGHT = 500; // 画像がタテ長の場合、縦サイズがこの値になるように縮小される

    // ファイルが選択されたら実行される関数
    $('input[type=file]').change(function() {
        $('#user_image').remove();
        // ファイルを取得する
        file = $(this).prop('files')[0];
        console.log($(this));

        // 選択されたファイルが画像かどうか判定する
        // ここでは、jpeg形式とpng形式のみを画像をみなす
        if (file.type != 'image/jpeg' && file.type != 'image/png') {
            // 画像でない場合は何もせず終了する
            file = null;
            blob = null;
            return;
        }
        $('.validation_image').text('');

        // 画像をリサイズ
        var image = new Image();
        

        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e) {
            image.src = e.target.result;
            image.onload = function() {

                // 縮小後のサイズを計算する
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

                // 縮小画像を描画するcanvasのサイズを上で算出した値に変更する
                var canvas = $('#canvas')
                    .attr('width', width)
                    .attr('height', height);

                var ctx = canvas[0].getContext('2d');

                // canvasに既に描画されている画像を消す
                ctx.clearRect(0, 0, width, height);

                // canvasに縮小画像を描画
                ctx.drawImage(image,
                    0, 0, image.width, image.height,
                    0, 0, width, height
                );

                // canvasから画像をbase64として取得
                var base64 = canvas.get(0).toDataURL('image/jpeg');

                // base64から画像データを作成
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


    // アップロードボタンがクリックされたら実行される
    $('#upload').click(function() {

        $('i').addClass('fa-spinner').addClass('fa-spin');
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

      
       

    // 送信するフォームデータを作成
        var name, fd = new FormData();
        const userName = $('input[name="name"]').val();
        const good   =$('textarea[name="good"]').val() ;
        const bad   =$('textarea[name="bad"]').val() ;
        const tags = $('input[name="tags"]').val();
        
        if(!userName){
            $('i').removeClass('fa-spinner').removeClass('fa-spin');
            $('.validation').text('名前を記入してください');
            $('body, html').scrollTop(0);
            return;
        }
        
        // 縮小済画像データを添付
        if (file && blob) {
            fd.append('file', blob);
            
            
        }else{
            $('i').removeClass('fa-spinner').removeClass('fa-spin');
            $('.validation_image').text('画像を添付してください');
            return;
        }
        
        fd.append('name',userName);
        fd.append('good',good);
        fd.append('bad',bad);
        fd.append('tags',tags);
        
        
        // ajax でアップロード

        $.ajax({
                url: "/post", // 送信先のURL
                type: 'POST',
                dataType: 'text',
                data: fd,
                processData: false,
                contentType: false
            })
            .done(function(data, textStatus, jqXHR) {
                window.location.href = './';
                console.log('shira');
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                // 送信失敗
            });

    });
    $('input[name="name"]').keydown(function(){
        $('.validation').text('');
    })

});