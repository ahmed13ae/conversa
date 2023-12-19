<x-profile :profileData="$profileData">
    <div class="list-group">
     
      @foreach ($followers as $follower)
        <a href="/profile/{{$follower->follower->username}}" class="list-group-item list-group-item-action">
          <img class="avatar-tiny" src="{{$follower->follower->avatar}}" />
          <strong>{{$follower->follower->username}}</strong>
        </a>
        @endforeach
    </div>
    </x-profile>