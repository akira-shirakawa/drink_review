@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/upload.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css" integrity="sha512-uKwYJOyykD83YchxJbUxxbn8UcKAQBu+1hcLDRKZ9VtWfpMb1iYfJ74/UIjXQXWASwSzulZEC1SFGj+cslZh7Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('main')

<h2 class="mt-middle is-center">新規投稿</h2>


        <canvas id="canvas" width="0" height="0"></canvas>
        
   
        <label for="file" class="filelabel ">画像をアップロードする</label>
        <input type="file" name="fileinput" id="file" class="fileinput" 　accept="image/*">
        <p class="label">名前</p>
        <input type="text" name="name" value="">
        <p class="label">カテゴリー</p>
        <input name="tags" id="tags" value="foo,bar,baz" />
        <p class="label">よかったところ</p>
        <textarea name="good" rows="4"></textarea>
        <p class="label">悪かったところ</p>
        <textarea name="bad" rows="4"></textarea>
        <button id="upload" class="mt-middle button">投稿</button>
 
<!-- アップロードボタン -->


<!-- 縮小画像の表示領域 -->

<!-- 以下、JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        var file = null; // 選択ファイルが格納される変数
        var blob = null; // 画像(BLOBデータ)が格納される変数
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

            // 画像をリサイズする
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


        // アップロードボタンがクリックされたら実行される関数
        $('#upload').click(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            // ファイルが指定されていなければ何も起こらない
           

            // 送信するフォームデータを作成する
            var name, fd = new FormData();
            const userName = $('input[name="name"]').val();
            const good   =$('textarea[name="good"]').val();
            const bad   =$('textarea[name="bad"]').val();
            const tags = $('input[name="tags"]').val();
            
            // 先ほど作った縮小済画像データを添付する
            if (file && blob) {
                fd.append('file', blob);
                
            }
            
            fd.append('name',userName);
            fd.append('good',good);
            fd.append('bad',bad);
            fd.append('tags',tags);
            
            
            // ajax でアップロード

            $.ajax({
                    url: "/post", // 送信先のURL
                    type: 'POST',
                    dataType: 'json',
                    data: fd,
                    processData: false,
                    contentType: false
                })
                .done(function(data, textStatus, jqXHR) {
                    // 送信成功
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    // 送信失敗
                });

        });

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js" integrity="sha512-wTIaZJCW/mkalkyQnuSiBodnM5SRT8tXJ3LkIUA/3vBJ01vWe5Ene7Fynicupjt4xqxZKXA97VgNBHvIf5WTvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('#tags').tagsInput();
</script>
@endsection