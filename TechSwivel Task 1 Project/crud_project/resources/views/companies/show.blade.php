@extends('layouts.app')

@section('title', 'View Company')

@section('content')

    <div class="card">
        <div class="card-header">View Company</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $company->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $company->email ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Website</dt>
                <dd class="col-sm-9">
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                    @else
                        N/A
                    @endif
                </dd>
            </dl>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

@endsection