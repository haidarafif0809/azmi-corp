@extends('layouts.app')

@section('content')
<transition name="fade">
<router-view></router-view>
</transition>
@endsection
