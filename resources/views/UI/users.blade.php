@extends('UI.base.main')
@section('content')
    <div class="mb-6">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Create New User
        </a>
    </div>
    <table id="users" class="display">
    </table>

    @push('scripts')
        <script>
            const editRoute = "{{ route('users.edit',['user' => '::ID']) }}";
            $(document).ready(function() {
                let columns = [{
                        "data": "profile_image",
                        "title": "Profile Image",
                        "orderable": false,
                        "render": function(data, type, full, meta) {
                            if (data) {
                                return `<img src=${data} height=\"50\">`;
                            } else {
                                return "-"
                            }

                        }
                    }, {
                        "data": "email",
                        "title": "Email"
                    },
                    {
                        "data": "name",
                        "title": "Name",
                    },
                    {
                        "data": "phone_number",
                        "title": "Phone Number"
                    },
                    {
                        "data": "id",
                        "title": "Action",
                        "orderable": false,
                        'render': function(data, type, full, meta) {
                            return `<a href="${editRoute.replace('::ID',data)}" class="btn btn-primary">Edit</a>`;

                        }
                    },
                ];

                var table = $('#users').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "order": [], //no default sorting
                    "ajax": {
                        "url": "{{ route('users.api') }}",
                        "type": "GET",
                        "dataFilter": function(json) {
                            let jsonData = jQuery.parseJSON(json);
                            jsonData.recordsTotal = jsonData.total;
                            jsonData.recordsFiltered = jsonData.total;
                            return JSON.stringify(jsonData);
                        },
                        "data": function(data) {
                            data.page = Math.floor(data.start / data.length) + 1;
                            data.per_page = data.length;
                            if (data.order.length > 0) {
                                data.sort_field = columns[data.order[0].column].data;
                                data.sort_order = data.order[0].dir;
                            }
                            if (data.search.value != '') {
                                data.search = data.search.value;
                            } else {
                                data.search = '';
                            }


                            return data;
                        }
                    },
                    "columns": columns,
                });
            });
        </script>
    @endpush
@endsection
