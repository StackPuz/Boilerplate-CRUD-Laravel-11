@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="col-12"><input id="searchbar_toggle" type="checkbox" />
                <div id="searchbar" class="mb-4">
                    <div class="form-group col-lg-2 me-2 mb-lg-0 mb-3">
                        <select id="search_col" onchange="searchChange()" class="form-select form-select-sm">
                            <option value="OrderHeader.id" data-type="number" {{request()->input('sc') == 'OrderHeader.id' ? 'selected' : ''}}>Order Header Id</option>
                            <option value="Customer.name" {{request()->input('sc') == 'Customer.name' ? 'selected' : ''}}>Customer Name</option>
                            <option value="OrderHeader.order_date" data-type="date" {{request()->input('sc') == 'OrderHeader.order_date' ? 'selected' : ''}}>Order Header Order Date</option>
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
                            <th class="@getSortClass(OrderHeader.id,asc)"><a href="@getLink(sort,orderHeaders,OrderHeader.id,asc)">Id</a></th>
                            <th class="@getSortClass(Customer.name) d-none d-md-table-cell"><a href="@getLink(sort,orderHeaders,Customer.name)">Customer</a></th>
                            <th class="@getSortClass(OrderHeader.order_date)"><a href="@getLink(sort,orderHeaders,OrderHeader.order_date)">Order Date</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderHeaders as $orderHeader)
                        <tr>
                            <td class="text-center">{{$orderHeader->id}}</td>
                            <td class="d-none d-md-table-cell">{{$orderHeader->customer_name}}</td>
                            <td class="text-center">{{$orderHeader->order_date}}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-secondary" href="/orderHeaders/{{$orderHeader->id}}" title="View"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-sm btn-primary" href="/orderHeaders/{{$orderHeader->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                <form action="/orderHeaders/{{$orderHeader->id}}" method="POST">
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
                                <option value="@getLink(size,orderHeaders,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                                <option value="@getLink(size,orderHeaders,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                                <option value="@getLink(size,orderHeaders,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                            </select>
                            entries
                        </label>
                    </div>
                    <div class="col-md-9 col-6">
                        <div class="float-right d-none d-md-block">
                            <ul class="pagination flex-wrap">
                                <li class="page-item{{$orderHeaders->currentPage() <= 1 ? ' disabled' : ''}}"><a class="page-link" href="@getLink(page,orderHeaders,$orderHeaders->currentPage()-1)">Prev</a></li>
                                @for ($page = 1; $page <= $orderHeaders->lastPage(); $page++)
                                <li class="page-item{{$orderHeaders->currentPage() == $page ? ' active' : ''}}"><a class="page-link" href="@getLink(page,orderHeaders,$page)">{{$page}}</a></li>
                                @endfor
                                <li class="page-item{{$orderHeaders->currentPage() >= $orderHeaders->lastPage() ? ' disabled' : ''}}"><a class="page-link" href="@getLink(page,orderHeaders,$orderHeaders->currentPage()+1)">Next</a></li>
                            </ul>
                        </div>
                        <div class="float-right d-block d-md-none">
                            <label> Page
                                <select id="page_index" onchange="location = this.value">
                                    @for ($page = 1; $page <= $orderHeaders->lastPage(); $page++)
                                    <option value="@getLink(page,orderHeaders,$page)" {{$orderHeaders->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                                    @endfor
                                </select>
                            </label> of <span>{{$orderHeaders->lastPage()}}</span>
                            <div class="btn-group">
                                <a class="btn btn-primary btn-sm{{$orderHeaders->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,orderHeaders,$orderHeaders->currentPage()-1)"><i class="fa fa-chevron-left"></i></a>
                                <a class="btn btn-primary btn-sm{{$orderHeaders->currentPage() >= $orderHeaders->lastPage() ? ' disabled' : ''}}" href="@getLink(page,orderHeaders,$orderHeaders->currentPage()+1)"><i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-sm btn-primary" href="/orderHeaders/create">Create</a>
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