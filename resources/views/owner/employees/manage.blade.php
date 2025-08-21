@extends('layouts.app')

@section('content')
    {{-- Place the HTML code here --}}
    <div class="nk-content">
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-between flex-wrap gap g-2">
                                        <div class="nk-block-head-content">
                                            <h2 class="nk-block-title">Users List</h2>
                                                <nav>
                                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                        <li class="breadcrumb-item"><a href="#">User Manage</a></li>
                                                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="d-flex">
                                                <li>
                                                    <a href="#" class="btn btn-md d-md-none btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="btn btn-primary d-none d-md-inline-flex" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add User</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"><div class="dataTable-top"><div class="dataTable-dropdown"><label><select class="dataTable-selector"><option value="5">5</option><option value="10" selected="">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option></select> Per page</label></div><div class="dataTable-search"><input class="dataTable-input" placeholder="Search..." type="text"></div></div><div class="dataTable-container table-responsive"><table class="datatable-init table dataTable-table" data-nk-container="table-responsive">
                                            <thead class="table-light">
                                                <tr><th class="tb-col" data-sortable="" style="width: 36.425%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Users</span>
                                                    </a></th><th class="tb-col" data-sortable="" style="width: 19.3929%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Positions</span>
                                                    </a></th><th class="tb-col" data-sortable="" style="width: 15.0084%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Plans</span>
                                                    </a></th><th class="tb-col tb-col-xl" data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Billings</span>
                                                    </a></th><th class="tb-col tb-col-xxl" data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Joined Date</span>
                                                    </a></th><th class="tb-col" data-sortable="" style="width: 16.0202%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Status</span>
                                                    </a></th><th class="tb-col tb-col-end" data-sortable="false" style="width: 13.1535%;">
                                                        <span class="overline-title">Action</span>
                                                    </th></tr>
                                            </thead>
                                            <tbody><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle">
                                                                <img src="./images/avatar/a.jpg" alt="user">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Florenza Desporte</a>
                                                                <span class="small text">florenza@gmail.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Administrator</td><td class="tb-col">Basic</td><td class="tb-col tb-col-xl">Auto Debit</td><td class="tb-col tb-col-xxl">2022/04/25</td><td class="tb-col">
                                                        <span class="badge text-bg-warning-soft">Pending</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle">
                                                                <img src="./images/avatar/b.jpg" alt="user">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Anna Adame</a>
                                                                <span class="small text">anna@gmail.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Subscriber</td><td class="tb-col">Enterprise</td><td class="tb-col tb-col-xl">Manual - Paypal</td><td class="tb-col tb-col-xxl">2022/03/23</td><td class="tb-col">
                                                        <span class="badge text-bg-success-soft">Active</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                                <span class="smaller">SB</span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Sean Bean</a>
                                                                <span class="small text">sean@dellito.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Support</td><td class="tb-col">Enterprise</td><td class="tb-col tb-col-xl">Manual - Paypal</td><td class="tb-col tb-col-xxl">2022/01/22</td><td class="tb-col">
                                                        <span class="badge text-bg-secondary-soft">Inactive</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle">
                                                                <img src="./images/avatar/c.jpg" alt="user">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Wesley Burland</a>
                                                                <span class="small text">wesley@gmail.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Editor</td><td class="tb-col">Team</td><td class="tb-col tb-col-xl">Manual - Cash</td><td class="tb-col tb-col-xxl">2022/02/15</td><td class="tb-col">
                                                        <span class="badge text-bg-secondary-soft">Inactive</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle">
                                                                <img src="./images/avatar/d.jpg" alt="user">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Kamran Adil</a>
                                                                <span class="small text">adil@gmail.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Maintainer</td><td class="tb-col">Company</td><td class="tb-col tb-col-xl">Manual - Paypal</td><td class="tb-col tb-col-xxl">2022/04/15</td><td class="tb-col">
                                                        <span class="badge text-bg-warning-soft">Pending</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-danger-soft">
                                                                <span class="smaller">TB</span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Travus Bruntjen</a>
                                                                <span class="small text">travus@gmail.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Admin</td><td class="tb-col">Enterprise</td><td class="tb-col tb-col-xl">Manual - Cash</td><td class="tb-col tb-col-xxl">2022/02/21</td><td class="tb-col">
                                                        <span class="badge text-bg-success-soft">Active</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle">
                                                                <img src="./images/avatar/e.jpg" alt="user">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Saunder Offner</a>
                                                                <span class="small text">saunder@gmail.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Author</td><td class="tb-col">Basic</td><td class="tb-col tb-col-xl">Auto Debit</td><td class="tb-col tb-col-xxl">2022/04/15</td><td class="tb-col">
                                                        <span class="badge text-bg-warning-soft">Pending</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle">
                                                                <img src="./images/avatar/f.jpg" alt="user">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Melody Macy</a>
                                                                <span class="small text">melody@altbox.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Analyst</td><td class="tb-col">Basic</td><td class="tb-col tb-col-xl">Auto Debit</td><td class="tb-col tb-col-xxl">2022/04/15</td><td class="tb-col">
                                                        <span class="badge text-bg-warning-soft">Pending</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-warning-soft">
                                                                <span class="smaller">VK</span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Vladamir Koschek</a>
                                                                <span class="small text">vladamir@altbox.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Analyst</td><td class="tb-col">Basic</td><td class="tb-col tb-col-xl">Auto Debit</td><td class="tb-col tb-col-xxl">2022/04/15</td><td class="tb-col">
                                                        <span class="badge text-bg-warning-soft">Pending</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr><tr><td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                                <span class="smaller">SM</span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="./html/user-manage/user-profile.html" class="title">Stephen MacGilfoyle</a>
                                                                <span class="small text">stephen@altbox.com</span>
                                                            </div>
                                                        </div>
                                                    </td><td class="tb-col">Analyst</td><td class="tb-col">Basic</td><td class="tb-col tb-col-xl">Auto Debit</td><td class="tb-col tb-col-xxl">2022/04/15</td><td class="tb-col">
                                                        <span class="badge text-bg-warning-soft">Pending</span>
                                                    </td><td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-edit.html"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="./html/user-manage/user-profile.html"><em class="icon ni ni-eye"></em><span>View Details</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td></tr></tbody>
                                        </table></div><div class="dataTable-bottom"><div class="dataTable-info">Showing 1 to 10 of 24 entries</div><nav class="dataTable-pagination"><ul class="dataTable-pagination-list"><li class="active"><a href="#" data-page="1">1</a></li><li class=""><a href="#" data-page="2">2</a></li><li class=""><a href="#" data-page="3">3</a></li><li class="pager"><a href="#" data-page="2"><em class="icon ni ni-chevron-right"></em></a></li></ul></nav></div></div>
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
@endsection