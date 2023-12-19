<x-layout docTitle="{{$profileData['user']->username}}'s profile">
    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="{{$profileData['user']->avatar}}" /> {{$profileData['user']->username}}
          @auth
          {{-- show or don't show the follow button logic --}}
          @if (!$profileData['followCheck'] AND auth()->user()->id != $profileData['user']->id)
          <form class="ml-2 d-inline" action="/create-follow/{{$profileData['user']->username}}" method="POST">
            @csrf
            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
          </form>
          @endif
          @if ($profileData['followCheck'])
          <form class="ml-2 d-inline" action="/remove-follow/{{$profileData['user']->username}}" method="POST">
            @csrf
                <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
          </form>
          @endif
          @if (auth()->user()->username==$profileData['user']->username)
            <a href="/manage-avatar" class="btn btn-secondary  btn-sm">Manage avatar</a>
                
            @endif
          
          @endauth
          
        </h2>
    
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/profile/{{$profileData['user']->username}}" class="profile-nav-link nav-item nav-link {{Request::segment(3)==""? "active" : ""}}">Posts: {{$profileData['postsCount']}}</a>
          <a href="/profile/{{$profileData['user']->username}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3)=="followers"? "active" : ""}}">Followers: {{$profileData['followersCount']}}</a>
          <a href="/profile/{{$profileData['user']->username}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3)=="following"? "active" : ""}}">Following: {{$profileData['followedsCount']}}</a>
        </div>
        <div class="content-slot">
            {{$slot}}
        </div>
        
      </div>
    </x-layout>