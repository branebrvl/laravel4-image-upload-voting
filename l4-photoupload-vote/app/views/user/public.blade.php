@extends('layouts.main')

@section('title', $user->fullName)

@section('content')
<section class="user-profile">
<div class="container">
    <div class="row">
      <div class="media">
        <a href="#" class="pull-left"><img src="{{ $user->photocss }}" alt=""></a>
        <div class="media-body">
          <h2 class="render-title">{{ $user->fullName }}</h2>
          <ul>
            <li class="text-muted">
               <span class="time"></span> <b>Joined:</b> {{ $user->created_at->diffForHumans() }}
            </li>
          </ul>
        </div> <!-- / .media-body -->
        <table>
          <tr>
            <th>Total images:</th>
            <td>{{ count($images) }}</td>
          </tr>
          <tr>
            <th width="140">Last image:</th>
            <td>{{ $user->lastActivity($images) }}</td>
          </tr>
        </table>
      </div><!-- / .media -->
    </div><!-- / .row -->
    </div><!-- / .container -->
</section>
<section class="browse-recent">
  <div class="container">

    <h2 class="page-title">Submitted images</h2>

    <!-- grid -->
    @include('render.grid', ['images' => $images])

    <!-- Pagination -->
    @if($images->count()) 
        <div class="text-center"> 
          @if(isset($appends)) 
            {{ $images->appends($appends)->links(); }} 
          @else 
            {{ $images->links(); }} 
          @endif 
      </div> <!-- / pagination -->
    @endif 
  </div><!-- / .container -->
</section><!-- / .browse-recent -->
@stop
