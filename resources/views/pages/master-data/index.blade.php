@extends('layouts.app')

@section('title', 'Master Data')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    <a href="{{ route('masterdata.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Master Data</a></div>
                    <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                    <div class="breadcrumb-item">All Data</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Master Data</h2>
                <p class="section-lead">
                    You can manage all products and categories, such as editing, deleting and more.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('category_id') ? '' : 'active' }}"
                                            href="{{ route('masterdata.index') }}">All</a>
                                    </li>
                                    @foreach ($categories as $category)
                                        <li class="nav-item">
                                            <a class="nav-link {{ request('category_id') == $category->id ? 'active' : '' }}"
                                                href="{{ route('masterdata.index', ['category_id' => $category->id]) }}">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="nav-item ml-auto">
                                        <a href="{{ route('category.create') }}" class="nav-link active">+ Add New
                                            Category</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Data</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form action="{{ route('masterdata.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Search"
                                                value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>image</th>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <!-- Menampilkan nama kategori produk -->
                                                <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                                                <!-- Menampilkan harga dengan format 12.000 -->
                                                <td>{{ $product->stock }}</td>
                                                <td>
                                                    <img alt="image"
                                                        src="{{ asset('storage/products/' . $product->image) }}"
                                                        class="rounded-circle" width="35">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item active">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
