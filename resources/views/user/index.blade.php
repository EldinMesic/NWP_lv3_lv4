<x-layout>
    <div class="user-container">
        <div class="users">
            @foreach ($users as $user)
            <div class="user">
                <div class="user-body">
                    <h1>{{ $user->name }}</h1>
                </div>
            </div>   
            <br>
            @endforeach
        </div>
    </div>
</x-layout>
