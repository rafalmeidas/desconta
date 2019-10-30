@extends('site.layouts.app')

@section('title', 'Meu Perfil')

@section('content')

<h1>Meu Perfil</h1>
@include('includes.alerts')
<form action="{{ route('profile.update') }}" class="form" method="POST" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div>
        <label for="idname">Nome</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}" id="idname" placeholder="Nome" class="form-control">
    </div>

    <div class="form-group">
        <label for="idemail">E-mail</label>
        <input type="email" name="email" value="{{ auth()->user()->email }}" id="idemail" placeholder="E-mail" class="form-control">
    </div>

    <div class="form-group">
        <label for="idpassword">Senha</label>
        <input type="password" name="password" id="idpassword" placeholder="Senha" class="form-control">
    </div>

    <div class="form-group">
        <img src="/uploads/avatars/{{auth()->user()->image}}" style="max-width:30px;">
        <label for="idimage">Imagem</label>
        <input type="file" name="image" id="idimage" class="form-control">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Atualizar Perfil</button>
        <a href="{{route('admin.home')}}"><button type="button" class="btn btn-primary">Home</button></a>
    </div>

</form>
@endsection