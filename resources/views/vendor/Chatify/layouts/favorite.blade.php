<div class="favorite-list-item">
    @if($user)
    <div class="avatar av-m" style="background-image: url('https://cellphones.com.vn/sforum/wp-content/uploads/2023/11/avatar-dep-38.jpg');">

</div>
        <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
    @endif
</div>
