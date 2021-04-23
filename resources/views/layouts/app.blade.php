<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    @livewireStyles
    @include('sweetalert::alert')

</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')


    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ url('js/script.js') }}" defer></script>
    @livewireScripts

    <script type="text/javascript">

    $(function() {
        //department
        var table = $('.datatable-department').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{ route('department') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'departments_name',
                    name: 'departments_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

    });
    $(function() {
        //user
        var table = $('.datatable-users').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{ route('users.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
    </script>
    <script type="text/javascript">


    //user

    $(document).ready(function() {
        $(".btn-submit").click(function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var email = $("#email").val();
            var name = $("#name").val();
            var id = $("#id").val();
            if (name == '') {
                $('#validateName').html('The name field is required.').css('color', 'red')
            } else {
                $('#validateName').html('')
            }
            if (email == '') {
                $('#validateEmail').html('The email field is required.').css('color', 'red')
            } else {
                $('#validateEmail').html('')
            }

            $.ajax({
                url: "{{ route('users.Save') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id: id,
                    email: email,
                    name: name
                },
                success: function(data) {
                    printMsgUser(data);
                }
            });
        });

        function printMsgUser(msg) {
            if ($.isEmptyObject(msg.error)) {
                console.log(msg.success);
                $('.alert-block').css('display', 'block').append('<strong>' + msg.success + '</strong>');
            } else {
                $('.alert-block').css('display', 'block').append('<strong>' + msg.error + '</strong>');
                $.each(msg.error, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        }
    });

    function Del(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "error",
            showCancelButton: true,
            dangerMode: true,
            cancelButtonClass: '#DD6B55',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete!',
        }, function(result) {
            if (result) {

                var _token = $("meta[name='csrf-token']").attr('content');
                var _id = id;

                $('.odd').addClass('Del-' + _id);
                $.ajax({
                    url: "{{ route('users.Del') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        _thisid: _id
                    },
                    success: function(data) {
                        printDel(data);
                    }
                });

            }
        })
    }

    function printDel(msg) {
        if ($.isEmptyObject(msg.error)) {
            console.log(msg.success);
            $('.Delalert-block').css('display', 'block').append('<strong>' + msg.success + '</strong>');
           
            setTimeout(function(){
                
                location.reload(true);
                
                },1000);

        } else {
            $('.Delalert-block').css('display', 'block').append('<strong>' + msg.error + '</strong>');
        }

    }



    //department

    $(document).ready(function() {
        $(".btn-submit-department").click(function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var departments_name = $("#departments_name").val();
            if (departments_name == '') {
                $('#validateNameAdd').html('The name field is required.').css('color', 'red')
            } else {
                $('#validateNameAdd').html('')
            }

            $.ajax({
                url: "{{ route('department.adddepartment') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    departments_name: departments_name
                },
                success: function(data) {
                    printMsgAdd(data);
                }
            });
        });

        
        function printMsgAdd(msg) {
            if ($.isEmptyObject(msg.error)) {
                console.log(msg.success);
                $('.alert-add-block').css('display', 'block').append('<strong>' + msg.success + '</strong>');
            } else {
                $('.alert-add-block').css('display', 'block').append('<strong>' + msg.error + '</strong>');
                $.each(msg.error, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        }
    })




    $(document).ready(function() {
        $(".btn-submit-department").click(function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var departments_name = $("#departments_name").val();
            var id = $("#id").val();
            if (departments_name == '') {
                $('#validateName').html('The name field is required.').css('color', 'red')
            } else {
                $('#validateName').html('')
            }

            $.ajax({
                url: "{{ route('department.Save') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id: id,
                    departments_name: departments_name
                },
                success: function(data) {
                    printMsgUser(data);
                }
            });
        });

        function printMsgUser(msg) {
            if ($.isEmptyObject(msg.error)) {
                console.log(msg.success);
                $('.alert-block').css('display', 'block').append('<strong>' + msg.success + '</strong>');
            } else {
                $('.alert-block').css('display', 'block').append('<strong>' + msg.error + '</strong>');
                $.each(msg.error, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        }
    });

    function Del_department(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "error",
            showCancelButton: true,
            dangerMode: true,
            cancelButtonClass: '#DD6B55',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete!',
        }, function(result) {
            if (result) {

                var _token = $("meta[name='csrf-token']").attr('content');
                var _id = id;

                $('.odd').addClass('Del-' + _id);
                $.ajax({
                    url: "{{ route('department.Del') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        _thisid: _id
                    },
                    success: function(data) {
                        printDel_dpartment(data);
                    }
                });

            }
        })
    }

    function printDel_dpartment(msg) {
        if ($.isEmptyObject(msg.error)) {
            console.log(msg.success);
            $('.Delalert-block').css('display', 'block').append('<strong>' + msg.success + '</strong>');
           
            setTimeout(function(){
                
                location.reload(true);
                
                },1000);

        } else {
            $('.Delalert-block').css('display', 'block').append('<strong>' + msg.error + '</strong>');
        }

    }

    </script>
</body>

</html>