@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="col-12"><input id="searchbar_toggle" type="checkbox" />
                <div id="searchbar" class="mb-4">
                    <div class="form-group col-lg-2 me-2 mb-lg-0 mb-3">
                        <select id="search_col" onchange="searchChange()" class="form-select form-select-sm">
                            <option value="Brand.id" data-type="number" {{request()->input('sc') == 'Brand.id' ? 'selected' : ''}}>Brand Id</option>
                            <option value="Brand.name" {{request()->input('sc') == 'Brand.name' ? 'selected' : ''}}>Brand Name</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 me-2 mb-lg-0 mb-3">
                        <select id="search_oper" class="form-select form-select-sm">
                            <option value="c" {{request()->input('so') == 'c' ? 'selected' : ''}}>Contains</option>
                            <option value="e" {{request()->input('so') == 'e' ? 'selected' : ''}}>Equals</option>
                            <option value="g" {{request()->input('so') == 'g' ? 'selected' : ''}}>&gt;</option>
                            <option value="ge" {{request()->input('so') == 'ge' ? 'selected' : ''}}>&gt;&#x3D;</option>
                            <option value="l" {{request()->input('so') == 'l' ? 'selected' : ''}}>&lt;</option>
                            <option value="le" {{request()->input('so') == 'le' ? 'selected' : ''}}>&lt;&#x3D;</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2 me-2 mb-lg-0 mb-3">
                        <input id="search_word" autocomplete="off" onkeyup="search(event)" value="{{request()->input('sw')}}" class="form-control form-control-sm" />
                    </div>
                    <div class="col">
                        <button class="btn btn-primary btn-sm" onclick="search()">Search</button>
                        <button class="btn btn-secondary btn-sm" onclick="clearSearch()">Clear</button>
                    </div>
                </div>
                <table class="table table-sm table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="@getSortClass(Brand.id,asc)"><a href="@getLink(sort,brands,Brand.id,asc)">Id</a></th>
                            <th class="@getSortClass(Brand.name)"><a href="@getLink(sort,brands,Brand.name)">Name</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                        <tr>
                            <td class="text-center">{{$brand->id}}</td>
                            <td>{{$brand->name}}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-secondary" href="/brands/{{$brand->id}}" title="View"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-sm btn-primary" href="/brands/{{$brand->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                <form action="/brands/{{$brand->id}}" method="POST">
                                    @method("DELETE")
                                    @csrf
                                    <a class="btn btn-sm btn-danger" href="#!" onclick="deleteItem(this)" title="Delete"><i class="fa fa-times"></i></a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row mb-1">
                    <div class="col-md-3 col-6">
                        <label>Show
                            <select id="page_size" onchange="location = this.value">
                                <option value="@getLink(size,brands,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                                <option value="@getLink(size,brands,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                                <option value="@getLink(size,brands,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                            </select>
                            entries
                        </label>
                    </div>
                    <div class="col-md-9 col-6">
                        <div class="float-right d-none d-md-block">
                            <ul class="pagination flex-wrap">
                                <li class="page-item{{$brands->currentPage() <= 1 ? ' disabled' : ''}}"><a class="page-link" href="@getLink(page,brands,$brands->currentPage()-1)">Prev</a></li>
                                @for ($page = 1; $page <= $brands->lastPage(); $page++)
                                <li class="page-item{{$brands->currentPage() == $page ? ' active' : ''}}"><a class="page-link" href="@getLink(page,brands,$page)">{{$page}}</a></li>
                                @endfor
                                <li class="page-item{{$brands->currentPage() >= $brands->lastPage() ? ' disabled' : ''}}"><a class="page-link" href="@getLink(page,brands,$brands->currentPage()+1)">Next</a></li>
                            </ul>
                        </div>
                        <div class="float-right d-block d-md-none">
                            <label> Page
                                <select id="page_index" onchange="location = this.value">
                                    @for ($page = 1; $page <= $brands->lastPage(); $page++)
                                    <option value="@getLink(page,brands,$page)" {{$brands->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                                    @endfor
                                </select>
                            </label> of <span>{{$brands->lastPage()}}</span>
                            <div class="btn-group">
                                <a class="btn btn-primary btn-sm{{$brands->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,brands,$brands->currentPage()-1)"><i class="fa fa-chevron-left"></i></a>
                                <a class="btn btn-primary btn-sm{{$brands->currentPage() >= $brands->lastPage() ? ' disabled' : ''}}" href="@getLink(page,brands,$brands->currentPage()+1)"><i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-sm btn-primary" href="/brands/create">Create</a>
            </div>
            <style>
                #searchbar_toggle_menu { display: inline-flex!important }
            </style>
        </div>
    </div>
</div>
<script>
    initPage()
</script>
@endsection