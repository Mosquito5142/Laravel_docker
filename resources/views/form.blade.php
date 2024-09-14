@extends('layout')
@section('title','เขียนบทความ')
@section('content')
    <h2 class="text-center py-2">เขียนบทความ</h2>
    <form method="POST" action="/insert">
        @csrf
        <div class="form-group">
            <label for="title">ชื่อบทความ</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        @error('title')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mt-3">
            <label for="content">เนื้อหาบทความ</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
        </div>
        @error('content')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="mt-3">
            <input type="submit" value="บันทึก" class="btn btn-primary">
            <a href="{{ route('blog') }}" class="btn btn-success">บทความทั้งหมด</a>
        </div>
    </form>
@endsection