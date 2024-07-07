@extends('User.LayoutTrangChu')

@section('content')
<!-- user infor -->
@if (session('notice'))
<div class="alert alert-success alert-dismissible" style="width:20%;position:absolute;right:20px;top:170px">
    <p>{{ session('notice') }}</p>
    <button class="btn btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
<div class="row g-3 align-items-center mx-auto pdt" style="margin-top:50px">
    <div class="col-3">
        <div class="card border-0 ">
            <img src="../assets/img/avatar-trang-99.jpg" class="card-img-top rounded-circle w-50 mx-auto" alt="">
            <div class="card-body text-center">
                <h5 class="card-title"></h5>
                <p class="card-text">

                </p>

            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="container">
            <form name="frmChange" method="post" action="{{ route('user.changePass') }}">
                @csrf
                @method('PUT')
                <h2 class="text-center" style="color:#EA9E1E">Đổi mật khẩu</h2>
                <div>
                    <div class="row">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <span id="currentPassword" class="validation-message"></span> <input type="password"
                            placeholder="Nhập mật khẩu" name="currentPass" class="form-control" required>
                        @if (session('errorPass'))
                        <p id="pass_error" class="text-danger">{{ session('errorPass') }} </p>
                        @endif


                    </div>
                    <div class="row">
                        <label class="form-label">Mật khẩu mới</label> <span id="newPassword"
                            class="validation-message"></span><input class="form-control" required type="password"
                            name="newPass" placeholder="Nhập mật khẩu mới" class="full-width">
                        @error('newPass')
                        <p id="pass_error" class="text-danger">{{ $message }} </p>
                        @enderror

                    </div>
                    <div class="row mt-2">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <span id="confirmPassword" class="validation-message"></span><input class="form-control"
                            type="password" required name="confirmPass" class="full-width"
                            placeholder="Nhập lại mật khẩu">
                        @error('confirmPass')
                        <p id="pass_error" class="text-danger">{{ $message }} </p>
                        @enderror

                    </div>
                    <div class="row mt-3">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary" class="full-width">Xác
                            nhận</button>
                    </div>
                </div>

            </form>
        </div>
    </div>


</div>

<script>
    $(document).ready(function() {

        $("#confirm_pass_error").hide();
    })
</script>
<!--footer end-->
@endsection