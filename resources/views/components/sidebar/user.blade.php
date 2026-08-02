<div class="sidebar-user">

    <div class="user-avatar">

        {{ strtoupper(substr(auth()->user()->name ?? 'G',0,1)) }}

    </div>

    <div class="user-info">

        <div class="user-name">

            {{ auth()->user()->name ?? 'Guest' }}

        </div>

        <div class="user-role">

            {{ auth()->user()?->roles->first()?->name ?? 'Visitor' }}

        </div>

    </div>

</div>
