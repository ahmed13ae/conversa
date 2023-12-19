<x-profile :profileData="$profileData">
    <div class="list-group">
        @foreach ($posts as $post)
            <x-post :post="$post" hideAuthor />
        @endforeach
    </div>
</x-profile>
  