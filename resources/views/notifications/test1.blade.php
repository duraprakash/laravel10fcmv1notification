<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test FCM Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Test FCM Notification</h1>
        <form id="notificationForm">
            @csrf
            <div class="mb-3">
                <label for="token" class="form-label">Device Token</label>
                <input type="text" class="form-control" id="token" name="token" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <input type="text" class="form-control" id="body" name="body" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data (JSON)</label>
                <textarea class="form-control" id="data" name="data" rows="3"
                    placeholder='{"key1":"value1","key2":"value2"}'></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Notification</button>
        </form>
        <div id="response" class="mt-4"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#notificationForm').on('submit', function (e) {
                e.preventDefault();

                const formData = {
                    token: $('#token').val(),
                    title: $('#title').val(),
                    body: $('#body').val(),
                    data: $('#data').val() ? JSON.parse($('#data').val()) : {},
                };

                $.ajax({
                    url: '/api/send-notification',
                    method: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function (response) {
                        $('#response').html(`<div class="alert alert-success">${response.message}</div>`);
                    },
                    error: function (xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'An error occurred.';
                        $('#response').html(`<div class="alert alert-danger">${errorMessage}</div>`);
                    }
                });
            });
        });
    </script>
</body>

</html>