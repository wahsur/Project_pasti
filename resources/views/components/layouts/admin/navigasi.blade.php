<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-primary"><b>PASTI</b></h1>
    <h2 class="text-justify text-muted"><b class="text-primary">Halo, </b>{{ auth()->user()->nama }}</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('profile') }}" class="btn btn-primary text-white">Profile</a>
        </div>
        <div class="btn-group">
            @livewire('logout-component')
        </div>
    </div>
</div>