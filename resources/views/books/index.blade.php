@extends('layouts.app')
@section('head')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>{{ __('Book List') }}</div>
                        <add-book-button></add-book-button>
                    </div>
                    <div class="card-body">
                        <table id="listBookDataTable" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td>{{$book->judul}}</td>
                                    <td>{{$book->stok}}</td>
                                    <td>
                                        <img src="{{$book->gambar ? '/storage/'.$book->gambar : '/images/empty.jpg'}}"
                                             alt="book-image" class="img-thumbnail" style="width: 100px"/>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <edit-book-button :origin="{{$book}}"></edit-book-button>
                                            <form method="post" action="{{route('buku.destroy', [ $book->id])}}"
                                                  onsubmit="return confirm('{{ __('Are you sure you want to :do?', [ 'do' => __('Delete') ]) }}');"
                                            >
                                                @csrf
                                                <button class="btn btn-danger btn-sm" name="_method" value="DELETE">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Judul</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <book-form></book-form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#listBookDataTable').DataTable();
        });
    </script>
@endsection
