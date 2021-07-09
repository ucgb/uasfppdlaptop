@extends('layouts.app')

@section('merk')
My Post
@endsection

@section('content')
<div class="container">
  <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Data Laptop</h2>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a href="http://127.0.0.1:8000/pdf" class="btn btn-danger"><i class="fa fa-plus"></i> Cetak Data</a>
            </div>


        </div>
        <br>
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Merk Laptop</th>
                <th>Seri Laptop</th>
                <th>Tahun Terbit</th>
                <th>Posted Date</th>
                <th>Updated</th>
                <th>Action</th>
              </tr>
        </thead>
        <tbody>
          @forelse ($posts as $post)
              <tr>
              <th>{{ $post->merk }}</th>
              <td>{{ $post->seri }}</td>
              <td>{{ $post->tahun }}</td>
              <td>{{ $post->created_at }}</td>
              <td>{{ $post->updated }}</td>
              <td>
                <div class="action_btn">
                  <div class="action_btn">
                    <a href="{{ route('post.edit', $post->id)}}" class="btn btn-warning btn-sm my-button">Edit</a>
                  </div>
                  <div class="action_btn margin-left-10">
                    <form action="{{ route('post.destroy', $post->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                    <form action="/upload-file" method="POST" enctype="multipart/formdata">
  @csrf
  <input type="file" name="berkas">
  <input type="submit" value="Unggah">
</form>

                  </div>
                </div>
              </td>
            </tr>
          @empty
              <tr>
              <td colspan="4"><center>No post found</center></td>
            </tr>
          @endforelse
        </tbody>
      </table>
       {{-- pagination --}}
       {{ $posts->appends(Request::all())->links() }}
        </div>
    </div>
</div>
<x-footer />
@endsection
