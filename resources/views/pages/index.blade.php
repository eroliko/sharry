@php use App\Http\Core\Mappers\GenderMapper; @endphp
@extends('main')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$error}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="col">
                <h2>Female actors upload</h2>
                @include('components.csv-upload-form', ['gender' => GenderMapper::GENDER_FEMALE])
            </div>
            <div class="col">
                <h2>Male actors upload</h2>
                @include('components.csv-upload-form', ['gender' => GenderMapper::GENDER_MALE])
            </div>
            <div class="col-xs-12">
                @include('components.shared-table', ['sharedMovies' => $sharedMoviesPaginator->items()])
                @include('components.pagination', ['paginator' => $sharedMoviesPaginator])
            </div>
            <div class="col-xs-12">
                @include('components.table', ['groups' => $groups])
            </div>
        </div>
    </div>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
        }

        .pagination li {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            padding: .375rem .75rem;
            font-size: 1rem;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            color: #000;
            background-color: #F8C229;
            border-color: #ffc107;
            margin-left: 0.1rem;
        }

        .pagination li a {
            text-decoration: none !important;
        }
    </style>
@endsection
