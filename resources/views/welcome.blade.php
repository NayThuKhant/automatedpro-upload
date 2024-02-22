<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Example in Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<form id="uploadForm" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="file">
    <button type="button" id="submit">Upload</button>
</form>
<div id="imageContainer"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#submit').click(function (event) {
            event.preventDefault();

            // Create a new FormData object
            var formData = new FormData();

            // Append the file data to the FormData object
            formData.append('file', $('#file')[0].files[0]);

            $.ajax({
                url: '{{ route("images.store") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#imageContainer').html('<img src="' + response + '" alt="Uploaded Image">');
                    alert("Uploaded Successfully");
                },
                error: function (xhr, status, error) {

                    let validationError = "";

                    const errors = xhr.responseJSON.errors;
                    const errorList = [];

                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorList.push(errors[field][0]);
                        }
                    }

                    validationError = errorList.join('\n');
                    alert(validationError);
                }
            });
        });
    });

</script>
</body>
</html>
