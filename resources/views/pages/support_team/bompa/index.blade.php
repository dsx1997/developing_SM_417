@extends('layouts.master')
@section('page_title', 'Manage Classes')
@section('content')

<style>
    .active-state{
        display: none;
    }
    .card{
        margin-top:50px;overflow:hidden;
        border:none !important;
        box-shadow: none !important;
    }
    .cardpos{
        position:fixed;width:100%;z-index:10;
    }
    .tabpos{
        margin-top: 62px;
    }
    .cardpos>li{
            width:180px;
        }
        .cardpos>li>a{
            text-align: center;
            padding:5px 10px;
        }
        table, th, td {
        border: 1px solid;
    }
    .edit{
        background-image: url('global_assets/images/edit.svg');
        background-repeat: no-repeat;
        width:16px;
        height: 16px;
    }
    .edit:hover{
        background-color: unset;
    }
    .card-body{
        padding:1.25rem 0 0 0 !important;
    }
    input, .select2-selection{
        background-color: #f1fcf1!important;
        height: 35px;
        font-size: 15px;
    }
    label{
        margin-bottom: 0 !important;
    }
</style>


    <div class="card"  style="background-color: whitesmoke">
        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight cardpos" style="transform:translateX(-2px);">
                @if ($types=="student" || $types == "staff" || $types=="teacher")
                    <li><a href="#all-classes" class="nav-link active" data-toggle="tab">View BOM/PA</a></li>
                @else
                    <li><a href="#all-classes" class="nav-link active" data-toggle="tab"><i class="icofont-gear"></i> Manage BOM/PA</a></li>
                    <li><a href="#new-user" class="nav-link" data-toggle="tab">+ Add BOM/PA</a></li>
                    <li><a href="#all-group" class="nav-link" data-toggle="tab"><i class="icofont-group"></i> BOM/PA Groups</a></li>
                @endif

            </ul>
            <div class="tab-content tabpos">
                <div class="tab-pane fade show active" id="all-classes">
                    {{-- <form class="bompa_search" action="{{ route('bompa_search') }}" method="post">
                        @csrf
                        <div class="row align-items-end justify-content-end">
                            <div class="col-md-8">
                                <label for="bompa_information">bompa</label>
                                <div class="input-group">

                                    <input class="form-control" type="text" id="bompa_information" name="bompa_information" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Search <i class="icon-search4 ml-2"></i></button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-primary" id="clickmeofbompa"><i class="icon-printer"></i> View Print Format</button>
                            </div>
                        </div>
                    </form> --}}
                    <div class="basic">
                        <div class="py-1 d-flex flex-row" style="background-color: white">
                            <div class="w-100 pl-2" style="text-align: left"><h4 style="font-weight: 700;font-size:1.2857rem">BOM/PA</h4></div>
                            <div class="w-100"></div>
                            <div class="input-group flex-shrink-1">
                                <input class="form-control border-end-0 border rounded-pill text-right" style="border-top-left-radius: 5px;border-bottom-left-radius:5px;"  type="text" placeholder="search" id="example-search-input">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-start-0 border rounded-pill ms-n3" style="border-top-right-radius: 5px;border-bottom-right-radius:5px;" type="button">
                                        <i class="icofont-search"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary border-start-0 border rounded-pill ms-n3 ml-2" style="background-color: #132A4E;color:white;border-radius:5px;" onclick="showPrint()" type="button">
                                        <i class="icofont-printer"></i> View Print Format
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-1" id="bompa_card">
                            <?php $num=0; ?>
                            @foreach ($all_bompa as $key => $bompa)
                                <div class="col-md-3" id="item{{ $num++ }}" aria-label="{{ str_replace(' ', '', $bompa->user->name) }}">
                                    <div class="card my-2">
                                        <div class="d-flex flex-row justify-content-start m-1">
                                                @if($bompa->user->user_type_id==4)
                                                    <span class='bg-success px-1'>Admin</span>
                                                @else
                                                    <br/>
                                                @endif
                                        </div>
                                        <div class="d-flex flex-column align-items-center welcome-pane">
                                            <img class="rounded-circle" src="/{{ $bompa->user->photo_by }}/{{ $bompa->user->photo }}" width="150" height="150"/>
                                            <div class="person" style="transform: translateY(-20px)">
                                                <div class="d-flex flex-row">
                                                    @if(Qs::userIsTeamSA())
                                                    <div class="rounded-circle ml-1" style="border-radius: 50%;padding:10px;background-color:green;">
                                                        <a href="{{ route('bompa.edit', $bompa->id) }}" class="dropdown-item p-0 edit" data-toggle="tooltip" data-placement="bottom" title="Edit"></a>
                                                    </div>
                                                        {{-- <a id="{{ $bompa->user->id }}" name={{ $bompa->user->name }} onclick="confirmCreate(this.id, this.name, '{{$bompa->user->user_type_id}}', 6)" class="dropdown-item">
                                                            @if ($bompa->user->user_type_id==4)
                                                                <i class="icon-user-minus"></i>
                                                            @else
                                                                <i class="icon-user-plus"></i>
                                                            @endif
                                                        </a> --}}
                                                    @endif
                                                    @if(Qs::userIsSuperAdmin())
                                                        <a id="{{ $bompa->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i></a>
                                                        <form method="post" id="item-delete-{{ $bompa->id }}" action="{{ route('bompa.destroy', $bompa->id) }}" class="hidden">@csrf @method('delete')</form>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-center" style="transform: translateY(-10px)">
                                                <h3 style="font-weight: 400">{{$bompa->user->name}}</h3>
                                                <h6>{{$bompa->user->email}}</h6>
                                                <h6 style="color:#2ea5de">{{$bompa->user->phone}}</>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <span class="active-state teacher_count">{{ count($all_bompa) }}</span>
                    <div class="print active-state"  style="background: white">
                        <div class="my-2 p-2">
                            <div class="w-100 pl-2" style="text-align: left"><h4>Show</h4></div>
                            <div class="d-flex justify-content-between ">
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <input type="checkbox" name="phone" id="phone" class="form-control" checked
                                            value="Show Phone Numbers" onclick="phoneCheck()" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="phone">Phone Numbers</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <input type="checkbox" name="national" id="national" class="form-control" checked
                                            value="Show National Id No." onclick="nationCheck()" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="gnation">National Id No</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <input type="checkbox" name="group" id="group" class="form-control"
                                            value="Show Groups" onclick="groupCheck()" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="group">Groups</label>
                                    </div>
                                </div>

                                {{-- <div class="d-flex justify-content-end">
                                    <button class="btn btn-dark p-1" ><i class="icon-printer"></i> Print</button>
                                    <button class="btn btn-dark ml-2 p-1" ><i class="icon-download"></i> Download</button>
                                </div> --}}
                            </div>
                        </div>
                        {{-- <br> --}}
                        <div class="d-flex flex-row mt-2 py-4" style="background: whitesmoke">
                            <div class="w-100" style="text-align:left">
                                <button class="btn" style="background-color: #b7c1d1;border-radius:5px;" onclick="showManageTeacher()">Close Print format</button>
                            </div>
                            <div class="flex-shrink-1">
                                <button class="btn btn-primary" style="background: #172b4c;border-radius:5px;" onclick="fnPrintReport(event)"><i class="icofont-printer"></i> Print </button>

                            </div>
                            <div class="flex-shrink-1 ml-2">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" style="background: #172b4c;border-radius:5px;" data-toggle="dropdown">
                                      Download
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" id="btnExport" onclick="fnExcelReport();">Download Excel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="printView">
                            <div class="d-flex align-items-center justify-content-between flex-row mt-2 p-3">
                                <div>
                                    {{-- <img class="mt-3" src="{{ asset('assets/images/school.png') }}" width="100" height="100"/> --}}
                                    <img class="mt-3" src="/school_number/{{ $user->school_logo }}" width="100" height="100"/>
                                </div>
                                <div class="text-center">
                                    <h2 style="font-weight: 600"> {{ $user->school_name }}</h2>
                                    <h4>BOM/PA List</h4>
                                </div>
                                <div class="text-right">
                                    <p style="font-weight: 600">{{ $user->school_postal }}</p>
                                    <p style="font-weight: 600">{{ $user->school_phone }}</p>
                                    <p style="font-weight: 600">{{ $user->school_email }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-row p-3" style="background-color: white">
                                <table id="printDatatable" class="table table-striped">
                                    <thead>
                                    <tr style="line-height:0.5">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="phone">Phone</th>
                                        <th>Personal Email</th>
                                        <th>Gender</th>
                                        <th>TSC No.</th>
                                        <th class="nation">National ID No.</th>
                                        <th class="group active-state">Groups</th>
                                        <th class="active-state">Role</th>
                                        <th class="active-state"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num=0; ?>
                                        @foreach ($all_bompa as $key => $bompa)
                                            <tr style="line-height: 0.5;">
                                                <td>{{++$num}}</td>
                                                <td>{{$bompa->user->name}}</td>
                                                <td class="phone">{{$bompa->user->phone}}</td>
                                                <td>{{$bompa->user->email}}</td>
                                                <td>{{$bompa->user->gender}}</td>
                                                <td>{{$bompa->user->tsc_no}}</td>
                                                <td class="nation">{{$bompa->user->national_id_no}}</td>
                                                {{-- <td class="group">@if($bompa->group_id != 0)
                                                    <span class="px-2" style="border-radius: 2px;background:#E4E6EF">{{$bompa->group->name}}</span>@endif</td>
                                                <td class="active-state">{{$bompa->user->user_type->name}}</td> --}}
                                                <td class="group active-state" style="text-align: center">
                                                    @if ($bompa->group_id!="")
                                                        <?php $bompas = explode(",",$bompa->group_id) ?>
                                                        @foreach ($all_group as $value)
                                                            @foreach ($bompas as $item)
                                                                @if ($item==$value->id)
                                                                    <div class="row">
                                                                        <span class="px-2 py-1 my-1" style="border-radius: 2px;background:#E4E6EF">{{ $value->name }}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="text-center active-state">
                                                    <div class="list-icons">
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                Action &nbsp;<i class="icon-menu9"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-left">
                                                                @if(Qs::userIsTeamSA())
                                                                <div class="rounded-circle ml-1" style="border-radius: 50%;padding:10px;background-color:green;">
                                                                    <a href="{{ route('bompa.edit', $bompa->id) }}" class="dropdown-item p-0" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="icon-pencil" style="margin:0px;background-color:green;"></i> Edit</a>
                                                                </div>
                                                                @endif
                                                                @if(Qs::userIsSuperAdmin())
                                                                <a id="{{ $bompa->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                                <form method="post" id="item-delete-{{ $bompa->id }}" action="{{ route('bompa.destroy', $bompa->id) }}" class="hidden">@csrf @method('delete')</form>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " style="text-align: left" id="new-user">
                    <div class="card p-2">
                        <b>Options</b>

                        <div class="row border-bottom">
                            <div class="form-check m-2">
                                <label class="form-check-label">
                              <input type="radio" class="form-check-input" id="select_by_key" name="bompa_member" value="key" checked>
                                Key in BOM/PA member details</label>
                            </div>
                            <div class="form-check m-2">
                                <label class="form-check-label">
                              <input type="radio" class="form-check-input" id="select_by_file" name="bompa_member" value="key">
                            Upload BOM/PA members from a spreadsheet</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="select_key px-2    " method="post" action="{{ route('bompa.store') }}">
                                @csrf
                                {{-- <h6>BOM/PA Data</h6> --}}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input value="{{ old('title') }}" required type="text" name="title" id="title" placeholder="Title" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Full Name</label>
                                            <input value="{{ old('full_name') }}" required type="text" name="full_name" id="full_name" placeholder="Full Name" class="form-control">
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input value="{{ old('email') }}" required type="text" name="email" id="email" placeholder="Email" class="form-control">
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input value="{{ old('phone_number') }}" class="form-control" placeholder="07## ### ###" name="phone_number" id="phone_number" type="text" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="gender">Gender</label>
                                        <select class="select form-control" id="gender" name="gender" data-fouc data-placeholder="Choose..">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="national_id_no">National ID No.</label>
                                            <input value="{{ old('national_id_no') }}" required type="text" name="national_id_no" id="national_id_no" placeholder="####" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="group">Group</label>
                                            <select class="select form-control" multiple id="group" name="group[]" data-fouc data-placeholder="Choose..">
                                                @foreach ($group as $key => $g)
                                                <option value="{{$g->id}}">{{$g->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" style="background:#2ea5de;line-height:1.35;border-radius:5px;"><i class="icofont-save mr-1" style="font-size: 0.7rem"></i>Add </button>
                                </div>
                            </form>
                            <form class="select_file pl-3 pr-1 active-state" action="{{ route('bompa_upload') }}" method="post">
                                @csrf
                                <div class="row">
                                    <a href="./download/Upload BOM-PA - Template.xlsx" download>Download <i class="icofont-download"></i></a>
                                       &nbsp;&nbsp;and fill the template then upload it below. (Please leave the column headers intact)
                                </div>
                                <div class="row">
                                    <input type="file" name="file_upload" id="file_upload" onchange="uploadFile_onChange(this, 2);">
                                </div>
                                <table class="my-2 table active-state" id="display_excel_data">
                                    {{-- <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>National Id No</th>
                                            <th>Group</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody> --}}
                                </table>
                                <div class="text-right my-2">
                                    <button type="submit" class="btn btn-success" style="background:#2ea5de;line-height:1.35;border-radius:5px;"> <i class="icofont-upload mr-1" style="font-size: 0.7rem"></i>Upload </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="all-group">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-primary">Name</th>
                            <th class="d-flex justify-content-center text-danger">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $len = count($all_group); $i = 0; ?>
                            @foreach ($all_group as $key => $group)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-start">
                                            <p style="margin: 0;">{{$group->name}}</p>
                                            <button class="btn btn-primary" title="Edit this user" onclick="editingGroupName('{{$group->name}}', this);">
                                                <img src="/global_assets/images/icon/edit.png" width="20" height="20"/> &nbsp; Edit
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <button class="list-icons-item btn btn-danger" onclick="deleteGroup('{{$group->id}}', this);" style="cursor: pointer; ">
                                                    <img src="/global_assets/images/icon/delete.png" width="20" height="20"/>&nbsp; Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="display: none; ">{{$group->id}}</td>
                                    {{-- {{ $group->id }} --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary my-2" style="float: right" data-toggle="modal" data-target="#myModal" >Add Group</button>
                </div>
            </div>
        </div>
    </div>

    <!-- create new group modal starts -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="noticeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #5dd1bb; color: black;">
                    <h5>Creat New Bom Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('new_group')}}">
                    <div class="modal-body">
                        <div class="form-group d-flex flex-column align-items-center">
                            <label for="group_name">Group Name </label>
                            <input type="text" name="group_name" id="group_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-theme">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- create new group modal ends -->
    @include('partials.js.class_index')
    @include('partials.js.group_index')
    {{-- <script>
        let bompa_table = document.querySelector('#bompa_table');
    let bompa_card = document.querySelector('#bompa_card');
    let clickmeofbompa = document.querySelector('#clickmeofbompa');
    clickmeofbompa.addEventListener('click', (e) => {
        e.preventDefault();

        if((' ' + bompa_card.className + ' ').indexOf('active-state')>0){
            bompa_card.classList.remove("active-state");
            bompa_table.classList.add("active-state");
            console.log('card', bompa_card.className);
            clickmeofbompa.innerHTML = '<i class="icon-printer"></i> View Print Format';
            clickmeofbompa.classList.remove('bg-secondary');
            clickmeofbompa.classList.add('bg-primary');
        }else{
            bompa_card.classList.add("active-state");
            bompa_table.classList.remove("active-state");
            console.log('table', bompa_card.className);
            clickmeofbompa.innerText = "Close Print Format"
            clickmeofbompa.classList.remove('bg-primary')
            clickmeofbompa.classList.add('bg-secondary');
        }

    });
    </script> --}}
@endsection
