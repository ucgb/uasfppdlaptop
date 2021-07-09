{{-- resources/views/post/list.blade.php --}}
@extends('layouts.app')

@section('title')
Home
@endsection


@section('content')
<div class="container">
  <br>
    <div class="row justify-content-center">
    	<div class="col-md-6 table-responsive">
    		<h2>Aplikasi Data Laptop</h2>
        </div>

          @forelse ($posts as $post)

          @empty
              <tr>
              <td colspan="4"><center>No data found</center></td>
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
