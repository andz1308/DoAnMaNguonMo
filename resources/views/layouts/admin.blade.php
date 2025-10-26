<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
   <script>
    ClassicEditor
        .create( document.querySelector( '#mo_ta' ) ) // Chọn textarea có id="MoTa"
        .catch( error => {
            console.error( error );
        } );
</script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
    </nav>

    <div class="container mt-4">
        {{-- Hiển thị thông báo thành công --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
    ClassicEditor
        .create( document.querySelector( '#mo_ta' ) ) // Tìm textarea có id="MoTa"
        .then( editor => {
            console.log( 'CKEditor was initialized', editor );
        } )
        .catch( error => {
            console.error( 'Error initializing CKEditor', error );
        } );
</script>
</body>

</html>