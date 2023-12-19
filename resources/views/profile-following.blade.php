<x-profile :profileData="$profileData">
    <div class="list-group">
 
      @foreach ($followeds as $followed)
        <a href="/profile/{{$followed->followed->username}}" class="list-group-item list-group-item-action">
          <img class="avatar-tiny" src="{{$followed->followed->avatar}}" />
          <strong>{{$followed->followed->username}}</strong> 
        </a>
        @endforeach
    </div>
    </x-profile>