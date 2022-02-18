<div class="text-center">
    <h1>PAGE CLIENT</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-danger">deconnexion</button>
    </form>
</div>