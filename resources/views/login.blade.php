<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/gif" sizes="16x16">
    <title>منظومة التشغيل</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet"></head>
<body>
    <section>

  <div class="box">

    <div class="square" style="--i:0;"></div>
    <div class="square" style="--i:1;"></div>
    <div class="square" style="--i:2;"></div>
    <div class="square" style="--i:3;"></div>
    <div class="square" style="--i:4;"></div>
    <div class="square" style="--i:5;"></div>

    <div class="container2">
      <div class="form">
          @csrf
        <h2>Marine Co System</h2>
        <form  id="myform" method="POST">
          <div class="inputBx">
            <input type="text" required="required" id="username" name="username">
            <span>Username</span>
            <i class="fas fa-user-circle"></i>
          </div>
          <div class="inputBx password">
            <input id="password-input" type="password" name="password" required="required">
            <span>Password</span>
            <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
            <i class="fas fa-key"></i>
          </div>
          <div class="inputBx">
          <button  id="btn-save" class="btn-submit" type="submit">Login</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</section>
<script src="{{ asset('js/showPassword.js') }}"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://kit.fontawesome.com/715e93c83e.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/mgalante/jquery.redirect@master/jquery.redirect.js"></script>
<script>
        $("#btn-save").click(function(e) {
            $("#myform").validate({
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                },
                highlight: function(input) {
                    $(input).addClass('error_input');
                },
                unhighlight: function(input) {
                    $(input).removeClass('error_input');
                },
                errorPlacement: function(error, element) {
                    $(element).append(error);
                },
                submitHandler: function() {
                    e.preventDefault();
                    var formData = {
                        username: $("#username").val(),
                        password: $("#password-input").val(),
                    };
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '/login',
                        data: formData,
                        dataType: "json",
                        encode: true,
                        error: function(xhr, status, error) {
                            var msg = (xhr.responseText);
                            if (xhr.status != 422) {
                                msg = 'اعد المحاولة مرة أخرى';
                            }
                            $.alert({
                                title: '',
                                type: 'red',
                                content: msg,
                                icon: 'fa fa-warning',
                                confirm: function() {
                                    alert('Confirmed!');
                                },
                            })
                        },
                        success: function(data) {
                            $.confirm({
                                title: formData.username,
                                icon: 'fa fa-thumbs-up',
                                content: 'تم  تسجيل الدخول  بنجاح',
                                type: 'green',
                                rtl: true,
                                closeIcon: false,
                                draggable: true,
                                dragWindowGap: 0,
                                typeAnimated: true,
                                theme: 'supervan',
                                autoClose: 'okAction|3000',
                                buttons: {
                                    okAction: {
                                        text: 'ok',
                                        action: function() {
                                            $.redirect(
                                                "{!! route('/') !!}",
                                                "",
                                                "GET", "");
                                        }
                                    },
                                }
                            })
                        }
                    })
                }
            })
        });
</script>
</body>
</html>