@extends('layout/main')

@section('content')


    
    <div id="app" @if(isset($id)) data-id="{{ $id }}" @endif>
        <script src={{mix('js/event-create.js')}}></script>
    </div>
    

@endsection