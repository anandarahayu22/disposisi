<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>