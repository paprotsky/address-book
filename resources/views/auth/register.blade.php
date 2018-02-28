@extends('layouts.app')

@section('content')

<el-main>
    <el-row type="flex" class="row-bg" justify="center">
        <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="10">
            <el-card class="box-card login-form">
                <div slot="header" class="clearfix">
                    <span>Register</span>
                </div>
                <el-form label-width="140px" label-position="right" method="POST" action="{{ route('register') }}">
                    @csrf
                    <el-form-item label="Name">
                        <el-input id="name" native-type="text" name="name" value="{{ old('email') }}" required autofocus auto-complete="off"></el-input>
                        @if ($errors->has('name'))
                            <el-alert
                              title="Oops!"
                              type="error">
                              {{ $errors->first('name') }}
                            </el-alert>
                        @endif
                    </el-form-item>
                    <el-form-item label="Email">
                        <el-input id="email" native-type="email" name="email" value="{{ old('email') }}" required autofocus auto-complete="off"></el-input>
                        @if ($errors->has('email'))
                            <el-alert
                              title="Oops!"
                              type="error">
                              {{ $errors->first('email') }}
                            </el-alert>
                        @endif
                    </el-form-item>
                    <el-form-item label="Password">
                        <el-input id="password" type="password" name="password" required auto-complete="off"></el-input>
                        @if ($errors->has('password'))
                            <el-alert
                              title="Oops!"
                              type="error">
                              {{ $errors->first('password') }}
                            </el-alert>
                        @endif
                    </el-form-item>
                    <el-form-item label="Confirm Password">
                        <el-input id="password-confirm" type="password" name="password_confirmation" required auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button native-type="submit" type="primary">Register</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
</el-main>

@endsection
