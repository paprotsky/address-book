@extends('layouts.app')

@section('content')

<el-main>
    <el-row type="flex" class="row-bg" justify="center">
        <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="10">
            <el-card class="box-card login-form">
                <div slot="header" class="clearfix">
                    <span>Login</span>
                </div>
                <el-form label-width="120px" label-position="right" method="POST" action="{{ route('login') }}">
                    @csrf
                    <el-form-item label="Email">
                        <el-input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus auto-complete="off"></el-input>
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
                    <el-form-item>
                        <el-button native-type="submit" type="primary">Login</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
</el-main>

@endsection
